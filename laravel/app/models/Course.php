<?php
use LaravelBook\Ardent\Ardent;

class Course extends Ardent{
    
    public $autoPurgeRedundantAttributes = true;
    function __construct($attributes = array()) {
        parent::__construct($attributes);

        $this->purgeFilters[] = function($key) {
          $purge = array( 'discount_ends_in', 'discount_original', 'discount_saved');
          return ! in_array($key, $purge);
        };
      }

    protected $dates = [ 'sale_starts_on', 'sale_ends_on' ];
    public $fillable = ['name', 'slug', 'description', 'short_description', 'price', 'course_difficulty_id', 'course_category_id', 'course_subcategory_id',
        'course_preview_image_id',  'course_banner_image_id', 'privacy_status', 'who_is_this_for', 'affiliate_percentage', 
        'payment_type', 'requirements','description_video_id', 'discussions'];
    
    public static $rules = [
        'name' => 'required|unique:courses',
        'slug' => 'alpha_dash|unique:courses|not_in:index,show,create,store,categories,category,purchase,mycourses,destroy,edit,update,dashboard,curriculum',
        'price' => 'numeric',
        'affiliate_percentage' => 'numeric|between:0,68',
        'course_difficulty_id' => 'numeric',
        'course_category_id' => 'numeric',
        'course_subcategory_id' => 'numeric',
        'course_preview_image_id' => 'numeric',
        'course_banner_image_id' => 'numeric',
        'sale' => 'numeric'
    ];
    
    public static $relationsData = array(
        'instructor' => array(self::BELONGS_TO, 'Instructor'),
        'assignedInstructor' => array(self::BELONGS_TO, 'Instructor', 'foreignKey' => 'assigned_instructor_id'),
        'previewImage' => array(self::BELONGS_TO, 'CoursePreviewImage', 'foreignKey' => 'course_preview_image_id'),
        'bannerImage' => array(self::BELONGS_TO, 'CourseBannerImage', 'foreignKey' => 'course_banner_image_id'),
        'courseCategory' => array(self::BELONGS_TO, 'CourseCategory'),
        'courseSubcategory' => array(self::BELONGS_TO, 'CourseSubcategory'),
        'courseDifficulty' => array(self::BELONGS_TO, 'CourseDifficulty'),
        'sales' => array(self::MORPH_MANY, 'Purchase', 'name' => 'product' ),
        'courseReferrals' => array(self::HAS_MANY, 'CourseReferral'),
        'modules' => array(self::HAS_MANY, 'Module'),
        'testimonials' => [ self::HAS_MANY, 'Testimonial' ],
        'comments' => [self::HAS_MANY, 'Conversation'],
        'messages' => [self::HAS_MANY, 'PrivateMessage'],
        'gifts' => [self::HAS_MANY, 'Gift'],
        'affiliateCustomPercentages' => [self::HAS_MANY, 'CourseAffiliateCustomPercentage'],
        'descriptionVideo' => [self::BELONGS_TO, 'Video', 'foreignKey' => 'description_video_id'],
    );
    
    public function dashboardComments(){
        return $this->comments()->where( 'lesson_id', null );
    }
    public function lessonCount(){
        $lessons = $modules = [0];
        $modules = Module::where('course_id', $this->id)->lists('id');
        $count = 0;
        if(count($modules) > 0){
            $lessons = Lesson::whereIn('module_id', $modules)->lists('id');
            $count += count($lessons);
        }
        return $count;
    }
    public function lessonComments(){
        $lessons = $modules = [0];
        $modules = Module::where('course_id', $this->id)->lists('id');
        if(count($modules) > 0){
            $lessons = Lesson::whereIn('module_id', $modules)->lists('id');
            if(count($lessons) == 0) $lessons = [0];
        }
        return Conversation::whereIn('lesson_id', $lessons);
    }
    
    public function questions(){
        return $this->messages()->where( 'type', 'ask_teacher' )->where('status', 'unread')
            ->where(function($query){
                $query->where('recipient_id', '>', 0)->where('recipient_id', $this->instructor_id)
                        ->orWhere('recipient_id', $this->assigned_instructor_id)->where('recipient_id', '>', 0);
            });
    }
  
