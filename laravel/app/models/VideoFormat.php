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
        // edit: all videos will now expire (Oct 9 2015) including production
        //if(App::environment()=='production'){
            //$outputDomain   = 'http://'. Config::get('wazaar.AWS_WEB_DOMAIN');
            //return $outputDomain . '/' . $value;
        //}
        
        // create video url that expires in 5 seconds
        //$client = AWS::get('s3');
        //$command = $client->getCommand('GetObject', array(
        //    'Bucket' => 'videosoutput-tokyo',
        //    'Key' => $value
        //));

        try{
            //$url = $command->createPresignedUrl('+5 seconds');
            $cloudFrontKeyPair = Config::get('wazaar.CLOUDFRONT_KEY_PAIR');
            $cloudFront = \Aws\CloudFront\CloudFrontClient::factory(array(
                'private_key' => base_path() . '/pk-'. $cloudFrontKeyPair .'.pem',
                'key_pair_id' => $cloudFrontKeyPair,
                'region' => 'ap-northeast-1'
            ));

            $videoFileName = $value;
            $expires = time() + (60 * 30); //expires in 30 min
            $url = $cloudFront->getSignedUrl(array(
                'url'     => 'http://' . Config::get('wazaar.AWS_WEB_DOMAIN') . '/' . $videoFileName,
                'expires' => $expires
            ));
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