<?php

Event::listen('auth.login', function($event)
{
    $student = Student::find(Auth::user()->id);
    $student->restoreReferrals();
    return false;
});

Event::listen('payment.made', function ($requestData, $paymentResponse){

    $reference = '';

    if ($paymentResponse['success']){
        $reference = @$paymentResponse['successData']->REF;
        $response = json_encode($paymentResponse['successData']);
    }
    else{
        $response = json_encode($paymentResponse['errors']);
    }

    PaymentLog::create(
        [
            'user_id' => $requestData['userId'] ,
            'success' => $paymentResponse['success'],
            'reference' => $reference,
            'response' => $response
        ]
    );
});