<?php namespace Cocorium\Payment;

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

    public function makeUsingCreditCard($amount, $creditCardDetails, $otherParams = [])
    {
        try {
            $action = 'INSERT_ORDERWITHPAYMENT';
            $order  = $otherParams['order'];

            $orderPayment = "   <ORDER>
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
                                <PAYMENTPRODUCTID>1</PAYMENTPRODUCTID>
                                <AMOUNT>{$amount}</AMOUNT>
                                <CREDITCARDNUMBER>{$creditCardDetails['cardNumber']}</CREDITCARDNUMBER>
                                <EXPIRYDATE>{$creditCardDetails['cardExpiry']}</EXPIRYDATE>
                                <CURRENCYCODE>USD</CURRENCYCODE>
                                <COUNTRYCODE>JP</COUNTRYCODE>
                                <LANGUAGECODE>ja</LANGUAGECODE>
                            </PAYMENT>";

            $requestXML = $this->_prepareXMLString($action, $orderPayment);

            return $this->_executeCall($requestXML);
        } catch (Exception $ex) {
            return ['success' => false, 'errors' => [$ex->getMessage()]];
        }

    }

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
                    <ATTEMPTID>1</ATTEMPTID>
                    <EFFORTID>1</EFFORTID>
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
                        $successData = $responseObject;
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

        return $data;
    }


}