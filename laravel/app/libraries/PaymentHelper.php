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
            'productID' => 'required|numeric',
            'productType' => 'required',
            'finalCost' => 'required|numeric',
            'originalCost' => 'required|numeric',
            'discount'  => 'required|numeric',
            'taxPercentage' => 'required',
            'taxValue' => 'required'
        ];
    }

    public function paymentValidationMessages()
    {
        return [
            'productId.required' => trans('payment.productId.required'),
            'productId.numeric' => trans('payment.productId.numeric'),
            'productType.required' => trans('payment.productType.required'),
            'finalCost.required' => trans('payment.finalCost.required'),
            'finalCost.numeric' => trans('payment.finalCost.numeric')
        ];
    }

    public function creditCardValidationRules(){
        return [
            'cardNumber' => 'required',
            'expiryMonth' => 'required|numeric',
            'expiryYear' => 'required|numeric',
            'cvc' => 'required'
        ];
    }

    public function processCreditCardPayment($creditCard, $user)
    {
        $paymentURL = $this->url . 'payment/creditcard';
        $data = [
            'amount' => $creditCard['finalCost'], //purchases.purchase_price
            'userId' => $user->id, //users.id
            'email' => $user->email, //users.email
            'firstName' => $user->profile->first_name, //user_profiles.first_name
            'lastName' => $user->profile->last_name, //user_profiles.last_name
            'city' => $user->profile->city,
            'zip' => $user->profile->zip,
            'country' => 'JP',
            'cardNumber' => $creditCard['cardNumber'],
            'cardExpiry' => $creditCard['cardExpiry'],
            'ipAddress' => Request::ip()
        ];

        $this->_executeCurl($paymentURL, $data);
    }

    private function _executeCurl($url, $data)
    {
        $call = cURL::post( $url, $data);

        echo '<pre>';
        print_r($call->body);
        echo '</pre>';
        die;
    }
}