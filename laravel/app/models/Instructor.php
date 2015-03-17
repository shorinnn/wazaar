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
        'agency' => [self::BELONGS_TO, 'InstructorAgency']
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
        if( $amount < 1 ) return false;
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
    
    public function debit( $amount = 0, $reference = null, $gc_fee = 0 ){
        $amount = doubleval( $amount );
        if( $amount > $this->instructor_balance ) return false;
        return DB::transaction(function() use ($amount, $reference, $gc_fee){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $amount - $gc_fee;
              $transaction->transaction_type = 'instructor_debit';
              $transaction->details = trans('transactions.instructor_debit_transaction');
              $transaction->reference = $reference;
              $transaction->status = 'complete';
              $transaction->gc_fee = $gc_fee;
              if( $transaction->save() ){
                  // increase balance
                  $this->instructor_balance -= $amount;
                  if( $this->updateUniques() ) return $transaction->id;
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