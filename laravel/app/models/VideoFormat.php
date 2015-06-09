<?php

class VideoFormat extends \LaravelBook\Ardent\Ardent
{
    protected $table = 'video_formats';
    protected $guarded = ['id'];

    public function getDurationAttribute($value)
    {
        return gmdate("i:s", $value);
    }

    public function getVideoUrlAttribute($value)
    {
        $outputDomain   = 'http://'. Config::get('wazaar.AWS_WEB_DOMAIN');
        return $outputDomain . '/' . $value;
    }

    public function getThumbnailAttribute($value)
    {
        $outputDomain   = 'http://'. Config::get('wazaar.AWS_WEB_DOMAIN');
        return $outputDomain . '/' . $value;
    }

}