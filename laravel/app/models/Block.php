<?php
use LaravelBook\Ardent\Ardent;

class Block extends Ardent{

    const TYPE_VIDEO = 'video';
    const TYPE_TEXT = 'text';
    const TYPE_FILE = 'file';

    public $fillable = ['content','lesson_id', 'type'];
    
    public static $relationsData = array(
        'lesson' => array(self::BELONGS_TO, 'Lesson'),
    );
    
     public static $rules = [
        'lesson_id' => 'required|exists:lessons,id'
    ];
     
     public function upload($path){
        $key = 'file-'.uniqid();
        $file = file_get_contents($path);
        $mime = mimetype($file);
        $extension = mime_to_extension($mime);
        if( !in_array( $extension, Config::get('custom.course_attachments') ) ) return false;
        
        $s3 = AWS::get('s3');
        $result = $s3->putObject(array(
            'ACL'    => 'public-read',
            'Bucket' => $_ENV['AWS_BUCKET'],
            'ContentType' => $mime,
            'Key'    => 'course_uploads/'.$key.$extension,
            'Body'   => $file
        ));
        $this->content =  $result->get('ObjectURL');
        return true;
    }
    
    /**
     * Delete S3 file
     */
    public function beforeDelete(){
        if($this->type=='file'){
            $s3 = AWS::get('s3');
            $object = explode('course_uploads', $this->content);
            $object = $object[1];
            $result = $s3->deleteObject(array(
                'ACL'    => 'public-read',
                'Bucket' => $_ENV['AWS_BUCKET'],
                'Key'    => 'course_uploads'.$object
            ));
            return true;
        }
    }
    
   

}