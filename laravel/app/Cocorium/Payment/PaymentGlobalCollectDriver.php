<?php namespace Cocorium\Payment;

class PaymentGlobalCollectDriver implements PaymentInterface {

    protected $merchantID;
    protected $IPAddress;
    protected $version;
    protected $APIUrl;

    public function __construct()
    {
        $this->merchantID = \Config::get('globalcollect.merchantID',9950);
        $this->IPAddress = \Config::get('globalcollect.IPAddress','54.173.36.14');
        $this->version = \Config::get('globalcollect.version');
        $this->APIUrl = \Config::get('globalcollect.url');
    }

    public function makeUsingCreditCard($amount, $creditCardDetails, $otherParams = [])
    {
        try{
            $action = 'INSERT_ORDERWITHPAYMENT';
            $order = $otherParams['order'];

            $errors = [];
            $success = false;

            $payment = "<ORDER>
                            <ORDERID>{$order['orderId']}</ORDERID>
                            <AMOUNT>{$amount}</AMOUNT>
                            <CURRENCYCODE>JPY</CURRENCYCODE>
                            <LANGUAGECODE>ja</LANGUAGECODE>
                            <COUNTRYCODE>JP</COUNTRYCODE>
                            <SURNAME>{$order['lastName']}</SURNAME>
                            <CITY>{$order['city']}</CITY>
                            <FIRSTNAME>{$order['firstName']}</FIRSTNAME>
                            <STREET>{$order['street']}</STREET>
                            <ZIP>{$order['zip']}</ZIP>
                            <STATE>{$order['state']}</STATE>
                            <IPADDRESSCUSTOMER>201.11.13.19</IPADDRESSCUSTOMER>
                            <EMAIL>{$order['email']}</EMAIL>
                            <MERCHANTREFERENCE>{$order['reference']}</MERCHANTREFERENCE>
                        </ORDER>
                    <PAYMENT>
                        <PAYMENTPRODUCTID>1</PAYMENTPRODUCTID>
                        <AMOUNT>{$amount}</AMOUNT>
                        <CREDITCARDNUMBER>{$creditCardDetails['cardNumber']}</CREDITCARDNUMBER>
                        <EXPIRYDATE>{$creditCardDetails['cardExpiry']}</EXPIRYDATE>
                        <CURRENCYCODE>JPY</CURRENCYCODE>
                        <COUNTRYCODE>JP</COUNTRYCODE>
                        <LANGUAGECODE>ja</LANGUAGECODE>
                    </PAYMENT>";

            $requestXML = $this->prepareXMLString($action, $payment);
            $call = doPostCurl($this->APIUrl,$requestXML);

            if (!empty($call)){
                $callObject = simplexml_load_string($call);

                if (isset($callObject->REQUEST->RESPONSE)){
                    $responseObject = $callObject->REQUEST->RESPONSE;

                    if (@$responseObject->RESULT == 'OK'){
                        $success = true;
                    }
                    else{
                        $errors[] = $responseObject->ERROR->MESSAGE;
                    }
                }
            }

            return compact('success', 'errors');
        }
        catch(Exception $ex){
            return ['success' => false, 'errors' => [$ex->getMessage()]];
        }

    }

    public function makeUsingBank($amount, $bankDetails, $otherParams = [])
    {
        // TODO: Implement makeUsingBank() method.
    }

    public function makeUsingCheck($amount, $checkDetails, $otherParams = [])
    {
        // TODO: Implement makeUsingCheck() method.
    }


    public function cancel()
    {
        // TODO: Implement cancel() method.
    }

    public function refund()
    {
        // TODO: Implement refund() method.
    }

    private function prepareXMLString($action,$paramsXMLString)
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