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
        $data['msg'] = file_get_contents('php://input');
        Mail::send('emails.test', $data, function($message)
        {
            $message->to('albertmaranian@gmail.com', 'Albert Maranian')->subject('Cocorium!');
        });
    }
}