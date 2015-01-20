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
}