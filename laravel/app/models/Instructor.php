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
        'agency' => [self::BELONGS_TO, 'InstructorAgency', 'foreignKey' => 'instructor_agency_id'],
        'secondTierInstructor' => [self::BELONGS_TO, 'SecondTierInstructor', 'foreignKey' => 'second_tier_instructor_id'],
        'allTransactions' => [ self::HAS_MANY, 'Transaction', 'foreignKey'=>'user_id' ],
        'ltcAffiliate' => [ self::BELONGS_TO, 'LTCAffiliate', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id', 'otherKey' => 'id' ],
      ];
    
    public function getTransactionsAttribute(){
//        return $this->allTransactions()->where('transaction_type', 'LIKE', "%instructor%")->orWhere(function($query){
//            $query->where('user_id', $this->id)->where('transaction_type','cashout_fee');
//        });
        $types = [
            'instructor_credit',
            'instructor_credit_reverse',
            'instructor_debit',
            'instructor_debit_refund',
            'cashout_fee'
        ];
        return $this->allTransactions()->whereIn('transaction_type', $types);
    }
    
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
    
    public function money($field = 'revenue', $timespan='today'){
        $field = ($field=='revenue') ? 'purchase_price' : 'instructor_earnings';
        $timespan = strtolower($timespan);
        switch($timespan){
            case 'today': $start = date('Y-m-d 00:00:00'); $stop = date('Y-m-d 23:59:59'); break;
            default: $start = date('Y-m-d 00:00:00'); $stop = date('Y-m-d 23:59:59'); break;
        }
        
        if($field=='instructor_earnings'){
            return Purchase::where('instructor_id', $this->id)->where('created_at','>=', $start)->where('created_at','<=', $stop)
                    ->sum($field);
        }
        else{
            $purchases = Purchase::where('instructor_id', $this->id)->where('created_at','>=', $start)->where('created_at','<=', $stop)
                    ->sum($field);
            $tax = Purchase::where('instructor_id', $this->id)->where('created_at','>=', $start)->where('created_at','<=', $stop)
                    ->sum('tax');
            return $purchases-$tax;
        }
        
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
    
    public function credit( $amount = 0, $product = null, $order = null, $purchase_id = 0 ){
        $amount = doubleval($amount);
        if( $amount <= 0 ) return false;
        if( !is_a($product, 'Lesson') && !is_a($product, 'Course') ) return false;
        if( !$product->id ) return false;
        return DB::transaction(function() use ($amount, $product, $order, $purchase_id){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $amount;
              $transaction->product_id = $product->id;
              $transaction->product_type = get_class($product);
              $transaction->transaction_type = 'instructor_credit';
              $transaction->details = trans('transactions.instructor_credit_transaction').' '.$order;

              $transaction->purchase_id = $purchase_id;
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
    
    public function creditReverse( $transaction ){
        if( $transaction->transaction_type!='instructor_credit' || $transaction->user_id != $this->id || $transaction->status!='complete' ){
            return false;
        }
        $old = $transaction;
        return DB::transaction(function() use ($old){
            // create the transaction
              $transaction = new Transaction();
              $transaction->user_id = $this->id;
              $transaction->amount = $old->amount;
              $transaction->purchase_id = $old->purchase_id;
              $transaction->product_id = $old->product_id;
              $transaction->product_type = $old->product_type;
              $transaction->transaction_type = 'instructor_credit_reverse';
              $transaction->details = trans('transactions.instructor_credit_reverse_transaction').' '.$old->reference;

//              $transaction->reference = $order;
              $transaction->status = 'complete';
              if( $transaction->save() ){
                  // increase balance
                  $this->instructor_balance -= $old->amount;
                  if( $this->updateUniques() ){
                      $old->status = 'failed';
                      $old->details .= ' | '.trans('transactions.refunded').' #'.$transaction->id;
                      if( $old->updateUniques() ){
                          return $transaction->id;
                      }
                  }
                  else return false;
              }
              return false;
         });
    }
    
    public function debit( $amount = 0, $reference = null, $transactions_to_mark = null ){
        $amount = doubleval( $amount );
        
        if( $amount > $this->instructor_balance ) return false;
        if( $amount < Config::get('custom.cashout.threshold') ) return false;
        
        return DB::transaction(function() use ($amount, $reference, $transactions_to_mark ){
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
                            $fee_transaction->reference = 'withdraw-'.$transaction->id;
                            $fee_transaction->status = 'pending';
                            $fee_transaction->gc_fee = 0;
                            
                            if( !$fee_transaction->save() ){
                                return false;
                            }
                            // mark transactions as complete
                            $debits = [];
                            foreach($transactions_to_mark as $t){
                                $t->cashed_out_on = date('Y-m-d H:i:s');
                                if( !$t->updateUniques() ) return false;
                                $debits[] = $t->id;
                            }
                            $transaction->debits = json_encode($debits);
                            $transaction->updateUniques();
                      return $transaction->id;
                  }
                  else return false;
              }
              return false;
         });
     }
     
     public function commentName($userType=null){
        if( $this->profile != null ){
            return $this->profile->first_name.' '.$this->profile->last_name;
        }
        else{
            if($this->first_name=='') return $this->email;
            else return $this->first_name.' '.$this->last_name;
        }
    }



}