<?php
use LaravelBook\Ardent\Ardent;

class GiftFile extends Ardent {
    protected $fillable = [];
    public static $rules = [];
    public static $relationsData = [
        'gift' => [self::BELONGS_TO, 'Gift']
    ];
    
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
        return $command->createPresignedUrl('+10 minutes');
     }
        
    public function upload($path){
        $key = 'gift-file-'.uniqid();
        $file = file_get_contents($path);
        $mime = mimetype($path);
        $extension = mime_to_extension($mime);        
        
        $s3 = AWS::get('s3');
        $result = $s3->putObject(array(
//            'ACL'    => 'public-read',
            'Bucket' => $_ENV['AWS_BUCKET'],
            'ContentType' => $mime,
            'ContentDisposition' => 'attachment',
            'Key'    => 'course_uploads/'.$key.$extension,
            'Body'   => $file
        ));
        $this->url =  $result->get('ObjectURL');
        $this->key = 'course_uploads/'.$key.$extension;
        $this->mime = $mime;
        return true;
    }
    
     /**
     * Delete S3 file
     */
    public function beforeDelete(){
        $s3 = AWS::get('s3');
        $object = explode('course_uploads', $this->url);
        if( count($object) == 1 ) return true;
        $object = $object[1];
        $result = $s3->deleteObject(array(
            'ACL'    => 'public-read',
            'Bucket' => $_ENV['AWS_BUCKET'],
            'Key'    => 'course_uploads'.$object
        ));
        return true;
    }
}