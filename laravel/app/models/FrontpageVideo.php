<?php
use LaravelBook\Ardent\Ardent;

class FrontpageVideo extends Ardent {
	protected $fillable = ['video_id', 'type'];
        public static $rules = [];
        public static $relationsData = [
            'course' => [self::BELONGS_TO, 'Course']
        ];
        
        public static function batchUpdate($videos){
            foreach($videos as $key=>$val){
                FrontpageVideo::where('id', $key)->update( ['course_id' => $val] );
            }
        }
}