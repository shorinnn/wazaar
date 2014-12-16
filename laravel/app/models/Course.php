<?php
use LaravelBook\Ardent\Ardent;

class Course extends Ardent{
    public $fillable = ['name', 'slug', 'description', 'price', 'course_difficulty_id', 'course_category_id'];
    public static $rules = [
        'name' => 'required',
        'slug' => 'required|alpha_dash|unique:courses|not_in:index,show,create,store,categories,category,purchase',
        'description' => 'required',
        'price' => 'required|numeric',
        'course_difficulty_id' => 'required|numeric',
        'course_category_id' => 'required|numeric',
    ];
    
    public static $relationsData = array(
        'instructor' => array(self::BELONGS_TO, 'Instructor'),
        'previewImage' => array(self::BELONGS_TO, 'CoursePreviewImage'),
        'courseCategory' => array(self::BELONGS_TO, 'CourseCategory'),
        'courseDifficulty' => array(self::BELONGS_TO, 'CourseDifficulty'),
        'sales' => array(self::HAS_MANY, 'CoursePurchase'),
    );
    
    public function upload_preview($picture){
        $file = file_get_contents($picture);
        $mime = mimetype($file);
        $extension = mime_to_extension($mime);
        $s3 = AWS::get('s3');
        $result = $s3->putObject(array(
            'ACL'    => 'public-read',
            'Bucket' => $_ENV['AWS_BUCKET'],
            'ContentType' => $mime,
            'Key'    => 'profile_pictures/'.$key.$extension,
            'Body'   => $file
        ));
        
        $user->photo =  $result->get('ObjectURL');
        $user->save();
    }

}