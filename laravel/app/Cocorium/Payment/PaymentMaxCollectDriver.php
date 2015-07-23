<?php namespace Cocorium\Payment;

class PaymentMaxCollectDriver implements PaymentInterface {

    protected $spid;
    protected $spw;
    protected $endpoint;

    public function __construct()
    {
        $this->sid = \Config::get('maxcollect.sid');
        $this->spw =  \Config::get('maxcollect.spw');
        $this->endpoint = \Config::get('maxcollect.endpoint');
    }

    public function makeUsingCreditCard($amount, $creditCardDetails, $otherParams = [])
    {

        $data = [
          'SiteId' => $this->sid,
          'SitePass' => $this->spw,
          'cardName' => $creditCardDetails['cardName'],
          'cardNo' => $creditCardDetails['cardNumber'],
          'cardMonth' => $creditCardDetails['cardMonth'],
          'cardYear' => $creditCardDetails['cardYear'],
          'cvv2' => $creditCardDetails['cardCVV'],
          'adr1' => $creditCardDetails['address1'],
          'adr2' => $creditCardDetails['address2'],
          'Amount' => $amount,
          'Name' => $creditCardDetails['firstName'] . ' ' . $creditCardDetails['lastName'],
          'Mail' => $creditCardDetails['email'],
          'CustomerId' => 'lagsik',
          'CustomerPass' => 'taeigit'

        ];


        $curl = new \anlutro\cURL\cURL();
        $url = $curl->buildUrl($this->endpoint,$data);
        parse_str($curl->get($url)->body);

        return compact('state','msg','TransactionId');
    }

    public function makeUsingBank($amount, $bankDetails, $otherParams = [])
    {
        // TODO: Implement makeUsingBank() method.
    }

    public function makeUsingCheck($amount, $checkDetails, $otherParams = [])
    {
        // TODO: Implement makeUsingCheck() method.
    }

    public function getOrderStatus($orderId)
    {
        // TODO: Implement getOrderStatus() method.
    }

    public function createPaymentProfileFromOrder($orderId)
    {
        // TODO: Implement createPaymentProfileFromOrder() method.
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
        // TODO: Implement invalidateToken() method.
    }

    private function arrayToEncodedUrl($array){
        $mergedKeyValue = [];

        foreach($array as $key => $val){
            $mergedKeyValue[] = $key . '=' . urlencode($val);
        }

        return implode('&',$mergedKeyValue);
    }
}