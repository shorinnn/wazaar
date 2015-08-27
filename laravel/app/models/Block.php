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
     
     public function video(){
         return Video::find($this->content);
     }
     
     public function presignedUrl(){
        $client = AWS::get('s3');
        // Get a command object from the client and pass in any options
        // available in the GetObject command (e.g. ResponseContentDisposition)
        $command = $client->getCommand('GetObject', array(
            'Bucket' => $_ENV['AWS_BUCKET'],
            'Key' => $this->key
        ));
        // Create a signed URL from the command object that will last for
        // 10 minutes from the current time
        $url = $command->createPresignedUrl('+10 minutes');
        return $url;//cloudfrontUrl($url);
//        $signed = explode('.com/', $url);
//        $signed = '//'.getenv('CLOUDFRONT_DOMAIN').'/'.$signed[1];
//        return $signed;
     }
     public static function presignedUrlFromKey($key){
        $client = AWS::get('s3');
        $command = $client->getCommand('GetObject', array(
            'Bucket' => $_ENV['AWS_BUCKET'],
            'Key' => $key
        ));
        // Create a signed URL from the command object that will last for
        // 10 minutes from the current time
        $url = $command->createPresignedUrl('+1 minutes');
        return $url;
     }
     
     
     public function upload($path){
        $key = 'file-'.uniqid();
        $file = file_get_contents($path);
        $mime = mimetype($path);
//        dd($mime);
        $extension = mime_to_extension($mime);
        
        if( !in_array( $extension, Config::get('custom.course_attachments') ) ) return false;
        
        $s3 = AWS::get('s3');
        $result = $s3->putObject(array(
//            'ACL'    => 'public-read',
            'Bucket' => $_ENV['AWS_BUCKET'],
            'ContentType' => $mime,
            'ContentDisposition' => 'attachment',
            'Key'    => 'course_uploads/'.$key.$extension,
            'Body'   => $file
        ));
        $this->key = 'course_uploads/'.$key.$extension;
        $this->mime = $mime;
        $this->content =  $result->get('ObjectURL');
        return true;
    }
    
    public function afterSave(){
        if($this->type=='video'){
            $this->lesson->module->course->video_minutes = $this->lesson->module->course->videoMinutes;
            $this->lesson->module->course->updateUniques();
        }
    }
    
    /**
     * Delete S3 file
     */
    public function beforeDelete(){
        if($this->type=='file'){
            $s3 = AWS::get('s3');
            $object = explode('course_uploads', $this->content);
            if( count($object) == 1 ) return true;
            $object = $object[1];
            $result = $s3->deleteObject(array(
                'ACL'    => 'public-read',
                'Bucket' => $_ENV['AWS_BUCKET'],
                'Key'    => $this->key
//                'Key'    => 'course_uploads'.$object
            ));
//            dd($result);
            return true;
        }
    }
    
    public function size(){
        if($this->size == ''){ 
            $head = array_change_key_case(get_headers($this->presignedUrl(), TRUE));
            $filesize = isset( $head['content-length'] ) ? $head['content-length'] : 0;
            $this->size = formatSizeUnits( $filesize );
            $this->updateUniques();
        }
        return $this->size;
    }
   

}