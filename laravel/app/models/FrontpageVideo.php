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
        
        public static function grid(){
            $arr = [];
            $vids = FrontpageVideo::with('course')->get();
            $randoms = Course::orderBy('id','rand')->limit( $vids->count() )->get();
            foreach($vids as $vid){
                if($vid->course_id == 0 ) $vid = $randoms->pull( 0 );
                $aux['name'] = $vid->name;
                $aux['url'] = 'url';
                if($vid->course_preview_image_id == null)                $aux['img'] = "http://placehold.it/350x150&text=Preview Unavailable";
                else                $aux['img'] = $vid->previewImage->url;
                $arr[] = $aux;
            }
            return array_chunk( $arr, 3 );
        }
}