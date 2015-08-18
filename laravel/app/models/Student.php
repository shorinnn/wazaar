<?php


class Student extends User{
    protected $table = 'users';
    private $purchased;
    
    public static $relationsData = [
        'ltcAffiliate' => [ self::BELONGS_TO, 'LTCAffiliate', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id' ],
        'purchases' => [ self::HAS_MANY, 'Purchase' ],
        'refunds' => [ self::HAS_MANY, 'PurchaseRefund' ],
        'courseReferrals' => [ self::HAS_MANY, 'CourseReferral' ],
        'profile' => [ self::MORPH_ONE, 'Profile', 'name'=>'owner' ],
        'viewedLessons' => [ self::HAS_MANY, 'ViewedLesson' ],
        'wishlistItems' => [ self::HAS_MANY, 'WishlistItem' ],
        'testimonials' => [ self::HAS_MANY, 'Testimonial' ],
        'allTransactions' => [ self::HAS_MANY, 'Transaction', 'foreignKey'=>'user_id' ],
        'following' => [self::BELONGS_TO_MANY, 'Instructor',  'table' => 'follow_relationships',  'foreignKey' => 'student_id', 'otherKey' => 'instructor_id'],
        'sentMessages' => [ self::HAS_MANY, 'PrivateMessage', 'foreignKey' => 'sender_id' ],
        'receivedMessagesRel' => [ self::HAS_MANY, 'PrivateMessage', 'foreignKey' => 'recipient_id' ],
        'discussions' => array(self::HAS_MANY, 'LessonDiscussion'),
      ];
    
    public function getTransactionsAttribute(){
        return $this->allTransactions()->where('transaction_type', 'LIKE', "%student%");
    }
    
    public function receivedMessages(){

        $mass = [0];
        $courses = $this->purchases()->where('product_type','Course')->lists('product_id');
        if( count($courses) > 0){
            $mass = PrivateMessage::whereIn('course_id', $courses)->where('type','mass_message')->lists('id');
            if( count($mass) == 0 ){
                $mass = [0];
            }
        }
        $non_mass = $this->receivedMessagesRel()->lists('id');
        if( count($non_mass) == 0) $non_mass = [0];
        
        $return = PrivateMessage::where(function($query) use($mass, $non_mass){
            $query->where('sender_id', '!=', $this->id);
            $query->whereIn('id', $mass)->orWhere(function($query) use($non_mass)
            {
                $query->whereIn('id', $non_mass);
            });
        });
        return $return;
    }
        
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
        return $this->belongsToMany('ProductAffiliate', 'purchases', 'student_id', 'product_affiliate_id');
    }
    
    public static function current(User $user){
        if($user!=null) return self::find($user->id);
        return null;
    }
    
    public function courses(){
        $ids = [];
        $lessons = $this->purchases()->where('product_type','Lesson')->get();
        foreach($lessons as $lesson){
            $ids[] = $lesson->product->module->course->id;
        }
        $ids += $this->purchases()->where('product_type','Course')->lists('product_id');
        if(count($ids)==0) return new Illuminate\Database\Eloquent\Collection;
        return Course::whereIn('id', $ids)->get();
    }
    
    /**
     * Purchased the specified course/lesson?
     * @param mixed $product
     * @return boolean
     */
    
