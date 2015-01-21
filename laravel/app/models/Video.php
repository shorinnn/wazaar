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
            return '1421660966371-o9l23s';
        }

        if (Agent::isTablet()){
            return '1421661161826-cx6nmz';
        }

        return '1421661161826-cx6nmz';
    }

    public static function getByIdAndPreset($id, $presetId = null)
    {
        if (empty($presetId)){
            $presetId = self::getPresetIdByAgent();
        }
        $video = Video::with('formats')->where('id', $id)->whereHas('formats', function ($q) use($presetId) {
            $q->where('preset_id', $presetId);
        })->first();

        return $video;
    }

    public static function getByOwnerIdAndPreset($userId, $presetId = null)
    {
        if (empty($presetId)){
            $presetId = self::getPresetIdByAgent();
        }
        $video = Video::with('formats')->where('created_by_id', $userId)->whereHas('formats', function ($q) use($presetId) {
            $q->where('preset_id', $presetId);
        });

        return $video;
    }
}