<?php
use LaravelBook\Ardent\Ardent;
use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;


class WazaarPicks extends Ardent
{  
    public $table = 'wazaar_pick_courses';
    public $fillable = ['course_id', 'order'];


    public static function getLatestOrder()
    {

    	$latest_order = DB::table('wazaar_pick_courses')->select('order')->orderBy('order', 'desc')->first();
    	$new_order = 1;
    	if(count($latest_order) >= 1){
	    	$new_order = $latest_order->order + 1;
    	}

    	return $new_order;
    }
}