    public function purchased($product){
        if( Auth::check() && Auth::user()->hasRole('Admin')) return true;
        $product_type = get_class($product);
        if( !isset( $this->purchased[$product_type])) $this->purchased[$product_type] = $this->purchases()->where( 'product_type', $product_type )->lists('product_id' );
        
        if( in_array ( $product->id, $this->purchased[$product_type] ) ){
            return true;
        }
        return false;
    }
    
    
    /**
     * Purchase a course/lesson
     * @param mixed Course/Lesson
     * @return boolean
     */
    public function purchase($product, $affiliate=null, $paymentData = []){
        
        // cannot buy the same course/lesson twice |  cannot buy own course/lesson
        if( !$this->canPurchase($product) ) return false;
        // if this is the first purchase, set the LTC affiliates - DROPPED
//        if( $this->purchases->count()==0 ) $this->setLTCAffiliate();
        if( get_class($product)=='Course' ){
            $course = $product;
            $course = courseApprovedVersion( $product );
            $product = courseApprovedVersion( $product );
        } 
        else{
            $course = $product->module->course;
        }  
        
        
        
        $purchase = new Purchase;

        $purchase->student_id = $this->id;
        $purchase->purchase_price = $product->cost();
        $purchase->ltc_affiliate_id = $this->ltc_affiliate_id;
        $ltcSTPub = $this->LTCInstructor();
        if( $ltcSTPub !=false ){
            $purchase->ltc_affiliate_id = $ltcSTPub;
        }
        
        if($course->instructor->secondTierInstructor!=null) $purchase->second_tier_instructor_id = $course->instructor->second_tier_instructor_id;
        $purchase->instructor_id = $course->instructor_id;
        /******* Money fields **********/
        $purchase->balance_transaction_id = $paymentData['successData']['balance_transaction_id'];
        $purchase->original_price = $product->price;
        if( $product->isDiscounted() ){
            $purchase->discount_value = $product->discount_saved;
            $purchase->discount = ($product->sale_kind=='amount') ? "Yen $product->sale" : "$product->sale%";
        }
        
        $purchase->processor_fee = $paymentData['successData']['processor_fee'];
        $purchase->tax = $paymentData['successData']['tax'];
        $purchase->gift_id = $paymentData['successData']['giftID'];
        if( $paymentData['successData']['balance_used'] > 0 ){
            $purchase->balance_used = $paymentData['successData']['balance_used'];
            $purchase->balance_transaction_id = $paymentData['successData']['balance_transaction_id'];
        }
        
        $purchase->instructor_earnings = PurchaseHelper::instructorEarnings($product, $purchase->processor_fee, $affiliate);
        $purchase->second_tier_instructor_earnings = PurchaseHelper::secondTierInstructorEarnings($product, $purchase->processor_fee, $purchase->ltc_affiliate_id, $affiliate);
        $purchase->affiliate_earnings = PurchaseHelper::affiliateEarnings($product, $purchase->processor_fee, $affiliate);
        $purchase->second_tier_affiliate_earnings = PurchaseHelper::secondTierAffiliateEarnings($product, $purchase->processor_fee, $affiliate);
        $purchase->ltc_affiliate_earnings = PurchaseHelper::ltcAffiliateEarnings($product, $purchase->ltc_affiliate_id, $purchase->processor_fee, $affiliate, $this);
//        $purchase->instructor_agency_earnings = PurchaseHelper::agencyEarnings($product, $purchase->processor_fee);
        $purchase->site_earnings = PurchaseHelper::siteEarnings($product, $purchase->ltc_affiliate_id, $paymentData['successData']['processor_fee'], $affiliate, $this );
        $purchase->payment_ref = $paymentData['successData']['REF'];
        $purchase->order_id = $paymentData['successData']['ORDERID'];
        /************ Money fields **************/
        if( strtolower( get_class($product) ) == 'course' && $product->payment_type=='subscription' ){
            $purchase->subscription_start = date( 'Y-m-d H:i:s' );
            $purchase->subscription_end = date( 'Y-m-d H:i:s', strtotime( $purchase->subscription_start.' +1 month' ) );
        }
        if($affiliate==null) $purchase->product_affiliate_id = 0;
        elseif( $affiliate=='sp' ) $purchase->product_affiliate_id = -1;
        else{
            $prodAffiliate = ProductAffiliate::where('affiliate_id', $affiliate)->first();
            $purchase->product_affiliate_id = $prodAffiliate->id;
            if( $prodAffiliate->secondTierAffiliate != null){
                $purchase->second_tier_affiliate_id = $prodAffiliate->secondTierAffiliate->id;
            }
        }

        if( $product->sales()->save( $purchase ) ){
            // mark the balanceDebit transaction successful
            if( $purchase->balance_transaction_id >0 ){
                $transaction = Transaction::find( $purchase->balance_transaction_id );
                $transaction->status = 'complete';
                $transaction->updateUniques();
            }
            
            // if course - increment counter only if no lessons have already been purchased, or if this the first recurring payment
            if( strtolower( get_class($product) ) == 'course' ){
                $course = $product;
                if( !$this->purchasedLessonFromCourse($course) ){
                    if( $course->payment_type=='one_time' || 
                            $this->purchases()->where('product_id',$course->id)->where('product_type','Course')->count()==1 ){
                        $course->student_count += 1;
                        $course->updateUniques();
                    }
                }
            }
            // if lesson - increment counter only if course hasn't already been purchased
            else{
                $course = $product->module->course;
                if( !$this->purchased( $course ) ){
                    $course->student_count += 1;
                    $course->updateUniques();
                }
            }
            
            // credit instructor
            $course->instructor->credit( $purchase->instructor_earnings, $product, $purchase->payment_ref, $purchase->id );
            
            // credit second tier instructor
            if( $purchase->second_tier_instructor_earnings > 0){
                $course->instructor->secondTierInstructor->credit( $purchase->second_tier_instructor_earnings, $product, $purchase->payment_ref, $purchase->id);
            }
            
            // credit LTC affiliate
            if( $purchase->ltc_affiliate_earnings > 0){
                $stInstructor = $this->LTCInstructor();
                if(  $stInstructor == false ){
                    $this->ltcAffiliate->credit( $purchase->ltc_affiliate_earnings, $product, $purchase->payment_ref, 'ltc', 0, $purchase->id);
                }
                else{
                    $stInstructor = SecondTierInstructor::find($stInstructor);
                    $stInstructor->credit( $purchase->ltc_affiliate_earnings, $product, $purchase->payment_ref,  $purchase->id, 'ltc' );
                }
            }
            
            // credit second tier affiliate
            if( $purchase->second_tier_affiliate_earnings > 0){
                $secondTier = ProductAffiliate::where('affiliate_id', $affiliate)->first()->secondTierAffiliate;
                $secondTier->credit( $purchase->second_tier_affiliate_earnings, $product, $purchase->payment_ref, 'st', 0, $purchase->id);
            }
            
            // credit product affiliate
            if($affiliate!=null &&  $purchase->affiliate_earnings > 0){
                ProductAffiliate::where('affiliate_id', $affiliate)->first();
                $prodAffiliate->credit( $purchase->affiliate_earnings, $product, $purchase->payment_ref, $purchase->id);
            }
            // credit Instructor Agency
//            if( $course->instructor->instructor_agency_id > 0){
//                $course->instructor->agency->credit( $purchase->instructor_agency_earnings, $product, $purchase->payment_ref, $purchase->id);
//            }
            // credit wazaar
            $wazaar = LTCAffiliate::find(2);
            $wazaar->credit( $purchase->site_earnings, $product, $purchase->payment_ref, 'wazaar', $purchase->processor_fee, $purchase->id);
            
            return $purchase;
        }
        else{
            // mark the balanceDebit transaction successful
            if( $purchase->balance_transaction_id >0 ){
                $transaction = Transaction::find( $purchase->balance_transaction_id );
                $this->refundBalanceDebit( $transaction );
            }
            return false;
        }
    }
    /**
     * Crash a free course/lesson
     * @param mixed Course/Lesson
     * @return boolean
     */
    public function crash($product, $affiliate=null ){
        // cannot buy the same course/lesson twice |  cannot buy own course/lesson
        if( !$this->canPurchase($product) ) return false;
        // if this is the first purchase, set the LTC affiliates
        if( $this->purchases->count()==0 ) $this->setLTCAffiliate();
        $purchase = new Purchase;
        
        $purchase->free_product = 'yes';

        $purchase->student_id = $this->id;
        $purchase->purchase_price = $product->cost();
        $purchase->ltc_affiliate_id = $this->ltcAffiliate->id;
        
        /******* Money fields **********/
        $purchase->original_price = $product->price;
        if( $product->isDiscounted() ){
            $purchase->discount_value = $product->discount_saved;
            $purchase->discount = ($product->sale_kind=='amount') ? "Yen $product->sale" : "$product->sale%";
        }
        /************ Money fields **************/

        if($affiliate==null) $purchase->product_affiliate_id = 0;
        else{
            $prodAffiliate = ProductAffiliate::where('affiliate_id', $affiliate)->first();
            $purchase->product_affiliate_id = $prodAffiliate->id;
        }

        if( $product->sales()->save( $purchase ) ){
            
            // if course - increment counter only if no lessons have already been purchased, or if this the first recurring payment
            if( strtolower( get_class($product) ) == 'course' ){
                $course = $product;
                if( !$this->purchasedLessonFromCourse($course) ){
                    if( $course->payment_type=='one_time' || 
                            $this->purchases()->where('product_id',$course->id)->where('product_type','Course')->count()==1 ){
                        $course->student_count += 1;
                        $course->updateUniques();
                    }
                }
            }
            // if lesson - increment counter only if course hasn't already been purchased
            else{
                $course = $product->module->course;
                if( !$this->purchased( $course ) ){
                    $course->student_count += 1;
                    $course->updateUniques();
                }
            }
            return $purchase;
        }
        else{
            return false;
        }
    }
    
