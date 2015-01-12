<?php

class Video extends \LaravelBook\Ardent\Ardent
{
    protected $table = 'videos';
    protected $guarded = ['id'];

    const STATUS_SUBMITTED = 'Submitted';
    const STATUS_PROGRESSING = 'Progressing';
    const STATUS_COMPLETE = 'Complete';
    const STATUS_ERROR = 'Error';
    const STATUS_CANCELED = 'Canceled';

    public function formats()
    {
        return $this->hasMany('VideoFormat', 'video_id');
    }
}