<?php

class PaymentHelper
{

    protected $url;
    protected $payment;

    public function __construct()
    {
        //TODO: Use a config to store the url
        $this->url = Config::get('wazaar.API_URL');
        $this->payment = app()->make('Cocorium\Payment\PaymentInterface');
    }

    public function paymentValidationRules()
    {
        return [
            'productID'     => 'required|numeric',
            'productType'   => 'required',
            'finalCost'     => 'required|numeric',
            'originalCost'  => 'required|numeric',
            'discount'      => 'required|numeric'
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
            'firstName'  => 'required',
            'lastName'   => 'required',
            'email'      => 'required|email',
            'city'       => 'required',
            'zip'        => 'required'
        ];
    }

    public function creditCardValidationMessages()
    {
        return [
            'firstName.required'  => trans('payment.validation.firstName.required'),
            'lastName.required'   => trans('payment.validation.lastName.required'),
            'email.required'      => trans('payment.validation.email.required'),
            'email.validFormat'      => trans('payment.validation.email.validFormat'),
            'city.required'       => trans('payment.validation.email.validFormat'),
            'zip.required'        => trans('payment.validation.firstName.required')
        ];
    }

    public function getOrderStatus($orderId)
    {
        $createURL = $this->url . 'payment/order/status';
        $data = [
            'orderId' => $orderId
        ];

        return $this->_executeCurl($createURL, $data);
    }

    public function invalidateProfile($token)
    {
        $createURL = $this->url . 'profile/invalidate';
        $data = [
            'profileToken' => $token
        ];

        return $this->_executeCurl($createURL, $data);
    }

    public function processCreateProfileFromOrderId($orderId)
    {
        $createURL = $this->url . 'payment/profile/create';
        $data = [
          'orderId' => $orderId
        ];

        return $this->_executeCurl($createURL, $data);
    }

    public function processCreditCardPayment($amount, $data)
    {
        $payment  = $this->payment->makeUsingCreditCard($amount,$data);

        if (isset($payment['state'])){
            if ($payment['state'] == 1){
                //Raise an event that payment was successfull
                return [true,$payment['TransactionId']];
            }

            $errors = explode(",",$payment['msg']);
            return [false,$errors];
        }

        return [false,['Cannot process request as of this moment']];

    }

    private function _executeCurl($url, $data)
    {
        $call     = cURL::post($url, $data);
        $response = json_decode($call->body, true);
        return $response;
    }
}