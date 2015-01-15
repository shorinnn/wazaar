<?php

class VideosController extends BaseController
{
    protected $uploadHelper;
    protected $videoHelper;

    public function __construct(UploadHelper $uploadHelper, VideoHelper $videoHelper)
    {
        $this->beforeFilter('auth');
        $this->uploadHelper = $uploadHelper;
        $this->videoHelper = $videoHelper;
    }

    public function add()
    {
        return View::make('videos.add');
    }

    public function doUpload()
    {
        //upload media and get the full path to it
        $videoPath = $this->uploadHelper->uploadMedia('fileupload');

        if ($videoPath){
            //Save video record first
            $video = Video::create([
                'original_filename' => Input::file('fileupload')->getClientOriginalName(),
                'created_by_id' => Auth::id()
            ]);

            if ($video){
                $videoId = $video->id;
                $this->videoHelper->createTranscodingJob($videoId, $videoPath);
                return Response::json(compact('videoId'));
            }
        }
        else{
            //TODO: uploading of video went wrong
        }
    }

    public function videoAndFormatsJson($videoId)
    {
        $video = Video::getByIdAndPreset($videoId);
        if ($video){
            return $video->toJson();
        }
    }

    /**
     * Videos uploaded previously by a user(instructor)
     */
    public function userArchive()
    {
        $videoOwnerId = Auth::id();
        $videos = Video::getByOwnerIdAndPreset($videoOwnerId);

        return View::make('videos.partials.videoThumbs',compact('videos'));
    }

    /**
     * This is what AWS will call to tell us that a video has completed the transcode process
     */
    public function snsCallback()
    {
        $postBody = file_get_contents('php://input');
        $postObject = json_decode($postBody, true);
        if (!isset($postObject['Message'])){
            return;
        }
        $messageBody = json_decode($postObject['Message'], true);
        if (!isset($messageBody['state'])){
            return;
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