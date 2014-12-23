<?php


class Student extends User{

    use ProfileTrait;

    protected $table = 'users';
    protected $roleId = 2;
    
    public static $relationsData = array(
        'ltcAffiliate' => array(self::BELONGS_TO, 'LTCAffiliate', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id'),
        'purchases' => array(self::HAS_MANY, 'CoursePurchase'),
        'courseReferrals' => array(self::HAS_MANY, 'CourseReferral'),
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
    
    /**
     * Saves the product referral in the DB, as a backup for the cookie 
     * @param int $affiliate_id The affiliate ID
     * @param int $course_id The course ID
     */
    public function saveReferral($affiliate_id, $course_id){
        $recommendation = CourseReferral::firstOrNew( ['course_id' => $course_id, 'student_id' => $this->id] );
        $recommendation->expires = date('Y-m-d H:i:s', strtotime('+30 day'));
        $recommendation->affiliate_id = $affiliate_id;
        $recommendation->updateUniques();
    }
    
    /**
     * Recreates cookies containing the referral data, if necessary and deletes expired entries
     */
    public function restoreReferrals(){
        // delete expired referrals
        $now = date('Y-m-d H:i:s');
        foreach($this->courseReferrals()->where('expires', '<', $now )->get() as $recommendation){
            $recommendation->delete();
        }
        // restore the cookies
        foreach($this->courseReferrals as $recommendation){
            if( !Cookie::has( "aid-$recommendation->course_id" ) ){
                $expires = strtotime($recommendation->expires);
                $now = time();
                $expires_in  = ($expires-$now) / 60;
                Cookie::queue( "aid-$recommendation->course_id", $recommendation->affiliate_id, $expires_in);
            }
        }
    }




}