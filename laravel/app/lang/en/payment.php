<?php

return
[
    'payment' => 'Payment',
    'paymentDetails' => 'Payment Details',
    'creditCard' => 'Credit Card',
    'cardNumber' => 'Card Number',
    'expiryDate' => 'Expiry Date',
    'MM'    => 'MM',
    'YY' => 'YY',
    'cvCode' => 'CV Code',
    'pay' => 'Pay',
    'productId' =>
    [
        'required' => 'Payment product was not defined',
        'numeric' => 'Associated product ID is not valid'
    ],
    'productType' =>
    [
        'required' => 'Payment product type was not defined'
    ],
    'finalCost' =>
    [
        'required' => 'Final cost was not defined for payment to continue',
        'numeric' => 'Final cost should be a number'
    ]
];