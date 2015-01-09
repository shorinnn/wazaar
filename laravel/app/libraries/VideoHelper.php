<?php

class VideoHelper
{

    /**
     * @param $jobId - The job transcoding Job Id
     * @return object
     */

    public function getTranscodingJob($jobId)
    {
        $client = AWS::get('ElasticTranscoder');

        return $client->readJob([
            'Id' => $jobId
        ]);
    }

    /**
     * Creates a Queue job for transcoding uploaded videos
     * @param $videoId
     * @param $videoPath
     */
    public function createTranscodingJob($videoId, $videoPath)
    {
        //Create a queue
        Queue::push(function ($job) use ($videoId, $videoPath) {
            //move the video to s3 input bucket
            $videoHelper = new VideoHelper;
            $response    = $videoHelper->prepareForTranscoding($videoPath);
            //we'll proceed if the url to input video was successfully created

            if (isset($response['ObjectURL'])) {
                $inputKey = $videoHelper->getKeyFromUrl($response['ObjectURL']);
                $presets  = Config::get('wazaar.AWS_VIDEO_PRESETS');

                if (is_array($presets)) {
                    $presetIds    = array_keys($presets);
                    $transcodeJob = $videoHelper->doTranscoding($inputKey, $presetIds);

                    if (isset($transcodeJob['Job']['Id'])) {
                        $jobId = $transcodeJob['Job']['Id'];

                        $video                   = Video::find($videoId);
                        $video->transcode_job_id = $jobId;
                        $video->transcode_status = $transcodeJob['Job']['Status'];
                        $video->save(); //update video record
                        if ($transcodeJob['Job']['Status'] == Video::STATUS_COMPLETE) {
                            $videoFormats = $videoHelper->extractVideoFormatsFromOutputs($videoId,
                                $transcodeJob['Outputs']);
                            VideoFormat::insert($videoFormats);
                        }
                    }
                }
            }
        });
    }

    public function extractVideoFormatsFromOutputs($videoId, $outputs)
    {
        $outputLink   = 'https://s3-ap-southeast-1.amazonaws.com/videosoutput/';
        $videoFormats = [];
        foreach ($outputs as $output) {
            $resolution     = $output['Width'] . 'x' . $output['Height'];
            $videoFormats[] = [
                'video_id'   => $videoId,
                'output_key' => $output['Key'],
                'resolution' => $resolution,
                'duration'   => $output['Duration'],
                'video_url'  => $outputLink . $output['Key']
            ];
        }

        return $videoFormats;
    }

    /**
     * @param $url
     * @return mixed|null
     */
    public function getKeyFromUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return null;
        }
        $segments = explode('/', $url);
        return end($segments);
    }

    /**
     * Puts the video into the input bucket for processing
     * @param $videoFullpath
     * @return bool
     */
    public function prepareForTranscoding($videoFullpath)
    {
        if (!file_exists($videoFullpath)) {
            return false;
        }

        $uploadHelper = new UploadHelper;
        // Move Video to input bucket for processing later on
        $inputBucket = getenv('AWS_VIDEO_INPUT_BUCKET');
        $request     = $uploadHelper->moveToAWS($videoFullpath, '', $inputBucket);

        return $request;
    }

    /**
     * Create the job to transcode the video
     * @param $inputKey - The source key name/id of the video on the input bucket
     * @param $outputKey - The desired key name of the output video which will be placed in the outputucket
     * @return object - Result of the job
     */
    public function doTranscoding($inputKey, $presetIds = [])
    {
        $client = AWS::get('ElasticTranscoder');
        //must be in an .env config file
        $pipelineId = getenv('AWS_PIPELINEID');

        $outputs = [];
        foreach ($presetIds as $presetId) {
            $key       = $inputKey . str_replace('-', '', $presetId);
            $outputs[] = ['Key' => $key . '.mp4', 'PresetId' => $presetId, 'ThumbnailPattern' => $key . '-{count}'];
        }

        $result = $client->createJob([
            'PipelineId' => $pipelineId,
            'Input'      => [
                'Key' => $inputKey
            ],
            'Outputs'    => $outputs,
        ]);
        return $result;
    }
}