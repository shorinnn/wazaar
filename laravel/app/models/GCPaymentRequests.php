<?php

class GCPaymentRequests extends Eloquent
{
    protected $table = 'gc_payment_requests';
    protected $fillable = ['wazaar_reference','gc_order_id','gc_reference','gc_mac','gc_return_mac','gc_status_id'];
}