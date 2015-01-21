<?php
use LaravelBook\Ardent\Ardent;

class CourseCategory extends Ardent{
    
    public static $relationsData = array(
        'courses' => array(self::HAS_MANY, 'Course', 'table' => 'courses', 'foreignKey' => 'course_category_id'),
        'courseSubcategories' => array(self::HAS_MANY, 'CourseSubcategory'),
    );
    
    public function courses($privacy_status = 'public'){
        if($privacy_status=='public') return Course::where('course_category_id', $this->id)->where('privacy_status', 'public');
        return Course::where('course_category_id', $this->id); 
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