<?php

class PaymentTestController extends BaseController
{
    protected $payment;

    public function __construct(\Cocorium\Payment\PaymentInterface $payment)
    {
        $this->payment = $payment;
    }

    public function pay()
    {
        $amount = 100;
        $otherParams = [
            'order' => [
                'orderId' => 101,
                'email' => 'albertmaranian@gmail.com',
                'firstName' => 'Albert',
                'lastName'  => 'Maranian',
                'city' => '',
                'state' => '',
                'street' => '',
                'zip' => '',
                'reference' => 'abcde'
            ]
        ];
        $creditCard = [
            'cardNumber' => '4263982640269299',
            'cardExpiry' => '0218'
        ];

        $paymentCall = $this->payment->makeUsingCreditCard($amount, $creditCard, $otherParams);

        dd($paymentCall);
    }
}