    public function lessonSales(){
        $amount = 0;
        foreach($this->modules as $module){
            foreach($module->lessons as $lesson){
                $amount += $lesson->sales->sum('purchase_price');
            }
        }
        return $amount;
    }
    
    public function videoBlocks(){
        $lesson_ids = [];
        $module_ids = $this->modules->lists('id');
        if( count($module_ids)==0 ) return null;
        $lesson_ids = Lesson::whereIn('module_id', $module_ids)->lists('id');
        return Block::where('type','video')->whereIn('lesson_id', $lesson_ids)->get();
    }
    
    public function upload_preview($path){
        $preview = new CoursePreviewImage();
        $preview->file_path = $path;
        $preview->instructor_id = $this->instructor->id;
        if($preview->save()){
            $this->previewImage()->associate($preview);
            if(!$this->updateUniques()) return false;
            return $preview;
        }
        else{
           return false;
        }
        return true;
    }
    
    public function upload_banner($path){
        $banner = new CourseBannerImage();
        $banner->file_path = $path;
        $banner->instructor_id = $this->instructor->id;
        if($banner->save()){
            $this->bannerImage()->associate($banner);
            if(!$this->updateUniques()) return false;
            else return $banner;
        }
        else{
           return false;
        }
        return true;
    }
    
    
    public function scopeFeatured($query)
    {
        return $query->where('featured', 1)->where('privacy_status', 'public');
    }
    
    public function beforeDelete(){
        if($this->student_count > 0){
            $this->errors()->add(0, trans('courses/general.cannot_delete_has_students') );
            return false;
        }
        // delete modules
        foreach($this->modules as $module){
            $module->delete();
        }
    }
    
//    public function afterSave(){
//        if( Config::get('custom.use_id_for_slug')==true ) {
//            DB::table( $this->getTable() )->where('id', $this->id)->update( ['slug' => PseudoCrypt::hash( $this->id ) ] );
//        }
//    }
    
