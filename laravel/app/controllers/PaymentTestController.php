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
           'cardName' => 'Visa',
           'cardNo' => '4000000000000000',
           'cardMonth' => '06',
           'cardYear' => '2019',
           'cvv2' => '111',
           'customerName' => 'Albert Maranian',
           'customerEmail' =>'albertmaranian@gmail.com'
        ];

        $payment = $this->payment->makeUsingCreditCard(100,$requestData);
        echo '<pre>';
        print_r($payment);
        echo '</pre>';
        die;
        //transaction reference
        $reference = Str::random();

        $otherParams = [
            'order' => [
                'orderId'   => $requestData['purchaseId'],
                'email'     => $requestData['email'],
                'firstName' => $requestData['firstName'],
                'lastName'  => $requestData['lastName'],
                'city'      => $requestData['city'],
                'zip'       => $requestData['zip'],
                'country'   => $requestData['country'],
                'ipAddress' => $requestData['ipAddress'],
                'reference' => $reference
            ]
        ];
        $creditCard  = [
            'cardNumber' => $requestData['cardNumber'],
            'cardExpiry' => $requestData['cardExpiry']
        ];

        $paymentCall = $this->payment->makeUsingCreditCard($requestData['amount'], $creditCard, $otherParams);
        Event::fire('payment.made', [$requestData, $paymentCall]);
    }

    public function payViaBank()
    {

    }
}