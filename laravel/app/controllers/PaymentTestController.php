<?php

class PaymentTestController extends BaseController
{
    protected $payment;

    public function __construct(\Cocorium\Payment\PaymentInterface $payment)
    {
        $this->payment = $payment;
    }

    /**
     *
     */
    public function pay()
    {
        //the POST variables required
        $requestData = [
            'purchaseId' => 101, //purchases.id
            'amount' => 100, //purchases.purchase_price
            'userId' => 1, //users.id
            'email' => 'albertmaranian@gmail.com', //users.email
            'firstName' => 'Albert', //user_profiles.first_name
            'lastName' => 'Maranian Jr', //user_profiles.last_name
            'city' => 'Davao',
            'zip' => '',
            'country' => 'PH',
            'cardNumber' => '4263982640269299',
            'cardExpiry' => '0218',
            'ipAddress' => '0.0.0.0'
        ];
        //transaction reference
        $reference = Str::random();

        $otherParams = [
            'order' => [
                'orderId'    => $requestData['purchaseId'],
                'email'      => $requestData['email'],
                'firstName'  => $requestData['firstName'],
                'lastName'   => $requestData['lastName'],
                'city'       => $requestData['city'],
                'zip'        => $requestData['zip'],
                'country'    => $requestData['country'],
                'ipAddress'  => $requestData['ipAddress'],
                'reference'  => $reference
            ]
        ];
        $creditCard = [
            'cardNumber' => $requestData['cardNumber'],
            'cardExpiry' => $requestData['cardExpiry']
        ];

        $paymentCall = $this->payment->makeUsingCreditCard($requestData['amount'], $creditCard, $otherParams);
        Event::fire('payment.made',[$requestData, $paymentCall]);
    }

    public function payViaBank()
    {

    }
}