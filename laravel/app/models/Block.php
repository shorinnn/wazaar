<?php
use LaravelBook\Ardent\Ardent;

class Block extends Ardent{

    public $fillable = ['content','lesson_id'];
    
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
    
   

}