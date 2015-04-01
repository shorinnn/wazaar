<?php

class Purchase extends CocoriumArdent{
    public static $rules = [
        'product_id' => 'required|unique_with:purchases,student_id,product_type,subscription_start',
        'product_type' => 'required|in:Lesson,Course',
        'student_id' => 'required|exists:users,id'
    ];
    
    public static $relationsData = array(
        'product' => array(self::MORPH_TO),
        'student' => array(self::BELONGS_TO, 'Student', 'table' => 'users', 'foreignKey' => 'student_id'),
        'ltcAffiliate' => array(self::BELONGS_TO, 'LTCAffiliate', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id'),
        'productAffiliate' => array(self::BELONGS_TO, 'ProductAffiliate', 'table' => 'course_purchases', 'foreignKey' => 'product_affiliate_id'),
        'gift' => array(self::BELONGS_TO, 'Gift'),
    );
    
    public function beforeSave(){
        if($this->product_type=='Course'){
            if( Course::find($this->product_id)==null ) return false;
        }
        else {
            if( Lesson::find($this->product_id)==null ) return false;
        }
    }

}