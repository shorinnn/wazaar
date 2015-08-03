<?php 
class LessonHelper {

    public static function getVideo($lesson)
    {
        if (is_numeric($lesson)){
            $lesson = Lesson::find($lesson)->first();
        }

        if ($lesson){
            $videoBlock = $lesson->blocks()->where('type', Block::TYPE_VIDEO)->first();
            return self::getVideoByBlock($videoBlock);
        }

        return null;
    }

    public static function getVideoByBlock($block)
    {
        $videoId = $block->content;

        if (is_null($videoId)){
            $video = Video::find($videoId);

            if ($video){
                return $video;
            }
        }

        return null;
    }
}