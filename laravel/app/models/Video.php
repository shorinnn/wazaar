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

    public static function getPresetIdByAgent()
    {
        if (Agent::isMobile()){
            return '1351620000001-100020';
        }

        if (Agent::isTablet()){
            return '1351620000001-000040';
        }

        return '1351620000001-100070';
    }

    public static function getByIdAndPreset($id, $presetId = null)
    {
        if (empty($presetId)){
            $presetId = self::getPresetIdByAgent();
        }
        $video = Video::where('id', $id)->whereHas('formats', function ($q) use($presetId) {
            $q->where('preset_id', $presetId);
        })->first();

        return $video;
    }
}