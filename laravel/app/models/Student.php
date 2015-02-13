<?php


class Student extends User{
    protected $table = 'users';
    
    public static $relationsData = [
        'ltcAffiliate' => [ self::BELONGS_TO, 'LTCAffiliate', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id' ],
        'purchases' => [ self::HAS_MANY, 'CoursePurchase' ],
        'lessonPurchases' => [ self::HAS_MANY, 'LessonPurchase' ],
        'courseReferrals' => [ self::HAS_MANY, 'CourseReferral' ],
        'profile' => [ self::MORPH_ONE, 'Profile', 'name'=>'owner' ],
        'viewedLessons' => [ self::HAS_MANY, 'ViewedLesson' ],
        'wishlistItems' => [ self::HAS_MANY, 'WishlistItem' ],
        'testimonials' => [ self::HAS_MANY, 'Testimonial' ],
        'following' => [self::BELONGS_TO_MANY, 'Instructor',  'table' => 'follow_relationships',  'foreignKey' => 'student_id', 'otherKey' => 'instructor_id']
      ];
        
    public function manyThroughMany($related, $through, $firstKey, $secondKey, $pivotKey)
    {
        $model = new $related;
        $table = $model->getTable();
        $throughModel = new $through;
        $pivot = $throughModel->getTable();

        return $model
            ->join($pivot, $pivot . '.' . $pivotKey, '=', $table . '.' . $secondKey)
            ->select($table . '.*')
            ->where($pivot . '.' . $firstKey, '=', $this->id);
    }
    
    public function wishlistCourses()
    {
        return $this->manyThroughMany('Course', 'WishlistItem', 'student_id', 'id', 'course_id' );

    }
    
    public function productAffiliates()
    {
        return $this->belongsToMany('ProductAffiliate', 'course_purchases', 'student_id', 'product_affiliate_id');
    }
    
    public static function current(User $user){
        if($user!=null) return self::find($user->id);
        return null;
    }
    
    public function courses(){
        $ids = $this->lessonPurchases->lists('course_id');
        $ids += $this->purchases->lists('course_id');
        return Course::whereIn('id', $ids)->get();
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
            // increment counter only if no lessons have already been purchased
            if( $this->lessonPurchases()->where('course_id', $course->id)->count() == 0 ){
                $course->student_count += 1;
                $course->updateUniques();
            }
            return true;
        }
        else return false;
    }
    
    public function purchasedLesson($lesson){
        if( in_array ( $lesson->id, $this->lessonPurchases->lists('lesson_id' ) ) ){
            return true;
        }
        return false;
    }
    
    /**
     * Purchase a course
     * @param Course
     * @return boolean
     */
    public function purchaseLesson(Course $course, $lesson, $affiliate=null){
        // make sure lesson belongs to this course
        $lesson = Lesson::find($lesson);
        if($lesson->module->course->id != $course->id) return false;
        
        // cannot buy the same lesson twice
        if($this->purchasedLesson($lesson)) return false;
        
        // cannot buy own course
        if($this->id == $course->instructor->id) return false;
        // if this is the first purchase, set the LTC affiliates
        if( $this->purchases->count()==0 ) $this->setLTCAffiliate();
        $purchase = new LessonPurchase();
        $purchase->lesson_id = $lesson->id;
        $purchase->course_id = $course->id;
        $purchase->student_id = $this->id;
        $purchase->ltc_affiliate_id = $this->ltcAffiliate->id;
        if($affiliate==null) $purchase->product_affiliate_id = 0;
        else{
            $affiliate = ProductAffiliate::where('affiliate_id', $affiliate)->first();
            $purchase->product_affiliate_id = $affiliate->id;
        }
        if($purchase->save()){
            // increment counter only if this course hasn't been purchased before
            if( !$this->purchased($course) ){
                $course->student_count += 1;
                $course->updateUniques();
            }
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
    
    /**
     * Determines if the student has viewed the supplied lesson
     * @param Lesson $lesson
     */
    public function isLessonViewed(Lesson $lesson){
        if( in_array ( $lesson->id, $this->viewedLessons->lists('lesson_id' ) ) ){
            return true;
        }
        return false;
    }
    
    /**
     * Marks a lesson as viewed
     * @param Lesson $lesson
     */
    public function viewLesson(Lesson $lesson){
        if( !$this->isLessonViewed($lesson) ){
            $view = ViewedLesson::create( ['student_id' => $this->id, 'lesson_id' => $lesson->id] );
        }
        return true;
    }
    
    /**
     * Finds the next lesson in the current course
     * @param Course $course (with pre-ordered module and lesson relationships eargerly loaded)
     * @return mixed False if none, the lesson object otherwise
     */
    public function nextLesson(Course $course){ 
        foreach($course->modules as $module){
            foreach($module->lessons as $lesson){
                if( !$this->isLessonViewed($lesson) && ( $this->purchased($course) || $this->purchasedLesson($lesson) ) ) return $lesson;
            }
        }
        return false;
    }

    public function commentName(){
        if( $this->profile ){
            return $this->profile->first_name.' '.$this->profile->last_name;
        }
        else{
            if($this->first_name=='') return $this->email;
            else return $this->first_name.' '.$this->last_name;
        }
    }



}