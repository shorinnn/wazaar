<?php

class DashboardController extends BaseController
{
    protected $analyticsHelper;

    public function __construct()
    {
        $this->analyticsHelper = new AnalyticsHelper((Auth::user()->username== 'superadmin' ? true : false), Auth::id());
    }

    public function index()
    {
        //TODO: I'm not sure yet on how to identify if the current logged in user is a student, affiliate or admin, let's test username for now

        if ( in_array(Auth::user()->username,['WazaarAffiliate', 'affiliate'])){
            return $this->_affiliateDashboard();
        }
        elseif(Auth::user()->username == 'superadmin'){
            return $this->_adminDashboard();
        }

        return $this->_studentDashboard();
    }

    public function topCoursesView($frequency = '')
    {
        $topCourses = $this->analyticsHelper->topCourses($frequency);
        if (is_array($topCourses)) {
            return View::make('analytics.partials.topCourses', compact('topCourses'))->render();
        }
    }

    public function salesView($frequency = '')
    {
        $sales = $this->analyticsHelper->sales($frequency);
        if (is_array($sales)) {
            return View::make('analytics.partials.sales', compact('sales', 'frequency'))->render();
        }
    }

    public function trackingCodesSalesView($frequency = '')
    {
        $trackingCodes = $this->analyticsHelper->trackingCodes($frequency);
        if (is_array($trackingCodes)) {
            return View::make('analytics.partials.trackingCodes', compact('trackingCodes', 'frequency'))->render();
        }
    }

    public function courseConversionView($frequency = '')
    {
        $courseConversions = $this->analyticsHelper->courseConversion($frequency);
        if (is_array($courseConversions)) {
            return View::make('analytics.partials.courseConversions', compact('courseConversions', 'frequency'))->render();
        }
    }

    public function trackingCodeConversionView($frequency = '')
    {
        $trackingCodeConversions = $this->analyticsHelper->trackingCodeConversion($frequency);
        if (is_array($trackingCodeConversions)) {
            return View::make('analytics.partials.trackingCodeConversions', compact('trackingCodeConversions', 'frequency'))->render();
        }
    }
    private function _affiliateDashboard()
    {
        $topCoursesView = $this->topCoursesView();
        $salesView = $this->salesView();
        $trackingCodesSalesView = $this->trackingCodesSalesView();
        $courseConversionView = $this->courseConversionView();
        $trackingCodeConversionView = $this->trackingCodeConversionView();
        return View::make('affiliate.dashboard.index', compact('topCoursesView', 'salesView', 'trackingCodesSalesView', 'courseConversionView', 'trackingCodeConversionView'));
    }

    private function _adminDashboard()
    {
        return View::make('administration.dashboard.index');
    }

    private function _studentDashboard()
    {
        return View::make('student.dashboard.index');
    }
}