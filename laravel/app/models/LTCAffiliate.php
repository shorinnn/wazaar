<?php

class LTCAffiliate extends User{
    protected $table = 'users';
    
    public static $relationsData = array(
        'affiliated' => array(self::HAS_MANY, 'User', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id'),
        'sales' => array(self::HAS_MANY, 'CoursePurchase', 'foreignKey' => 'ltc_affiliate_id'),
  );

}