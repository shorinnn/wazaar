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
        /*if (Agent::isMobile()){
            return  '1436779339512-wtkz9d';
        }

        if (Agent::isTablet()){
            return '1421661161826-cx6nmz';
        }*/

        return '1436790010046-k9rw9e';
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

    public static function getByOwnerIdAndPreset($userId, $presetId = null, $filter = '')
    {
        if (empty($presetId)){
            $presetId = self::getPresetIdByAgent();
        }
        $video = Video::with('formats')->where('created_by_id', $userId)->whereHas('formats', function ($q) use($presetId) {
            $q->where('preset_id', $presetId);
        });

        if (!empty($filter)){
            $video = $video->where('original_filename', 'LIKE', "%". $filter ."%");
        }

        //TODO: Set config values for the numbers below
        //$video = $video->remember(10)->paginate(6);// no more pagination!
        $video = $video->remember(10)->get();
        return $video;
    }

    public function getTrimmedOriginalFilenameAttribute()
    {
        $originalFilenameSegments = explode('-',$this->attributes['original_filename']);
        unset($originalFilenameSegments[0]);
        $trimmedSegments = array_values($originalFilenameSegments);

        return implode('-',$trimmedSegments);
    }
}