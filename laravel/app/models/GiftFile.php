<?php
use LaravelBook\Ardent\Ardent;

class GiftFile extends Ardent {
    protected $fillable = [];
    public static $rules = [];
    public static $relationsData = [
        'gift' => [self::BELONGS_TO, 'Gift']
    ];
        
    public function upload($path){
        $key = 'gift-file-'.uniqid();
        $file = file_get_contents($path);
        $mime = mimetype($path);
        $extension = mime_to_extension($mime);        
        
        $s3 = AWS::get('s3');
        $result = $s3->putObject(array(
            'ACL'    => 'public-read',
            'Bucket' => $_ENV['AWS_BUCKET'],
            'ContentType' => $mime,
            'ContentDisposition' => 'attachment',
            'Key'    => 'course_uploads/'.$key.$extension,
            'Body'   => $file
        ));
        $this->url =  $result->get('ObjectURL');
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