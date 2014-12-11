<?php

class Student extends User{
    protected $table = 'users';
    
    public static $relationsData = array(
        'ltcAffiliator' => array(self::BELONGS_TO, 'LTCAffiliator', 'table' => 'users', 'foreignKey' => 'ltc_affiliator_id'),
        'purchases' => array(self::HAS_MANY, 'CoursePurchase'),
      );
    
    public function courses()
    {
        return $this->belongsToMany('Course', 'course_purchases', 'student_id', 'course_id');
    }
    
    public function productAffiliators()
    {
        return $this->belongsToMany('ProductAffiliator', 'course_purchases', 'student_id', 'product_affiliator_id');
    }
}