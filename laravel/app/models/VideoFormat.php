<?php

class VideoFormat extends \LaravelBook\Ardent\Ardent
{
    protected $table = 'video_formats';
    protected $guarded = ['id'];

    public function getDurationAttribute($value)
    {
        if( $value < 3600 ) return gmdate("i:s", $value);
        return gmdate("h:i:s", $value);
    }

    public function getVideoUrlAttribute($value)
    {
        // return old url for production
        if(App::environment()=='production'){
            $outputDomain   = 'http://'. Config::get('wazaar.AWS_WEB_DOMAIN');
            return $outputDomain . '/' . $value;
        }
        
        // create video url that expires in 5 seconds
        $client = AWS::get('s3');
        $command = $client->getCommand('GetObject', array(
            'Bucket' => 'videosoutput-tokyo',
            'Key' => $value
        ));

        try{
            $url = $command->createPresignedUrl('+5 seconds');
        }
        catch(Exception $e){
            return $e->getMessage();
        }
        // encrypt the url so it's not visible in the source
        $encryptor = new \GibberishAES();
        $url = $encryptor->encrypt($url, 'wzrencvid');
        return $url;
    }

    public function getThumbnailAttribute($value)
    {
        $outputDomain   = 'http://'. Config::get('wazaar.AWS_WEB_DOMAIN');
        return $outputDomain . '/' . $value;
    }

}