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
        $videoPath = $this->uploadHelper->uploadMedia('fileupload');

        if ($videoPath){
            $response = $this->videoHelper->prepareForTranscoding($videoPath);

            if (isset($response['ObjectURL'])){
                $videoKey = $this->videoHelper->getKeyFromUrl($response['ObjectURL']);
                echo $videoKey;
            }
        }
        else{
            //TODO: uploading of video went wrong
        }
    }
}