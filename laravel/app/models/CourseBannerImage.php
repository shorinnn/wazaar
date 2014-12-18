<?php
use LaravelBook\Ardent\Ardent;

class CourseBannerImage extends Ardent{
    public static $skip_upload = false;
    
    public static $relationsData = array(
        'courses' => array(self::HAS_MANY, 'Course'),
        'instructor' => array(self::BELONGS_TO, 'Instructor'),
    );
    
    public function beforeSave(){
        if(!self::$skip_upload) $this->upload();
    }
    public function upload(){
        $key = 'banner-'.uniqid();
        
        // resize image to new width but do not exceed original size
        Image::make($this->file_path)->widen( Config::get('custom.course_banner_image.max_width'), function ($constraint) {
            $constraint->upsize();
        })->save();
        
        // resize image to new height but do not exceed original size
        Image::make($this->file_path)->heighten( Config::get('custom.course_banner_image.max_height'), function ($constraint) {
            $constraint->upsize();
        })->save();
        
        $file = file_get_contents($this->file_path);
        $mime = mimetype($file);
        $extension = mime_to_extension($mime);
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

