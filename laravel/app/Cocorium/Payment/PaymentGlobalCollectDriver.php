<?php namespace Cocorium\Payment;

use Guzzle\Log\MonologLogAdapter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
class PaymentGlobalCollectDriver implements PaymentInterface
{

    protected $merchantID;
    protected $IPAddress;
    protected $version;

    protected $APIUrl;
    protected $currency;
    protected $language;

    public function __construct()
    {
        $this->merchantID = \Config::get('globalcollect.merchantID', 9950);
        $this->IPAddress  = \Config::get('globalcollect.IPAddress', '54.173.36.14');
        $this->version    = \Config::get('globalcollect.version');
        $this->APIUrl     = \Config::get('globalcollect.url');
        $this->currency   = \Config::get('globalcollect.currency');
        $this->language   = \Config::get('globalcollect.language');
    }

    public function makeUsingCreditCard($amount, $productId, $returnUrl = '', $otherParams = [])
    {
        try {
            $action = 'INSERT_ORDERWITHPAYMENT';
            $order  = $otherParams['order'];

            $orderPayment = "   <ORDER>
                                    <ORDERTYPE>1</ORDERTYPE>
                                    <AMOUNT>{$amount}</AMOUNT>
                                    <CURRENCYCODE>{$this->currency}</CURRENCYCODE>
                                    <LANGUAGECODE>{$this->language}</LANGUAGECODE>
                                    <COUNTRYCODE>{$order['country']}</COUNTRYCODE>
                                    <SURNAME>{$order['lastName']}</SURNAME>
                                    <CITY>{$order['city']}</CITY>
                                    <FIRSTNAME>{$order['firstName']}</FIRSTNAME>
                                    <ZIP>{$order['zip']}</ZIP>
                                    <IPADDRESSCUSTOMER>{$order['ipAddress']}</IPADDRESSCUSTOMER>
                                    <EMAIL>{$order['email']}</EMAIL>
                                    <MERCHANTREFERENCE>{$order['reference']}</MERCHANTREFERENCE>
                                </ORDER>
                            <PAYMENT>
                                <HOSTEDINDICATOR>1</HOSTEDINDICATOR>
                                <PAYMENTPRODUCTID>{$productId}</PAYMENTPRODUCTID>
                                <AMOUNT>{$amount}</AMOUNT>
                                <CURRENCYCODE>USD</CURRENCYCODE>
                                <COUNTRYCODE>JP</COUNTRYCODE>
                                <LANGUAGECODE>{$this->language}</LANGUAGECODE>
                                <RETURNURL>{$returnUrl}</RETURNURL>
                            </PAYMENT>";

            $requestXML = $this->_prepareXMLString($action, $orderPayment);

            return $this->_executeCall($requestXML);
        } catch (Exception $ex) {
            return ['success' => false, 'errors' => [$ex->getMessage()]];
        }

    }

    public function getOrderStatus($orderId)
    {
        $action = 'GET_ORDERSTATUS';
        try{
            $orderXML = "
                    <ORDER>
                        <ORDERID>{$orderId}</ORDERID>
                    </ORDER>
            ";
            $requestXML = $this->_prepareXMLString($action,$orderXML);

            return $this->_executeCall($requestXML);
        }
        catch(Exception $ex){
            return ['success' => false, 'errors' => [$ex->getMessage()]];
        }
    }

    /*public function makeUsingCreditCard($amount, $creditCardDetails, $otherParams = [])
    {
        try {
            $action = 'INSERT_ORDERWITHPAYMENT';
            $order  = $otherParams['order'];

            $orderPayment = "   <ORDER>
                                    <ORDERTYPE>1</ORDERTYPE>
                                    <AMOUNT>{$amount}</AMOUNT>
                                    <CURRENCYCODE>{$this->currency}</CURRENCYCODE>
                                    <LANGUAGECODE>{$this->language}</LANGUAGECODE>
                                    <COUNTRYCODE>{$order['country']}</COUNTRYCODE>
                                    <SURNAME>{$order['lastName']}</SURNAME>
                                    <CITY>{$order['city']}</CITY>
                                    <FIRSTNAME>{$order['firstName']}</FIRSTNAME>
                                    <ZIP>{$order['zip']}</ZIP>
                                    <IPADDRESSCUSTOMER>{$order['ipAddress']}</IPADDRESSCUSTOMER>
                                    <EMAIL>{$order['email']}</EMAIL>
                                    <MERCHANTREFERENCE>{$order['reference']}</MERCHANTREFERENCE>
                                </ORDER>
                            <PAYMENT>
                                <HOSTEDINDICATOR>1</HOSTEDINDICATOR>
                                <PAYMENTPRODUCTID>1</PAYMENTPRODUCTID>
                                <AMOUNT>{$amount}</AMOUNT>
                                <CREDITCARDNUMBER>{$creditCardDetails['cardNumber']}</CREDITCARDNUMBER>
                                <EXPIRYDATE>{$creditCardDetails['cardExpiry']}</EXPIRYDATE>
                                <CURRENCYCODE>USD</CURRENCYCODE>
                                <COUNTRYCODE>JP</COUNTRYCODE>
                                <LANGUAGECODE>ja</LANGUAGECODE>
                                <EFFORTID>1</EFFORTID>
                                <ATTEMPTID>1</ATTEMPTID>
                            </PAYMENT>";

            $requestXML = $this->_prepareXMLString($action, $orderPayment);

            return $this->_executeCall($requestXML);
        } catch (Exception $ex) {
            return ['success' => false, 'errors' => [$ex->getMessage()]];
        }

    }*/

