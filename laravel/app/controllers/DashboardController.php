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

    public function topCoursesView($frequency = '', $courseId = '')
    {
        $topCourses = $this->analyticsHelper->topCourses($frequency, $courseId);
        if (is_array($topCourses)) {
            return View::make('analytics.partials.topCourses', compact('topCourses'))->render();
        }
    }

    public function salesView($frequency = '', $courseId = '')
    {
        $sales = $this->analyticsHelper->sales($frequency, $courseId);

        if (is_array($sales)) {
            return View::make('analytics.partials.sales', compact('sales', 'frequency'))->render();
        }
    }

    public function trackingCodesSalesView($frequency = '', $courseId = '')
    {
        $trackingCodes = $this->analyticsHelper->trackingCodes($frequency,$courseId);
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

    public function trackingCodeConversionView($frequency = '', $courseId = '')
    {
        $trackingCodeConversions = $this->analyticsHelper->trackingCodeConversion($frequency, $courseId);
        if (is_array($trackingCodeConversions)) {
            return View::make('analytics.partials.trackingCodeConversions', compact('trackingCodeConversions', 'frequency'))->render();
        }
    }

    public function trackingCodeHitsSalesView($frequency = '', $courseId = '', $trackingCode = '')
    {
        $trackingHitsSales = $this->analyticsHelper->trackingCodeHitsSales($frequency, $courseId,$trackingCode)[0];
        return View::make('analytics.partials.trackingCodeHitsSales', compact('trackingHitsSales', 'frequency'))->render();

    }

    public function courseStatistics($courseId)
    {
        //TODO: Add filter here to make sure certain group has access to this e.g. Should only allow affiliates group
        $course = Course::find($courseId);

        if ($course) {
            $sales = $this->analyticsHelper->sales('week',$courseId);
            $salesLabelData = $this->analyticsHelper->jsonCoursePurchases($sales);

            $trackingCodesSalesView = $this->trackingCodesSalesView('', $courseId);
            $salesView = $this->salesView('', $courseId);
            $trackingCodeConversionView = $this->trackingCodeConversionView('', $courseId);
            return View::make('analytics.courseStatistics', compact('course','trackingCodesSalesView', 'salesView','trackingCodeConversionView','salesLabelData'));
        }
    }

    public function courseTrackingCodesStatistics($courseId, $trackingCode)
    {
        $course = Course::find($courseId);

        if ($course){
            $hitsSalesView = $this->trackingCodeHitsSalesView('',$courseId, $trackingCode);
            return View::make('analytics.courseTrackingCodeStatistics',compact('course', 'trackingCode', 'hitsSalesView'));
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