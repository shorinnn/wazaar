<?php 
class AdminAnalyticsController extends BaseController {

    protected $analyticsHelper;

    public function __construct()
    {
        $this->analyticsHelper = new AnalyticsHelper(true);
    }

    public function getIndex()
    {
        return View::make('administration.analytics.index');
    }
}