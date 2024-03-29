<?php

use LaravelBook\Ardent\Ardent;

class Lesson extends Ardent {

    public $fillable = [ 'name', 'order', 'description', 'notes', 'free_preview', 'individual_sale', 'price' ];
    public static $relationsData = array(
        'module' => array(self::BELONGS_TO, 'Module'),
        'blocks' => array(self::HAS_MANY, 'Block'),
        'comments' => array(self::HAS_MANY, 'Conversation'),
        'privateMessages' => array(self::HAS_MANY, 'PrivateMessage'),
        'discussions' => array(self::HAS_MANY, 'LessonDiscussion'),
        'sales' => array(self::MORPH_MANY, 'Purchase', 'name' => 'product' ),
    );
    public static $rules = [
        'module_id' => 'required|exists:modules,id',
        'slug' => 'alpha_dash|not_in:categories,category,purchase,mycourses,destroy,edit,update,curriculum,dashboard,',
    ];

    public function afterSave() {
        if (Config::get('custom.use_id_for_slug') == true) {
            DB::table($this->getTable())->where('id', $this->id)->update(['slug' => PseudoCrypt::hash( $this->id )]);
        }
        $this->module->course->video_minutes = $this->module->course->videoMinutes;
        $this->module->course->updateUniques();
    }

    public function beforeSave() {
        $this->published = 'yes';
        $this->slug = Str::slug($this->name);
        if ($this->slug == 'dashboard')
            return false; // the not_in filter not working for "dashboard"????
        // slug should be unique within this module
        $id = isset($this->id) ? $this->id : 0;
        if (!Config::get('custom.use_id_for_slug') && Lesson::where('slug', $this->slug)->where('module_id', $this->module_id)->where('id', '!=', $id)->count() > 0) {
            $this->errors()->add(0, trans('crud/errors.lesson-slug-in-use'));
            return false;
        }
        if($this->price>0 && $this->price < 500){
            $this->errors()->add(0, 'ワザールで最低レッスン金額は500円以上ですので、500円以上の金額を設定して下さい。' );
            return false;
        }
        
        if( $this->external_video_url != ''){
            if( $id = parse_yturl($this->external_video_url) ){
                $video = Youtube::getVideoInfo( $id ); 
                $this->video_duration = getYTDurationSeconds($video->contentDetails->duration);
            }
            
            if( $id = get_vimeoid($this->external_video_url) ){
                $vimeo = new \Vimeo\Vimeo( Config::get('custom.vimeo.client_id'), Config::get('custom.vimeo.client_secret') );
                $vimeo->setToken( Config::get('custom.vimeo.access_token') );
                $response = $vimeo->request('/videos/'.$id, array('per_page' => 2), 'GET');
                $this->video_duration = $response['body']['duration'];
            }
        }
        else $this->video_duration = 0;
        
       
    }

    public function beforeDelete() {
        // delete blocks
        foreach ($this->blocks as $block) {
            $block->delete();
        }
    }
    
    public function cost( $include_tax = true){
        if( !$include_tax ) return $this->price;
        $cost = $this->price;
        $tax = $cost * Config::get('wazaar.TAX');
        $cost += $tax;
        return $cost;
    }
    
    public function lessonAfter(){
        $found = false;
        $i = 1;
        foreach($this->module->course->modules()->orderBy('order','asc')->get() as $module){
            foreach($module->lessons()->orderBy('order','asc')->get() as $current_lesson){
                if( $found == true ) {
                    $current_lesson->lesson_number = $i;
                    return $current_lesson;
                }
                if( $this->id == $current_lesson->id ) $found = true;
                ++$i;
            }
        }
        return false;
    }
    
    public function isDiscounted(){
        return false;
    }
    
    public function next(){
        // get next lesson in module
        $next = Lesson::where('module_id', $this->module->id)->where('order','>',$this->order)->orderBy('order','asc')->first();
        if( $next ) return $next;
        // get lesson in next module
        $nextModule = Module::where('course_id', $this->module->course_id)->where('order','>',$this->module->order)->first();
        if($nextModule==null) return false;
        $next = Lesson::where('module_id',$nextModule->id)->orderBy('order','asc')->first();
        if($next) return $next;
        return false;
    }
    
    public function prev(){
        // get next lesson in module
        $prev = Lesson::where('module_id', $this->module->id)->where('order','<',$this->order)->orderBy('order','desc')->first();
        if( $prev ) return $prev;
        // get lesson in next module
        $prevModule = Module::where('course_id', $this->module->course_id)->where('order','<',$this->module->order)->first();
        if($prevModule==null) return false;
        $prev = Lesson::where('module_id',$prevModule->id)->orderBy('order','desc')->first();
        if($prev) return $prev;
        return false;
    }
    
    public function attachments(){
        $attachments = [];
        foreach($this->blocks as $block){
            if($block->type=='file') $attachments[] = $block;
        }
        return $attachments;
    }
    
    public function lessonPosition(){
        $modules = $this->module->course->modules()->where('order','<', $this->module->order)->lists('id');
        if( count($modules)==0 ) $modules = [0];
        return $this->module->lessons()->where('order','<',$this->order)->count() + Lesson::whereIn('module_id', $modules)->count() + 1;
    }
    
    public function totalLessons(){
        $modules = $this->module->course->modules()->lists('id');
        if( count($modules)==0 ) $modules = [0];
        return Lesson::whereIn('module_id', $modules)->count();
    }
}
