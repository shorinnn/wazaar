<?php

class LessonPurchase extends CocoriumArdent{
    public static $rules = [
        'lesson_id' => 'required|exists:lessons,id|unique_with:lesson_purchases,student_id',
        'student_id' => 'required|exists:users,id',
        'course_id' => 'required|exists:courses,id'
    ];
    
    public static $relationsData = array(
        'lesson' => array(self::BELONGS_TO, 'Lesson'),
        'student' => array(self::BELONGS_TO, 'Student', 'table' => 'users', 'foreignKey' => 'student_id'),
        'ltcAffiliate' => array(self::BELONGS_TO, 'LTCAffiliate', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id'),
        'productAffiliate' => array(self::BELONGS_TO, 'ProductAffiliate', 'table' => 'course_purchases', 'foreignKey' => 'product_affiliate_id'),
    );

}