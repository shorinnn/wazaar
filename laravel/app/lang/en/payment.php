<?php

return
[
    'payment' => 'Payment',
    'paymentDetails' => 'Payment Details',
    'creditCard' => 'Credit Card',
    'cardNumber' => 'Card Number',
    'expiryDate' => 'Expiry Date',
    'MMYY'    => 'MMYY',
    'MM' => 'MM',
    'YY' => 'YY',
    'cvCode' => 'CV Code',
    'pay' => 'Pay',
    'cancel' => 'Cancel',
    'youAreToEnroll' => 'You are about to enroll in',
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
    ],
    'validation' => [
        'firstName' => ['required' => 'First Name cannot be empty'],
        'lastName' => ['required' => 'Last Name cannot be empty'],
        'email' => [
                    'required' => 'Email cannot be empty',
                    'validFormat' => 'Email address provided is not in a valid format'
                   ],
        'city' => ['required' => 'First Name cannot be empty'],
        'zip' => ['required' => 'First Name cannot be empty'],
        'paymentProductId' => ['required' => 'You must select a credit card']
    ],
    'cannotPurchase' => 'Sorry you are prohibited to purchase this product. Please make sure that you haven\'t purchased this in the past or you\'re not the instructor of this product'
];