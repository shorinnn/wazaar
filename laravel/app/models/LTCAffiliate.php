<?php

class LTCAffiliate extends User{



    protected $table = 'users';


    public static $relationsData = array(
        'affiliated' => array(self::HAS_MANY, 'User', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id'),
        'sales' => array(self::HAS_MANY, 'Purchase', 'foreignKey' => 'ltc_affiliate_id'),
        'profile' => array(self::MORPH_ONE, 'Profile', 'name'=>'owner'),
        'affiliateAgency' => array(self::BELONGS_TO, 'AffiliateAgency')
    );
}