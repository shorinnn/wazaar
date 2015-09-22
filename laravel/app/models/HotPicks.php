<?php
use LaravelBook\Ardent\Ardent;
use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;


class HotPicks extends Ardent
{  
    public $table = 'hot_pick_courses';
    public $fillable = ['course_id', 'order'];


    public static function getLatestOrder()
    {

    	$latest_order = DB::table('hot_pick_courses')->select('order')->orderBy('order', 'desc')->first();
    	$new_order = 1;
    	if(count($latest_order) >= 1){
	    	$new_order = $latest_order->order + 1;
    	}

    	return $new_order;
    }

    public static function reorderAll()
    {
        $courses = HotPicks::orderBy('order', 'asc')->get();

        foreach($courses as $course){
            $previous = HotPicks::select('order')->where('order', '<', $course->order)->orderBy('order', 'desc')->first();
            if(count($previous) >= 1){
                $course->order = $previous->order + 1;
            } else {
                $course->order = 1;
            }
            $course->save();
        }

        return true;
    }

    public static function updateOrder($cids)
    {
        foreach ($cids as $id => $order) {

            $current_course = HotPicks::where('id', '=', $id)->first();
            if($current_course->order != $order){
                $previous_courses = HotPicks::where('order', '>=', $order)->where('id', '!=', $current_course->id)->orderBy('order', 'desc')->get();

                if(count($previous_courses) >= 1){
                    foreach($previous_courses as $previous_course){
                        $previous_course->order = $previous_course->order + 1;
                        $previous_course->save();
                    }
                }

                $current_course->order = $order;
                $current_course->save();
            }
            
        }

        return true;
    }
}