<?php

class ProductAffiliator extends User{
    protected $table = 'users';
    public static $relationsData = array(
        'sales' => array(self::HAS_MANY, 'CoursePurchase'),
  );
    
    public function affiliated()
    {
        return $this->belongsToMany('User', 'course_purchases', 'product_affiliator_id', 'user_id');
    }
    
    public function courses()
    {
        return $this->belongsToMany('Course', 'course_purchases', 'product_affiliator_id', 'course_id');
    }
}