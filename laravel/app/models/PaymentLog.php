<?php

class PaymentLog extends Eloquent
{
    protected $table = 'payments_log';
    protected $fillable = ['user_id', 'purchase_id','success', 'reference','response'];
}