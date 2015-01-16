<?php

class VideoFormat extends \LaravelBook\Ardent\Ardent
{
    protected $table = 'video_formats';
    protected $guarded = ['id'];

    public function getDurationAttribute($value)
    {
        return gmdate("i:s", $value);
    }

}