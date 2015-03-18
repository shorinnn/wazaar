<?php

use LaravelBook\Ardent\Ardent;

class Lesson extends Ardent {

    public $fillable = ['name', 'order'];
    public static $relationsData = array(
        'module' => array(self::BELONGS_TO, 'Module'),
        'blocks' => array(self::HAS_MANY, 'Block'),
        'comments' => array(self::HAS_MANY, 'Conversation'),
        'privateMessages' => array(self::HAS_MANY, 'PrivateMessage'),
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
    }

    public function beforeSave() {
        $this->slug = Str::slug($this->name);
        if ($this->slug == 'dashboard')
            return false; // the not_in filter not working for "dashboard"????
        // slug should be unique within this module
        $id = isset($this->id) ? $this->id : 0;
        if (!Config::get('custom.use_id_for_slug') && Lesson::where('slug', $this->slug)->where('module_id', $this->module_id)->where('id', '!=', $id)->count() > 0) {
            $this->errors()->add(0, trans('crud/errors.lesson-slug-in-use'));
            return false;
        }
    }

    public function beforeDelete() {
        // delete blocks
        foreach ($this->blocks as $block) {
            $block->delete();
        }
    }
    
    public function cost(){
        return $this->price;
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
}
