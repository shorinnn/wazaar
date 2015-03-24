<?php

class ApiPaymentController extends BaseController
{

    protected $payment;

    public function __construct(\Cocorium\Payment\PaymentInterface $payment)
    {
        $this->payment = $payment;
    }

    public function creditCard()
    {
        $rules = [
            'userId'     => 'required|numeric', //users.id
            'email'      => 'required|email', //users.email
            'firstName'  => 'required', //user_profiles.first_name
            'lastName'   => 'required', //user_profiles.last_name
            'city'       => 'required',
            'zip'        => 'required',
            'country'    => 'required',
            'cardNumber' => 'required',
            'cardExpiry' => 'required|max:4',
            'amount'     => 'required|numeric', //purchases.purchase_price
            'ipAddress'  => 'required'
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors'  => $validator->messages()->all()
            ];
        }

        $requestData = Input::all();
        $reference   = Str::random(10);

        $otherParams = [
            'order' => [
                'orderId'   => rand(1, 100),
                'email'     => $requestData['email'],
                'firstName' => $requestData['firstName'],
                'lastName'  => $requestData['lastName'],
                'city'      => @$requestData['city'],
                'zip'       => @$requestData['zip'],
                'country'   => @$requestData['country'],
                'ipAddress' => $requestData['ipAddress'],
                'reference' => $reference
            ]
        ];
        $creditCard  = [
            'cardNumber' => $requestData['cardNumber'],
            'cardExpiry' => $requestData['cardExpiry']
        ];

        $paymentResponse = $this->payment->makeUsingCreditCard($requestData['amount'], $creditCard, $otherParams);
        Event::fire('payment.made', [$requestData, $paymentResponse]);

        return Response::json($paymentResponse);
    }

    public function createProfile()
    {
        $rules = [
          'orderId' => 'required'
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors'  => $validator->messages()->all()
            ];
        }

        $orderId = Input::get('orderId');
        $response = $this->payment->createPaymentProfileFromOrder($orderId);

        return Response::json($response);
    }
}