    public function makeUsingBank($amount, $bankDetails, $otherParams = [])
    {
        try {
            $orderPayment = "<ORDER>
                <MERCHANTREFERENCE>ABC1234</MERCHANTREFERENCE>
                <AMOUNT>234500</AMOUNT>
                <CURRENCYCODE>COP</CURRENCYCODE>
                <LANGUAGECODE>en</LANGUAGECODE>
                <COUNTRYCODE>CO</COUNTRYCODE>
                <SURNAME>Cruijff</SURNAME>
                <CITY>Barcelona</CITY>
                <FIRSTNAME>Johan</FIRSTNAME>
            </ORDER>
            <PAYMENT>
                <PAYMENTPRODUCTID>11</PAYMENTPRODUCTID>
                <AMOUNT>234500</AMOUNT>
                <CURRENCYCODE>COP</CURRENCYCODE>
                <COUNTRYCODE>CO</COUNTRYCODE>
                <LANGUAGECODE>en</LANGUAGECODE>
                <HOSTEDINDICATOR>0</HOSTEDINDICATOR>
            </PAYMENT>";
        } catch (Exception $ex) {
            return ['success' => false, 'errors' => [$ex->getMessage()]];
        }
    }

    public function makeUsingCheck($amount, $checkDetails, $otherParams = [])
    {
        // TODO: Implement makeUsingCheck() method.
    }

    public function createPaymentProfileFromOrder($orderId)
    {
        try{
            $orderXML = "
                <PAYMENT>
                    <ORDERID>{$orderId}</ORDERID>
                </PAYMENT>
            ";
            $requestXML = $this->_prepareXMLString('CONVERT_PAYMENTTOPROFILE',$orderXML);
            return $this->_executeCall($requestXML);
        }
        catch(Exception $ex){
            return ['success' => false, 'errors' => [$ex->getMessage()]];
        }
    }

    public function cancel()
    {
        // TODO: Implement cancel() method.
    }

    public function refund()
    {
        // TODO: Implement refund() method.
    }

    public function invalidateToken($token)
    {
        try{
            $requestXML = "
                <PROFILE>
                    <PROFILETOKEN>{$token}</PROFILETOKEN>
                </PROFILE>
            ";
            $requestXML = $this->_prepareXMLString('INVALIDATE_PROFILE',$requestXML);
            return $this->_executeCall($requestXML);
        }
        catch(Exception $ex){
            return ['success' => false, 'errors' => [$ex->getMessage()]];
        }

    }

    private function _executeCall($requestXML)
    {
        $live = \Config::get('globalcollect.live');

        if ($live) { //live mode
            $errors      = [];
            $success     = false;
            $successData = [];
            $call        = doPostCurl($this->APIUrl, $requestXML);

            if (!empty($call)) {
                $callObject = simplexml_load_string($call);

                if (isset($callObject->REQUEST->RESPONSE)) {
                    $responseObject = $callObject->REQUEST->RESPONSE;

                    if (@$responseObject->RESULT == 'OK') {
                        $success     = true;
                        if (isset($responseObject->ROW)) {
                            $successData = $responseObject->ROW;
                        }
                        elseif(isset($responseObject->STATUS)){
                            $successData = $responseObject->STATUS;
                        }


                    } else {
                        $errors[] = $responseObject->ERROR->MESSAGE;
                    }
                }
            }
        } else { //testing mode
            $success = 1;//rand(0, 1);

            if ($success) {
                $resp        = new \stdClass();
                $resp->REF   = \Str::random(8);
                $successData = $resp;
            } else {
                $errors[] = ['something went wrong mah man'];
            }
        }

        if (!$success) {
            return compact('success', 'errors');
        } else {
            return compact('success', 'successData');
        }
    }

    private function _prepareXMLString($action, $paramsXMLString)
    {
        $data = "<XML>
                    <REQUEST>
                        <ACTION>{$action}</ACTION>
                        <META>
                            <MERCHANTID>{$this->merchantID}</MERCHANTID>
                            <IPADDRESS>{$this->IPAddress}</IPADDRESS>
                            <VERSION>{$this->version}</VERSION>
                        </META>
                        <PARAMS>
                            {$paramsXMLString}
                        </PARAMS>
                    </REQUEST>
                </XML>";
        $this->_logXML($data);
        return $data;
    }

    private function _logXML($xmlString)
    {
        $logger = new Logger('Payment XML Logger');
        $logger->pushHandler(new StreamHandler(storage_path() . DIRECTORY_SEPARATOR . 'payment.log'), Logger::INFO);
        $logger->addInfo($xmlString);
    }


}