<?php
use LaravelBook\Ardent\Ardent;

class CoursePurchase extends Ardent{
    
    public static $relationsData = array(
        'course' => array(self::BELONGS_TO, 'Course'),
        'student' => array(self::BELONGS_TO, 'User', 'table' => 'users', 'foreignKey' => 'user_id'),
        'ltcAffiliator' => array(self::BELONGS_TO, 'LTCAffiliator', 'table' => 'users', 'foreignKey' => 'ltc_affiliator_id'),
        'productAffiliator' => array(self::BELONGS_TO, 'User', 'table' => 'course_purchases', 'otherKey' => 'product_affiliator_id' ,'foreignKey' => 'id'),
    );

}