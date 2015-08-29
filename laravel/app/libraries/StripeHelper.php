<?php

use Stripe\Stripe;

class StripeHelper
{

    protected $stripe;
    protected $token;

    public function __construct($token)
    {
        Stripe::setApiKey('sk_test_nMRVlxUW17GiIC5fTInFoCn6');
        $this->token = $token;
    }

    public function charge($customerId, $amount, $cardId = '', $currency = 'SGD')
    {
        try{
            $chargeArr = [
                'amount'      => $amount,
                'currency'    => $currency,
                'customer' => $customerId
            ];

            if (!empty($cardId)){
                $chargeArr['source'] = $cardId;
            }


            $response = \Stripe\Charge::create($chargeArr);

            return $response;
        } catch (Exception $ex) {
            // Card was declined.
            echo $ex->getMessage();
            return false;
        }
    }

    public function createCustomer($email)
    {
        try{
            return \Stripe\Customer::create(array(
                "email" => $email,
                "description" => "Customer with email {$email}",
                "source" => $this->token // obtained with Stripe.js
            ));
        }
        catch(Exception $ex){
            return false;
        }

    }

}