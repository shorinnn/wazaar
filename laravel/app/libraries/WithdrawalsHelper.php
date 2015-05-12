<?php

class WithdrawalsHelper{
    
    public static function complete( $requests, $references){
        foreach($requests as $key=>$val){
            // complete the request
            $transaction = Transaction::find( $val );
            $transaction->status = 'complete';
            $transaction->reference = $references[ $val ];
            $transaction->updateUniques();
            // complete the cashout fee
            $fee = Transaction::where( 'reference', 'withdraw-'.$transaction->id )->first();
            $fee->status = 'complete';
            $fee->updateUniques();
        }
    }
    
    public static function reject( $requests ){
        foreach($requests as $key=>$val){
            // complete the request
            $transaction = Transaction::find( $val );
            $transaction->reverseDebit();
        }
    }
    
    public static function generateFile($time){
        $startDate = date('Y-m-01', strtotime($time) );
        $endDate = date('Y-m-d', strtotime($startDate.' + 1 month'));
        $endDate = date('Y-m-d', strtotime($endDate.' - 1 day'));
        $types = [ 'affiliate_debit', 'instructor_agency_debit', 'instructor_debit', 'second_tier_instructor_debit' ];
        $withdrawals = Transaction::whereIn('transaction_type', $types)
                                    ->where('status','complete')
                                    ->whereBetween('created_at', ["$startDate", "$endDate"])->get();
        // payer record
        $date = date('md');
        $str = "1,21,0,4618933800,ｶ)ﾐﾝｶﾚ,$date,0009,ﾐﾂｲｽﾐﾄﾓ,015,ﾄｳｷｮｳﾁｭｳｵｳ,1,8901282,,\n";
        foreach($withdrawals as $w){
            switch($w->transaction_type){
                case 'affiliate_debit': $user = LTCAffiliate::find($w->user_id); break;
                case 'instructor_agency_debit': $user = Instructor::find($w->user_id); break;
                case 'instructor_debit': $user = Instructor::find($w->user_id); break;
                case 'second_tier_instructor_debit': $user = Instructor::find($w->user_id); break;
                default: $user = Student::find($w->user_id);
            }
            if( !$user->profile ){
                $user = Student::find($w->user_id);
            }
            $profile = $user->profile;
            if( !$profile ) $profile = new Profile();
            // payee record
            $str.="2,$profile->bank_code,$profile->bank_name,$profile->branch_code,$profile->branch_name,0,$profile->account_type,$profile->account_number,$profile->beneficiary_name,$w->amount,0,0,0,7,\n";
        }
        // trailer record
        $str.= "8,5,3775000,\n";
        // end record
        $str.= '9,';
        return $str;
        
    }
    
}