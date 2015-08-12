<?php

class InstructorDashboardController extends BaseController
{

    protected $analyticsHelper;

    public function __construct()
    {
        $this->analyticsHelper = new AnalyticsHelper(false, Auth::id(), 'instructor');
    }

    public function index()
    {
        $salesView      = $this->salesView();
        $salesCountView = $this->salesCountView();
        $courses        = Course::where('instructor_id', Auth::id())->get();

        return View::make('instructors.dashboard.index', compact('salesView', 'salesCountView', 'courses'));
    }

    public function course($courseSlug = '')
    {
        $course = Course::where('instructor_id', Auth::id())->where('slug', $courseSlug)->first();

        if ($course) {
            $salesView          = $this->salesView('', $course->id);
            $salesCountView     = $this->salesCountView('', '', $course->id);
            $trackingCodesView  = $this->trackingCodesView('', $course->id);
            $topAffiliatesTable = $this->topAffiliatesTableView('', '', false);

            return View::make('instructors.dashboard.course',compact('course', 'salesView', 'salesCountView', 'trackingCodesView', 'topAffiliatesTable'));
        }

        return Redirect::to('analytics');
    }

    public function salesCountView($frequency = '', $courseId = '', $trackingCode = '')
    {
        $frequencyOverride = $frequency;
        $sales = null;
        switch ($frequency) {
            case 'alltime' :
                $frequencyOverride = 'year';
                $sales             = $this->analyticsHelper->salesLastFewYears(7, $courseId);
                break;
            case 'week' :
                $sales = $this->analyticsHelper->salesLastFewWeeks(7, $courseId);
                break;
            case 'month' :
                $sales = $this->analyticsHelper->salesLastFewMonths(7, $courseId);
                break;
            default:
                $frequencyOverride = 'day';
                $sales             = $this->analyticsHelper->salesLastFewDays(7, $courseId);
                break;
        }

        return View::make('administration.dashboard.partials.sales.count',
            compact('frequencyOverride', 'sales'))->render();


    }

    public function salesView($frequency = '', $courseId = '', $trackingCode = '')
    {
        $sales = null;
        switch ($frequency) {
            case 'alltime' :
                $sales = $this->analyticsHelper->salesLastFewYears(5, $courseId, $trackingCode);
                break;
            case 'week' :
                $sales = $this->analyticsHelper->salesLastFewWeeks(7, $courseId, $trackingCode);
                break;
            case 'month' :
                $sales = $this->analyticsHelper->salesLastFewMonths(7, $courseId, $trackingCode);
                break;
            default:
                $sales = $this->analyticsHelper->salesLastFewDays(7, $courseId, $trackingCode);
                break;
        }


        if (is_array($sales)) {
            if ($frequency == 'week') {
                return View::make('analytics.partials.salesWeekly', compact('sales', 'frequency'))->render();
            } elseif ($frequency == 'month') {
                return View::make('analytics.partials.salesMonthly', compact('sales', 'frequency'))->render();
            } elseif ($frequency == 'alltime') {
                return View::make('analytics.partials.salesYearly', compact('sales', 'frequency'))->render();
            } else {
                return View::make('analytics.partials.sales', compact('sales', 'frequency'))->render();
            }
        }
    }

    public function trackingCodesView($frequency = '', $courseId = '')
    {
        $trackingCodes = $this->analyticsHelper->trackingCodes($frequency, $courseId);
        if (is_array($trackingCodes)) {
            return View::make('analytics.partials.trackingCodes', compact('trackingCodes', 'frequency'))->render();
        }
    }

    public function topAffiliatesTableView($taStartDate = '', $taEndDate = '', $returnAsJson = true)
    {
        $sortOrder   = 0;
        $pageNumber  = Input::has('page') ? Input::get('page') : 1;
        $affiliateId = 0;

        if (Input::has('affiliateId')) {
            $affiliateId = Input::get('affiliateId');
        }

        if (Input::has('taStartDate')) {
            $taStartDate = Input::get('taStartDate');
            $taEndDate   = Input::get('taEndDate');
            $sortOrder   = Input::get('sortOrder');
        }

        $adminHelper   = new AdminHelper();
        $topAffiliates = $adminHelper->topAffiliatesByInstructor(Auth::id(), $affiliateId, $taStartDate, $taEndDate,
            $sortOrder);
        $topAffiliates->setBaseUrl('analytics/affiliates-table');

        $view = View::make('instructors.dashboard.topAffiliates',
            compact('topAffiliates', 'taStartDate', 'taEndDate', 'pageNumber'))->render();


        if ($returnAsJson) {
            return Response::json(['html' => $view]);
        } else {
            return $view;
        }
    }
}