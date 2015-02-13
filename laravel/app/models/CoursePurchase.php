<?php

class CoursePurchase extends CocoriumArdent{
    public static $rules = [
        'course_id' => 'required|exists:courses,id|unique_with:course_purchases,student_id',
        'student_id' => 'required|exists:users,id'
    ];
    
    public static $relationsData = array(
        'course' => array(self::BELONGS_TO, 'Course'),
        'student' => array(self::BELONGS_TO, 'Student', 'table' => 'users', 'foreignKey' => 'student_id'),
        'ltcAffiliate' => array(self::BELONGS_TO, 'LTCAffiliate', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id'),
        'productAffiliate' => array(self::BELONGS_TO, 'ProductAffiliate', 'table' => 'course_purchases', 'foreignKey' => 'product_affiliate_id'),
    );

}