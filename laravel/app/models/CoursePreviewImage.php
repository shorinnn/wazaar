<?php
use LaravelBook\Ardent\Ardent;

class CoursePreviewImage extends Ardent{
    public static $skip_upload = false;
    
    public static $relationsData = array(
        'courses' => array(self::HAS_MANY, 'Course'),
        'instructor' => array(self::BELONGS_TO, 'Instructor'),
    );
    
    public function beforeSave(){
        if(!self::$skip_upload) return $this->upload();
    }
    public function upload(){
        $file = file_get_contents($this->file_path);
        $key = uniqid();
        $mime = mimetype($file);
        $extension = mime_to_extension($mime);
        if( !in_array( $extension, Config::get('custom.course_preview_image.allowed_types') ) ) return false;
        
        Image::make($this->file_path)
                ->resize( Config::get('custom.course_preview_image.width'),
                          Config::get('custom.course_preview_image.height') )->save();
        
        $file = file_get_contents($this->file_path);
        $s3 = AWS::get('s3');
        $result = $s3->putObject(array(
            'ACL'    => 'public-read',
            'Bucket' => $_ENV['AWS_BUCKET'],
            'ContentType' => $mime,
            'Key'    => 'course_preview/'.$key.$extension,
            'Body'   => $file
        ));
        unset($this->file_path);
        $this->url =  $result->get('ObjectURL');
    }

}

