<?php

class VideoUploadTest extends TestCase
{
    public function testVideoFileDoesNotExist()
    {
        $videoHelper = new VideoHelper;

        $return = $videoHelper->prepareForTranscoding('/dummy/path/to/video');

        $this->assertFalse($return);
    }

    public function testVideoFileExists()
    {
        $videoHelper = new VideoHelper();

        $videoFullpath = 'h:/sample-mp4.mp4'; //must actually exist

        $return = $videoHelper->prepareForTranscoding($videoFullpath);

        $this->assertNotFalse($return);
    }
}