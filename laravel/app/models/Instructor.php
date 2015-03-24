<?php

class Instructor extends User{

    protected $table = 'users';

    public static $relationsData = [
        'coursesRel' => [self::HAS_MANY, 'Course'],
        'coursePreviewImages' => [self::HAS_MANY, 'CoursePreviewImage'],
        'courseBannerImages' => [self::HAS_MANY, 'CourseBannerImage'],
        'profile' => [self::MORPH_ONE, 'Profile', 'name'=>'owner'],
        'followers' => [self::BELONGS_TO_MANY, 'Student',  'table' => 'follow_relationships',  'foreignKey' => 'instructor_id', 'otherKey' => 'student_id'],
        'sentMessages' => [ self::HAS_MANY, 'PrivateMessage', 'foreignKey' => 'sender_id' ],
        'receivedMessages' => [ self::HAS_MANY, 'PrivateMessage', 'foreignKey' => 'recipient_id' ],
        'agency' => [self::BELONGS_TO, 'InstructorAgency', 'foreignKey' => 'instructor_agency_id']
      ];
    
    
    public function getCoursesAttribute()
    {
        return $this->courses()->get();
    }
    public function courses(){
        $ids = $this->coursesRel()->lists('id');
        if( count($ids) ==0 ) return Course::where('assigned_instructor_id', $this->id);
        else return Course::where('assigned_instructor_id', $this->id)->orWhereIn('id',$ids);
    }
    
    public function totalSales(){
        $amount = 0;
        foreach($this->coursesRel as $course){
             $amount += $course->sales->sum('purchase_price') + $course->lessonSales();
        }
        return $amount;
    }
    
    public function followed($student_id){
        
        if( in_array( $student_id, $this->followers()->lists('student_id') ) ) return true;
        return false;
    }
    
    public function notifyFollowers( $course ){
        $data['course'] = $course;
        $data['instructor'] = $this;
        if( $this->followers->count() > 0 ){
            foreach($this->followers as $follower){
                $data['follower'] = $follower;
                Mail::send('emails.course_published', $data, function($message) use($follower){
                    $message->to( $follower->email )->subject('New Course Published');
                });
            }
        }
    }
    
    public function credit( $amount = 0, $product = null, $order = null ){
        $amount = doubleval($amount);
        if( $amount <= 0 ) return false;
        if( !is_a($product, 'Lesson') && !is_a($product, 'Course') ) return false;
        if( !$product->id ) return false;
        return DB::transaction(function() use ($amount, $product, $order){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $amount;
              $transaction->product_id = $product->id;
              $transaction->product_type = get_class($product);
              $transaction->transaction_type = 'instructor_credit';
              $transaction->details = trans('transactions.instructor_credit_transaction').' '.$order;

              $transaction->reference = $order;
              $transaction->status = 'complete';
              if( $transaction->save() ){
                  // increase balance
                  $this->instructor_balance += $amount;
                  if( $this->updateUniques() ) return $transaction->id;
                  else return false;
              }
              return false;
         });
    }
    
    public function debit( $amount = 0, $reference = null  ){
        $amount = doubleval( $amount );
        
        if( $amount > $this->instructor_balance ) return false;
        if( $amount < Config::get('custom.cashout.threshold') ) return false;
        
        return DB::transaction(function() use ($amount, $reference ){
              $fee = Config::get('custom.cashout.fee');
              $cashout = $amount - $fee;
              
              // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $cashout;
              $transaction->transaction_type = 'instructor_debit';
              $transaction->details = trans('transactions.instructor_debit_transaction');
              $transaction->reference = $reference;
              $transaction->status = 'pending';
              $transaction->gc_fee = 0;
              if( $transaction->save() ){
                  // increase balance
                  $this->instructor_balance -= $amount;
                  if( $this->updateUniques() ){
                      // store the fee
                            $fee_transaction = new Transaction();
                            $fee_transaction->user_id = $this->id;
                            $fee_transaction->amount = $fee;
                            $fee_transaction->transaction_type = 'cashout_fee';
                            $fee_transaction->details = trans('transactions.cashout_fee'). ' #'.$transaction->id;
                            $fee_transaction->reference = $transaction->id;
                            $fee_transaction->status = 'pending';
                            $fee_transaction->gc_fee = 0;
                            
                            if( !$fee_transaction->save() ){
                                return false;
                            }
                      return $transaction->id;
                  }
                  else return false;
              }
              return false;
         });
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


}