<?php

class PaymentHelper
{

    protected $url;

    public function __construct()
    {
        //TODO: Use a config to store the url
        $this->url = 'http://wazaar.dev/api/';
    }

    public function paymentValidationRules()
    {
        return [
            'productID'     => 'required|numeric',
            'productType'   => 'required',
            'finalCost'     => 'required|numeric',
            'originalCost'  => 'required|numeric',
            'discount'      => 'required|numeric',
            'taxPercentage' => 'required',
            'taxValue'      => 'required'
        ];
    }

    public function paymentValidationMessages()
    {
        return [
            'productId.required'   => trans('payment.productId.required'),
            'productId.numeric'    => trans('payment.productId.numeric'),
            'productType.required' => trans('payment.productType.required'),
            'finalCost.required'   => trans('payment.finalCost.required'),
            'finalCost.numeric'    => trans('payment.finalCost.numeric')
        ];
    }

    public function creditCardValidationRules()
    {
        return [
            'cardNumber' => 'required',
            'expiryDate' => 'required',
            'cvc'        => 'required',
            'firstName'  => 'required',
            'lastName'   => 'required',
            'email'      => 'required|email',
            'city'       => 'required',
            'zip'        => 'required'
        ];
    }

    public function processCreditCardPayment($creditCard, $payee, $student)
    {
        $paymentURL = $this->url . 'payment/creditcard';
        $data       = [
            'amount'     => $creditCard['finalCost'], //purchases.purchase_price
            'userId'     => $student->id, //users.id
            'email'      => $payee['email'], //users.email
            'firstName'  => $payee['firstName'], //user_profiles.first_name
            'lastName'   => $payee['lastName'], //user_profiles.last_name
            'city'       => $payee['city'],
            'zip'        => $payee['zip'],
            'country'    => 'JP',
            'cardNumber' => $creditCard['cardNumber'],
            'cardExpiry' => $creditCard['cardExpiry'],
            'ipAddress'  => Request::ip()
        ];

        return $this->_executeCurl($paymentURL, $data);
    }

    private function _executeCurl($url, $data)
    {
        $call     = cURL::post($url, $data);
        $response = json_decode($call->body, true);
        return $response;
    }
}