    public function beforeSave(){
        if($this->free=='yes' && $this->price > 0){
            $this->errors()->add(0, trans('courses/general.cant-set-price-for-free-course') );
            return false;
        }
//        if( $this->id > 0 && $this->free=='no' && $this->price == 0 ){
//            $this->errors()->add(0, trans('courses/general.course-must-be-500') );
//            return false;
//        }
        
        if($this->price>0){
            $this->price = round2( $this->price, 10 );
        }
        if($this->sale>0 && $this->sale_kind=='amount'){
            $this->sale = round2( $this->sale, 10 );
        }
        if( Config::get('custom.use_id_for_slug')==true ) {
            if( !$this->id ){
                $id = DB::table('courses')->orderBy('id','desc')->first();
                if( $id == null ) $id = 1;
                else $id = $id->id + 1;
                $this->slug = PseudoCrypt::hash( $id );
            }
        }
        else{
            $this->slug = Str::slug($this->name);
        }
        if( trim($this->short_description) == '' ) $this->short_description = Str::limit($this->description, Config::get('custom.short_desc_max_chars') );
        
        if($this->sale_kind=='percentage' && $this->sale  > 100){
            $this->errors()->add(0, trans('courses/general.cant_discount_101_percent') );
            return false;
        }
        $percentage = ($this->sale/100);
        
//        if($this->sale_kind=='percentage' && ( $this->price - ($this->price * $percentage) < 500 && $this->price - ($this->price * $percentage) != 0 ) ){
//            $this->errors()->add(0, trans('courses/general.after-sale-course-must-be-free-or-500') );
//            return false;
//        }
        if($this->sale_kind=='percentage' && ( $this->price - ($this->price * $percentage) < 500 ) ){
            $this->errors()->add(0, trans('courses/general.after-sale-course-must-be-500') );
            return false;
        }
        
        if($this->sale_kind=='amount' && $this->sale  > $this->price){
            $this->errors()->add(0, trans('courses/general.cant_discount_more_than_price') );
            return false;
        }
        
//        if($this->sale_kind=='amount' && ( $this->price - $this->sale  < 500 && $this->price - $this->sale !=0 ) ){
//            $this->errors()->add(0, trans('courses/general.after-sale-course-must-be-free-or-500') );
//            return false;
//        }
        if($this->sale_kind=='amount' && $this->sale > 0 &&( $this->price - $this->sale  < 500 ) ){
            $this->errors()->add(0, trans('courses/general.after-sale-course-must-be-500') );
            return false;
        }
        
        if( $this->sale<0 ){
            $this->errors()->add(0, trans('courses/general.no_negative_discounts') );
            return false;
        }
        // sale start can't be before sale end
        if( $this->sale > 0){
            if( $this->sale_ends_on=='' || $this->sale_starts_on=='' || ( strtotime($this->sale_ends_on) < strtotime($this->sale_starts_on) ) ){
                $this->errors()->add(0, trans('courses/general.sale-end-must-occur-after-start') );
                return false;
            }
            $minutes = strtotime($this->sale_ends_on) - strtotime($this->sale_starts_on);
            $minutes /= 60;
            
            if( $this->sale_ends_on=='' || $this->sale_starts_on=='' || (  $minutes < 10) ){
                $this->errors()->add(0, trans('courses/general.sale-period-min-10-minutes') );
                return false;
            }
            
        }
        if( $this->id > 0 && $this->price!=0 && $this->price < 500 ){
//            $this->errors()->add(0, trans('courses/general.course-must-be-free-or-500') );
            $this->errors()->add(0, trans('courses/general.course-must-be-500') );
            return false;
        }
//        if( $this->free=='no' && $this->price < 500 ){
////            $this->errors()->add(0, trans('courses/general.course-must-be-free-or-500') );
//            $this->errors()->add(0, trans('courses/general.course-must-be-500') );
//            return false;
//        }
        // update category counter
        if($this->isDirty('course_category_id')){
            $old = $this->getOriginal();
            if( count($old)>0 ){
                $oldCategory = CourseCategory::find( $old['course_category_id'] );
                if($oldCategory!=null){
                    $oldCategory->courses_count--;
                    $oldCategory->save();
                }
            }
            $category = CourseCategory::find($this->course_category_id);
            if($category!=null){
                $category->courses_count += 1;
                $category->save();
            }
        }
        // update subcategory counter
        if($this->isDirty('course_subcategory_id')){
            $old = $this->getOriginal();
            if( count($old)>0 ){
                $oldSubCategory = CourseSubcategory::find( $old['course_subcategory_id'] );
                if($oldSubCategory!=null){
                    $oldSubCategory->courses_count--;
                    $oldSubCategory->save();
                }
            }
            $subcategory = CourseSubcategory::find($this->course_subcategory_id);
            if($subcategory!=null){
                $subcategory->courses_count += 1;
                $subcategory->save();
            }
        }
    }
    
    public function isNew(){
        if($this->force_new == 1) return true;
        if($this->student_count > Config::get('custom.course_is_new.maximum_students')) return false;
        $creation_date = date_create($this->created_at);
        $now = date_create();
        $posted_ago = (int)date_diff($creation_date, $now)->format('%m');
        if( $posted_ago >= Config::get('custom.course_is_new.maximum_months')) return false;
        return true;
    }
    
    public function cost(){
        if(!$this->isDiscounted()) return $this->price;
        else{
            if($this->sale_kind=='amount') return $this->price - $this->sale;
            else return $this->price - ($this->price * ($this->sale/100));
        }
    }
    
    public function isDiscounted(){
        if($this->sale==0 || $this->sale_starts_on > date('Y-m-d H:i:s') || $this->sale_ends_on < date('Y-m-d H:i:s')) return false;
        else{
            $now = new DateTime();
            $future_date = new DateTime($this->sale_ends_on);
            $interval = $future_date->diff($now);
            if($interval->format("%d")>0){
                $this->discount_ends_in = $interval->format("%d days %h:%i:%s");
            }
            else{
                $this->discount_ends_in = $interval->format("%h:%i:%s");
            }
            if($this->sale_kind=='amount'){
                $this->discount_original = $this->price;
                $this->discount_saved = $this->sale;
            }
            else {
                $this->discount_original = $this->price;
                $this->discount_saved = $this->price * ($this->sale/100);
            }
            return true;
        }
    }


}