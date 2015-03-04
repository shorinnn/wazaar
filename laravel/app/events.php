<?php

Event::listen('auth.login', function($event)
{
    $student = Student::find(Auth::user()->id);
    $student->restoreReferrals();
    return false;
});

Event::listen('payment.made', function ($requestData, $paymentCall){

    $reference = '';

    if ($paymentCall['success']){
        $reference = @$paymentCall['successData']->REF;
        $response = json_encode($paymentCall['successData']);
    }
    else{
        $response = json_encode($paymentCall['errors']);
    }

    PaymentLog::create(
        [
            'user_id' => $requestData['userId'] ,
            'purchase_id' => $requestData['purchaseId'],
            'success' => $paymentCall['success'],
            'reference' => $reference,
            'response' => $response
        ]
    );
});