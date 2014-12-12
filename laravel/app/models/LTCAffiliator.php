<?php

class LTCAffiliator extends User{
    protected $table = 'users';
    
    public static $relationsData = array(
        'affiliated' => array(self::HAS_MANY, 'User', 'table' => 'users', 'foreignKey' => 'ltc_affiliator_id'),
        'sales' => array(self::HAS_MANY, 'CoursePurchase', 'foreignKey' => 'ltc_affiliator_id'),
  );
    
    public function courses()
    {
        return $this->belongsToMany('Course', 'course_purchases', 'ltc_affiliator_id', 'course_id');
    }
    
    public function revalidate(){
        return true;
    }
}