<?php

use Stripe\Stripe;

class StripeHelper {

    protected $stripe;

    public function __construct()
    {
        Stripe::setApiKey();
    }

}