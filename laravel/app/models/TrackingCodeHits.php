<?php

class TrackingCodeHits extends Eloquent
{
    protected $table = 'tracking_code_hits';
    protected $fillable = ['affiliate_id', 'tracking_code'];
}