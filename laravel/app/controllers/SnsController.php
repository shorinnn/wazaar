<?php 
class SnsController extends BaseController {


    protected $videoHelper;

    public function __construct(VideoHelper $videoHelper)
    {
        $this->videoHelper = $videoHelper;
    }

    /**
     * This is what AWS will call to tell us that a video has completed the transcode process
     */
    public function snsCallback()
    {
        $postBody = file_get_contents('php://input');
        $postObject = json_decode($postBody, true);

        //Log::alert('triggered ' . $postBody);

        if (!isset($postObject['Message'])){
            return false;
        }
        $messageBody = json_decode($postObject['Message'], true);
        if (!isset($messageBody['state'])){
            return false;
        }

        if ($messageBody['state'] == 'COMPLETED' AND isset($messageBody['outputs'])){
            $jobId = @$messageBody['jobId'];
            $video = Video::where('transcode_job_id', $jobId)->first();
            if ($video){
                $videoFormats = $this->videoHelper->extractVideoFormatsFromOutputs($video->id,$messageBody['outputs']);
                VideoFormat::insert($videoFormats);
                $video->transcode_status = Video::STATUS_COMPLETE;
                $video->save();
            }
        }
    }
}