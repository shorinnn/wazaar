<?php
use LaravelBook\Ardent\Ardent;

class Transaction extends Ardent {
	protected $fillable = [];
        public static $rules = [];
        public static $relationsData = [
            'user' => [self::BELONGS_TO, 'User']
        ];
        
        public function reverseDebit(){
            // create refund transaction
            return DB::transaction(function(){
                // get the fee transaction
                $fee = Transaction::where('reference', 'withdraw-'.$this->id)->first();
                $amount = $fee->amount + $this->amount;
                
                $refund = new Transaction();
                $refund->user_id = $this->user_id;
                $refund->transaction_type = $this->transaction_type.'_refund';
                $refund->details = "Refunded #$this->id & #$fee->id";
                $refund->amount = $amount;
                $refund->status = 'complete';
                $refund->save();

                
                // mark them as rejected
                $this->status = $fee->status = 'failed';
                $this->details = $fee->details = 'Failed. Refunded by #'.$refund->id;

                $fee->updateUniques();
                $this->updateUniques();

                // restore balance
                if($this->transaction_type == 'instructor_debit' || $this->transaction_type == 'second_tier_instructor_debit') $field = 'instructor_balance';
                elseif($this->transaction_type=='affiliate_debit') $field = 'affiliate_balance';
                else $field = 'agency_balance';
                
                // mark debits as not addressed, so they get addressed on next cashout request
                $credits = json_decode( $this->debits, true);
                if(count($credits) > 0){
                    DB::table('transactions')->whereIn('id', $credits)->update( [ 'cashed_out_on' => null] );
                }
                
                $this->user->$field += $amount;
                $this->user->updateUniques();
            });
            
        }
}