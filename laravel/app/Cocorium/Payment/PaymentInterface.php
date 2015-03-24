<?php
namespace Cocorium\Payment;

interface PaymentInterface {
    public function makeUsingCreditCard($amount, $creditCardDetails, $otherParams = []);
    public function makeUsingBank($amount, $bankDetails, $otherParams = []);
    public function makeUsingCheck($amount, $checkDetails, $otherParams = []);
    public function createPaymentProfileFromOrder($orderId);
    public function cancel();
    public function refund();
}