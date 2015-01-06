<?php

class CourseVideosController extends BaseController
{
    protected $videoHelper;

    public function __construct(VideoHelper $videoHelper)
    {
        $this->videoHelper = $videoHelper;
    }

    public function add()
    {

    }
}