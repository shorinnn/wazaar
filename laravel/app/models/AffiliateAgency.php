<?php
use LaravelBook\Ardent\Ardent;

class AffiliateAgency extends Ardent {
    
	protected $fillable = ['name'];
        
        public static $rules = [
            'name' => 'required|unique:affiliate_agencies'
        ];
        
        public static $relationsData = [
            'ltcAffiliates' => [self::HAS_MANY, 'LTCAffiliate', 'table' => 'users' ],
            'productAffiliates' => [self::HAS_MANY, 'ProductAffiliate', 'table' => 'users' ],
        ];
}