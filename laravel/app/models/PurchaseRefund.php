<?php
use LaravelBook\Ardent\Ardent;

class PurchaseRefund extends Ardent {
	protected $guarded = [];
        public static $rules = [];
        
        public static $relationsData = array(
        'product' => array(self::MORPH_TO),
        'student' => array(self::BELONGS_TO, 'Student', 'table' => 'users', 'foreignKey' => 'student_id'),
        'ltcAffiliate' => array(self::BELONGS_TO, 'LTCAffiliate', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id'),
        'productAffiliate' => array(self::BELONGS_TO, 'ProductAffiliate', 'table' => 'course_purchases', 'foreignKey' => 'product_affiliate_id'),
        'gift' => array(self::BELONGS_TO, 'Gift'),
    );
}