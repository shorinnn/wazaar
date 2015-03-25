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
    
}