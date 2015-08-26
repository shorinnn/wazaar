<?php

class VideosController extends BaseController
{
    protected $uploadHelper;
    protected $videoHelper;

    public function __construct(UploadHelper $uploadHelper, VideoHelper $videoHelper)
    {
        $this->beforeFilter('auth.basic');
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
                return Response::json(compact('videoId','videoPath'));
            }
        }
        else{
            //TODO: uploading of video went wrong
        }
    }

    public function addVideoByFilename()
    {
        if (Input::has('videoFilename')){
            $filename = Input::get('videoFilename');
            $uniqueKey = Input::get('uniqueKey');
            $video = Video::create([
                'original_filename' => $filename,
                'input_key' => $uniqueKey,
                'created_by_id' => Auth::id()
            ]);

            if ($video) {
                $videoId = $video->id;
                $this->videoHelper->createTranscodingJobFromKey($videoId,$uniqueKey);
                return Response::json(compact('videoId'));
            }
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
        $filter = Input::has('filter') ? Input::get('filter') : '';
        $videoOwnerId = Auth::id();
        $videos = Video::getByOwnerIdAndPreset($videoOwnerId,null,$filter);

        return View::make('videos.partials.videoThumbs',compact('videos'));
    }

    public function delete($id)
    {
        if ($id){
            $ownerId = Auth::id();
            $video = Video::where('id',$id)->where('created_by_id', $ownerId)->first();
            if ($video){
                $video->delete();
            }
        }
    }
}