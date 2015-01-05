<?php

class VideoHelper
{

    /**
     * Puts the video into the input bucket for processing
     * @param $videoFullpath
     * @return bool
     */
    public function prepareForTranscoding($videoFullpath)
    {
        if (!file_exists($videoFullpath)){
            return false;
        }

        $uploadHelper = new UploadHelper;
        // Move Video to input bucket for processing later on
        $inputBucket = getenv('AWS_VIDEO_INPUT_BUCKET');
        $request = $uploadHelper->moveToAWS($videoFullpath,'', $inputBucket);

        return $request;
    }

    /**
     * Create the job to transcode the video
     * @param $inputKey - The source key name/id of the video on the input bucket
     * @param $outputKey - The desired key name of the output video which will be placed in the outputucket
     * @return object - Result of the job
     */
    public function doTranscoding($inputKey, $outputKey)
    {
        $client = AWS::get('ElasticTranscoder');
        //must be in an .env config file
        $pipelineId = getenv('AWS_PIPELINEID');
        $presetId = getenv('AWS_PRESET_320x240');

        $result = $client->createJob([
            'PipelineId' => $pipelineId,
            'Input' => [
                'Key' => $inputKey
            ],
            'Output' => [
                'Key' => $outputKey,
                'PresetId' => $presetId
            ],
        ]);

        return $result;
    }

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





}