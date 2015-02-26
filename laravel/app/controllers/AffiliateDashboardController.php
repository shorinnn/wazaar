<?php

class AffiliateDashboardController extends BaseController
{
    protected $analyticsHelper;

    public function __construct()
    {
        $this->beforeFilter('affiliate');
        $this->analyticsHelper = new AnalyticsHelper(false, Auth::id());
    }

    public function index()
    {
        return $this->_affiliateDashboard();
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
        switch($frequency){
            case 'alltime' :
                $sales = $this->analyticsHelper->salesLastFewYears(5, $courseId);break;
            case 'week' :
                $sales = $this->analyticsHelper->salesLastFewWeeks(7,$courseId);break;
            case 'month' :
                $sales = $this->analyticsHelper->salesLastFewMonths(7,$courseId);break;
            default:
                $sales = $this->analyticsHelper->sales($frequency, $courseId);break;
        }



        if (is_array($sales)) {
            if ($frequency == 'week'){
                return View::make('analytics.partials.salesWeekly', compact('sales', 'frequency'))->render();
            }
            elseif($frequency == 'month'){
                return View::make('analytics.partials.salesMonthly', compact('sales', 'frequency'))->render();
            }
            elseif($frequency == 'alltime'){
                return View::make('analytics.partials.salesYearly', compact('sales', 'frequency'))->render();
            }
            else {
                return View::make('analytics.partials.sales', compact('sales', 'frequency'))->render();
            }
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

    public function trackingCodeHitsSalesView($courseId = '', $trackingCode = '', $frequency = '')
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
            $courses = ProductAffiliate::courses(Auth::id());
            return View::make('analytics.courseStatistics', compact('course','trackingCodesSalesView', 'salesView','trackingCodeConversionView','salesLabelData', 'courses'));
        }
    }

    public function compareCourses()
    {

    }

    public function courseTrackingCodesStatistics($courseId, $trackingCode)
    {
        $course = Course::find($courseId);

        if ($course){
            $hitsSalesView = $this->trackingCodeHitsSalesView($courseId, $trackingCode);
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