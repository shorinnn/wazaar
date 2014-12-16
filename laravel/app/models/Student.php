<?php

class Student extends User{
    protected $table = 'users';
    
    public static $relationsData = array(
        'ltcAffiliate' => array(self::BELONGS_TO, 'LTCAffiliate', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id'),
        'purchases' => array(self::HAS_MANY, 'CoursePurchase'),
      );
        
    public function productAffiliates()
    {
        return $this->belongsToMany('ProductAffiliate', 'course_purchases', 'student_id', 'product_affiliate_id');
    }
    
    public static function current(User $user){
        if($user!=null) return self::find($user->id);
        return null;
    }
    
    /**
     * Purchased the specified course?
     * @param Course $course
     * @return boolean
     */
    public function purchased(Course $course){
        if( in_array ( $course->id, $this->purchases->lists('course_id' ) ) ){
            return true;
        }
        return false;
    }
    
    /**
     * Purchase a course
     * @param Course
     * @return boolean
     */
    public function purchase(Course $course, $affiliate=null){
        // cannot buy the same course twice
        if($this->purchased($course)) return false;
        
        // cannot buy own course
        if($this->id == $course->instructor->id) return false;
        // if this is the first purchase, set the LTC affiliates
        if( $this->purchases->count()==0 ) $this->setLTCAffiliate();
        $purchase = new CoursePurchase;
        $purchase->course_id = $course->id;
        $purchase->student_id = $this->id;
        $purchase->ltc_affiliate_id = $this->ltcAffiliate->id;
        if($affiliate==null) $purchase->product_affiliate_id = 0;
        else{
            $affiliate = ProductAffiliate::where('affiliate_id', $affiliate)->first();
            $purchase->product_affiliate_id = $affiliate->id;
        }
        if($purchase->save()){
            $course->student_count += 1;
            $course->updateUniques();
            return true;
        }
        else return false;
    }
    
    /**
     * Set this user's LTC affiliate to Wazaar if purchase takes place 30 days 
     * after registration. Otherwise just keep original affiliate.
     */

    public function setLTCAffiliate(){
        $register = new DateTime($this->created_at);
        $now = new DateTIme();
        if($now->diff($register)->days >=30){
            $this->ltc_affiliate_id = 2;
            $this->save();
        }
    }
}