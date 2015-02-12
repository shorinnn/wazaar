<?php
use LaravelBook\Ardent\Ardent;

class LessonPurchase extends Ardent{
    
    public static $relationsData = array(
        'lesson' => array(self::BELONGS_TO, 'Lesson'),
        'student' => array(self::BELONGS_TO, 'Student', 'table' => 'users', 'foreignKey' => 'student_id'),
        'ltcAffiliate' => array(self::BELONGS_TO, 'LTCAffiliate', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id'),
        'productAffiliate' => array(self::BELONGS_TO, 'ProductAffiliate', 'table' => 'course_purchases', 'foreignKey' => 'product_affiliate_id'),
    );

}