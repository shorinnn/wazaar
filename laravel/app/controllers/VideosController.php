<?php

class VideosController extends BaseController
{
    protected $uploadHelper;
    protected $videoHelper;

    public function __construct(UploadHelper $uploadHelper, VideoHelper $videoHelper)
    {
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
            }
        }
        else{
            //TODO: uploading of video went wrong
        }
    }

    public function snsCallback()
    {
        echo 'This will be the callback endpoint for transcoded videos';
        File::put(storage_path() . '/snstest.txt', 'albert' . print_r(Input::all(), true));
    }
}