    /**
     * Returns true if the current student purchased one or more lessons from the supplied course
     * @param Course $course
     * @return boolean
     */
    public function purchasedLessonFromCourse(Course $course){
        foreach( $course->modules as $module){
            foreach($module->lessons as $lesson){
                if( $this->purchased( $lesson ) ) return true;
            }
        }
        return false;
    }
    
    /**
     * Set this user's LTC affiliate to Wazaar if purchase takes place 30 days 
     * after registration. Otherwise just keep original affiliate.
     */

    public function setLTCAffiliate(){
        return;
//        $register = new DateTime($this->created_at);
//        $now = new DateTime();
//        if($now->diff($register)->days >=30){
////            $this->ltc_affiliate_id = 2;
//            $this->ltc_affiliate_id = null;
//            $this->save();
//        }
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
    
    private $_completedLessons = [];
    public function isLessonCompleted(Lesson $lesson){
        $completed = false;
        foreach( $this->viewedLessons as $l ){
            if( $lesson->id == $l->lesson_id && $l->state=='completed' ) $completed = true;
        }
        return $completed;
    }
    
    /**
     * Marks a lesson as viewed
     * @param Lesson $lesson
     */
    public function viewLesson(Lesson $lesson, $complete = false){
        if( $complete==false && !$this->isLessonViewed($lesson) ){
            $view = ViewedLesson::create( ['student_id' => $this->id, 'lesson_id' => $lesson->id, 'course_id' => $lesson->module->course->id] );
        }
        else if( $complete == true ){
            $view = ViewedLesson::where( 'student_id', $this->id )->where( 'lesson_id', $lesson->id )->where( 'course_id', $lesson->module->course->id )->first();
            $view->state = 'completed';
            $view->updateUniques();
        }
        else{}
        return true;
    }
    
    public function currentLesson($course){
        $lesson = null;
        $order = 0;
        $module = 0;
        foreach($this->viewedLessons as $l){
            if( $l->course_id == $course->id ){
                if( $l->lesson->module_id > $module){
                    $lesson = $l->lesson;
                    $order = $l->lesson->order;
                    $module = $l->lesson->module_id;
                }
                elseif( $l->lesson->module_id == $module ){
                    if( $l->lesson->order > $order  ){
                        $lesson = $l->lesson;
                        $order = $l->lesson->order;
                        $module = $l->lesson->module_id;
                    }
                }
                else{}
            }
        }
        if($lesson==null) return null;
        return $lesson;
    }
    
    public function courseProgress($course){
        $complete = 0;
        foreach($this->viewedLessons->all() as $viewed){
            if( $viewed->state=='completed' && $viewed->course_id == $course->id ) $complete++;
        }
        $total = 0;
        
        foreach( $course->modules as $module ){
            foreach( $module->lessons as $lesson ){
                if( $lesson->published == 'yes' ) $total++;
            }
        }
        if($total == 0) return 0;
        return ceil( $complete * 100 / $total );
    }
    
    /**
     * Finds the next lesson in the current course
     * @param Course $course (with pre-ordered module and lesson relationships eargerly loaded)
     * @return mixed False if none, the lesson object otherwise
     */
    private $_nextLesson = null;
    public function nextLesson(Course $course){ 
        if($this->_nextLesson != null) return $this->_nextLesson;
        foreach($course->modules()->orderBy('order','asc')->get() as $module){
            foreach($module->lessons()->orderBy('order','asc')->get() as $lesson){
                if( !$this->isLessonViewed($lesson) && ( $this->purchased( $course ) || $this->purchased( $lesson ) ) ){
                    $this->_nextLesson = $lesson;
                    return $lesson;
                }
            }
        }
        $this->_nextLesson = false;
        return false;
    }
    
    

    public function commentName($userType=null){
        if( $this->profile ){
            return $this->profile->first_name.' '.$this->profile->last_name;
        }
        else{
            if($this->first_name=='') return $this->email;
            else return $this->first_name.' '.$this->last_name;
        }
    }
    
    public function credit( $amount = 0 ){
        $amount = doubleval($amount);
        if( $amount < 1 ) return false;
        return DB::transaction(function() use ($amount){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $amount;
              $transaction->transaction_type = 'student_credit';
              $transaction->details = trans('transactions.student_credit_transaction');
              $transaction->status = 'complete';
              if( $transaction->save() ){
                  // increase balance
                  $this->student_balance += $amount;
                  if( $this->updateUniques() ) return true;
                  else return false;
              }
              return false;
         });
    }
    
    public function balanceDebit( $amount = 0, $product = null ){
        $amount = doubleval( $amount );
        if( $amount < 1 || $product == null ) return false;
        if( !is_a($product, 'Lesson') && !is_a($product, 'Course') ) return false;
        if( !$product->id ) return false;
        if( $amount > $this->student_balance ) return false;
        return DB::transaction(function() use ($amount, $product ){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $amount;
              $transaction->transaction_type = 'student_balance_debit';
              $transaction->product_id = $product->id;
              $transaction->product_type = get_class($product);
              $transaction->status = 'pending';
              if( $transaction->save() ){
                  // increase balance
                  $this->student_balance -= $amount;
                  if( $this->updateUniques() ) return $transaction->id;
                  else return false;
              }
              return false;
         });
    }
    
    public function refundBalanceDebit( $transaction ){
        if( !is_a($transaction, 'Transaction' ) ) return false;
        if( $transaction->user->id != $this->id ) return false;
        if( $transaction->transaction_type != 'student_balance_debit' ) return false;
//        if( $transaction->status != 'pending' ) return false;
        return DB::transaction(function() use ( $transaction ){
            // create the transaction
              $transaction->status = 'failed';
              if( $transaction->save() ){
                  $new_transaction = new Transaction();
                  $new_transaction->user_id = $this->id;
                  $new_transaction->amount = $transaction->amount;
                  $new_transaction->transaction_type = 'student_balance_debit_refund';
                  $new_transaction->details = trans('transactions.student_balance_debit_transaction_failed').' #'.$transaction->id;
                  $new_transaction->product_id = $transaction->product_id;
                  $new_transaction->product_type = $transaction->product_type;
                  $new_transaction->status = 'complete';
                  if( $new_transaction->save() ){
                      
                      $transaction->details = trans('refunded #'.$new_transaction->id);
                      $transaction->save();
                      
                      // increase balance
                      $this->student_balance += $transaction->amount;
                      if( $this->updateUniques() ) return $new_transaction->id;
                      else return false;
                  }
              }
              return false;
         });
    }
    
     public function debit( $amount = 0, $product = null, $order = null, $reference = null, $gc_fee = 0 ){
        $amount = doubleval( $amount );
        if( $amount < 1 || $product == null ) return false;
        if( !is_a($product, 'Lesson') && !is_a($product, 'Course') ) return false;
        if( !$product->id ) return false;
        return DB::transaction(function() use ($amount, $product, $order, $reference, $gc_fee){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $amount - $gc_fee;
              $transaction->transaction_type = 'student_debit';
              $transaction->details = trans('transactions.student_debit_transaction').' #'.$order;
              $transaction->product_id = $product->id;
              $transaction->product_type = get_class($product);
              $transaction->reference = $reference;
              $transaction->status = 'complete';
              $transaction->gc_fee = $gc_fee;
              if( $transaction->save() ) return true;
              return false;
         });
     }
     
     function grouppedNotifications( $received ){
         $notifications = [];
         $notification = [];
         //$this->receivedMessages()->unread( $this->id )->get()
         foreach( $received as $pm ){
             if($pm->type=='student_conversation'){
                 $notification['pm']['url'] = action('PrivateMessagesController@index');
                 if( !isset( $notification['pm']['count'] )){
                     $notification['pm']['count'] = 1;
                 }
                 else{
                     $notification['pm']['count']++;
                 }
                 $notification['pm']['senders'][] = $pm->sender->commentName('student');
 
                 $notification['pm']['text'] = trans('conversations/general.you-have').' '. $notification['pm']['count'] .' ' 
                         . trans('conversations/general.new-pm-from'). ' '. implode(', ', $notification['pm']['senders']);
                 
                 $notifications['pm'] = $notification['pm'];
             }
             elseif($pm->type=='mass_message'){
                 $notification['m'.$pm->course->id]['url'] = action('ClassroomController@dashboard', $pm->course->slug);
                 if( !isset( $notification['m'.$pm->course->id]['count'] )){
                     $notification['m'.$pm->course->id]['count'] = 1;
                 }
                 else{
                     $notification['m'.$pm->course->id]['count']++;
                 }
 
                 $notification['m'.$pm->course->id]['text'] = trans('conversations/general.you-have').' '. $notification['m'.$pm->course->id]['count'] 
                        .' ' . trans('conversations/general.new-anouncements-in'). ' '. $pm->course->name;
                 $notifications['m'.$pm->course->id] = $notification['m'.$pm->course->id];
             }
             else{
                 $notification['a'.$pm->course->id]['url'] = action('ClassroomController@dashboard', $pm->course->slug);
                 if( !isset( $notification['a'.$pm->course->id]['count'] )){
                     $notification['a'.$pm->course->id]['count'] = 1;
                 }
                 else{
                     $notification['a'.$pm->course->id]['count']++;
                 }
 
                 $notification['a'.$pm->course->id]['text'] = trans('conversations/general.you-have').' '. $notification['a'.$pm->course->id]['count'] 
                         .' ' . trans('conversations/general.teacher-responses-in'). ' '. $pm->course->name;
                 if($pm->course->instructor_id == $this->id || $pm->course->assigned_instructor_id == $this->id){
                     $notification['a'.$pm->course->id]['url'] = action('CoursesController@dashboard', $pm->course->slug);
                     $notification['a'.$pm->course->id]['text'] = trans('conversations/general.you-have').' '. $notification['a'.$pm->course->id]['count'] 
                             .' ' . trans('conversations/general.student-questions-in'). ' '.$pm->course->name;
                 }
                 $notifications['a'.$pm->course->id] = $notification['a'.$pm->course->id];
             }
         }
         return $notifications;
     }
     
     public function subscriptionModules($course){
         $or = false;
         $purchases = $this->purchases()->where( 'product_id', $course->id )->where( 'product_type', 'Course' )->get();
         return Module::where('course_id', $course->id)->where(function($query) use($purchases, $or){
                        foreach($purchases as $purchase){
                            $start = explode(' ', $purchase->subscription_start);
                            $start = $start[0];
                            $start = explode('-', $start);
                            $start = "$start[0]-$start[1]-01";
                            if($or==false){
                                $query->whereBetween('created_at', [ "$start 00:00:00", "$purchase->subscription_end" ]);
                                $or = true;
                            }
                            else{
                                $query->orWhereBetween('created_at', [ "$start 00:00:00", "$purchase->subscription_end" ]);
                            }
                        }
                    });
     }
     
     public function isLessonSubscribedTo($lesson){
         if( !in_array($lesson->module->id, $this->subscriptionModules($lesson->module->course)->lists('id'))){
            return false;
         }
         return true;
     }
     
     public function LTCInstructor(){
         $user = User::find( $this->id );
         if( !$user->hasRole( 'Instructor' ) ) return false;
         if( strtotime( $user->created_at ) <= strtotime('2015-08-12 23:59:59') && $this->second_tier_instructor_id > 0 ){
             return $this->second_tier_instructor_id;
         }
         return false;
     }
     
     public function lastLessonInCourse($course){   
         $last = null;
         $updated = '0000-00-00 00:00:00';
         foreach( $this->viewedLessons as $lesson ){
             if( $lesson->course_id == $course->id && $lesson->updated_at > $updated ){
                 $updated = $lesson->updated_at;
                 $last = $lesson;
             }
         }
         return $last;
     }



}