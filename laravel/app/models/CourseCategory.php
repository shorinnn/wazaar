<?php
use LaravelBook\Ardent\Ardent;

class CourseCategory extends Ardent{
    
    public static $relationsData = array(
        'allCourses' => array(self::HAS_MANY, 'Course', 'table' => 'courses', 'foreignKey' => 'course_category_id'),
        'courseSubcategories' => array(self::HAS_MANY, 'CourseSubcategory'),
    );
    
    public function homepageCourses(){
         return $this->allCourses()->orderBy('id','desc')->where('featured',0)
                 ->where('publish_status','approved')
                 ->where('privacy_status','public')->limit(6);
    }
    
    public function unauthenticatedHomepageCourses(){
         return $this->allCourses()->orderBy('id','desc')
                 ->where('publish_status','approved')
                 ->where('privacy_status','public')->limit(11);
    }

    public function featuredCourse(){
        return $this->allCourses()->where('featured',1)->where('publish_status','approved');
    }
    
    public function courses($privacy_status = 'public'){
        if($privacy_status=='public') return Course::where('course_category_id', $this->id)->where('privacy_status', 'public');
        return Course::where('course_category_id', $this->id); 
   }
   
   public function afterSave(){
        if( Config::get('custom.use_id_for_slug')==true ) {
            DB::table( $this->getTable() )->where('id', $this->id)->update( ['slug' => PseudoCrypt::hash( $this->id )] );
        }
    }
    
   public function beforeSave(){
       $this->slug = Str::slug( $this->name );
   }
   
   public function beforeDelete(){
       if($this->courses()->count() > 0){
            $this->errors()->add(0, trans('general.cannot_delete_category_has_courses' ) );
            return false;
       }
        
       $this->delete_graphic();
       
       foreach($this->courseSubcategories as $subcategory){
           $subcategory->delete();
       }
   }
   
   public function upload_graphics($path){
       // remove old file
       $this->delete_graphic();
       
       // upload new file
        $file = file_get_contents($path);
        $key = uniqid();
        $mime = mimetype($file);
        $extension = mime_to_extension($mime);
        if( !in_array( $extension, Config::get('custom.course_preview_image.allowed_types') ) ) return false;
        
        $file = file_get_contents($path);
        $s3 = AWS::get('s3');
        $result = $s3->putObject(array(
            'ACL'    => 'public-read',
            'Bucket' => $_ENV['AWS_BUCKET'],
            'ContentType' => $mime,
            'Key'    => 'assets/category-img-'.$key.$extension,
            'Body'   => $file
        ));
        $this->graphics_url =  $result->get('ObjectURL');
    }
    
    public function delete_graphic(){
        if(trim($this->graphics_url)!=''){
            $s3 = AWS::get('s3');
            $object = explode('assets', $this->graphics_url);
            $object = $object[1];
            $result = $s3->deleteObject(array(
                'ACL'    => 'public-read',
                'Bucket' => $_ENV['AWS_BUCKET'],
                'Key'    => 'assets'.$object
            ));
            return true;
        }
    }

}