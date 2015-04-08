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
            $randoms = Course::where('privacy_status','public')->where('publish_status','approved')->orderBy('id','rand')->limit( $vids->count() )->get();
            foreach($vids as $vid){
                if($vid->course_id == 0 ){
                    $vid->course = $randoms->random( 1 );
                }
                $aux['id'] = $vid->course->id;
                $aux['name'] = $vid->course->name;
                $aux['url'] = action( 'CoursesController@show', $vid->course->slug ).'?autoplay=true';
                if($vid->course->previewImage == null || $vid->course->previewImage->url ==null ){                
                    $aux['thumb'] = "http://placehold.it/350x150&text=".trans('general.preview-unavailable');
                }
                else{                
                    $aux['thumb'] = $vid->course->previewImage->url;
                    if( $vid->type == 'big' ){
                        $url = str_replace('course_preview/', 'course_preview/hi-res-', $vid->course->previewImage->url);
                        $file_headers = @get_headers($url);
                        $aux['thumb'] = $url;
                    }
                }
                $arr[] = $aux;
            }
            return array_chunk( $arr, 3 );
        }
}