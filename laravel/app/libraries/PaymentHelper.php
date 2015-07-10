<?php

class PaymentHelper
{

    protected $url;
    protected $payment;

    public function __construct()
    {
        //TODO: Use a config to store the url
        $this->url = Config::get('wazaar.API_URL');
        $this->payment = app()->bind('Cocorium\Payment\PaymentInterface','Cocorium\Payment\PaymentMaxCollectDriver');
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
            'zip'        => 'required',
            'paymentProductId' => 'required'
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
            'zip.required'        => trans('payment.validation.firstName.required'),
            'paymentProductId.required' => trans('payment.validation.paymentProductId.required')
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

    public function processCreditCardPayment($paymentDetails, $payee, $student)
    {
        dd($paymentDetails);

       /* $paymentURL = $this->url . 'payment/creditcard';
        $data       = [
            'amount'     => $paymentDetails['finalCost'], //purchases.purchase_price
            'userId'     => $student->id, //users.id
            'email'      => $payee['email'], //users.email
            'firstName'  => $payee['firstName'], //user_profiles.first_name
            'lastName'   => $payee['lastName'], //user_profiles.last_name
            'city'       => $payee['city'],
            'zip'        => $payee['zip'],
            'country'    => 'JP',
            'ipAddress'  => Request::ip(),
            'paymentProductId' => $paymentDetails['paymentProductId'],
            'reference' => $paymentDetails['reference'],
            'returnUrl' => url('payment/callback/' . $paymentDetails['reference'])
        ];

        return $this->_executeCurl($paymentURL, $data);*/
    }

    private function _executeCurl($url, $data)
    {
        $call     = cURL::post($url, $data);
        $response = json_decode($call->body, true);
        return $response;
    }
}