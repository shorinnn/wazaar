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
        $secondTierSalesView = $this->secondTierSalesView();
        $courses        = Course::where('instructor_id', Auth::id())->get();


        if (Input::has('t')){
            return View::make('TEMPORARYVIEWS.new_analytics', compact('salesView', 'salesCountView', 'secondTierSalesView', 'courses'));
        }
        else{
            return View::make('instructors.dashboard.index', compact('salesView', 'salesCountView', 'secondTierSalesView', 'courses'));
        }

    }

    public function course($courseSlug = '')
    {
        $course = Course::where('instructor_id', Auth::id())->where('slug', $courseSlug)->first();

        if ($course) {
            $salesView          = $this->salesView('', $course->id);
            $salesCountView     = $this->salesCountView('',  $course->id);
            //$trackingCodesView  = $this->trackingCodesView('', $course->id);
            //$topAffiliatesTable = $this->topAffiliatesTableView($course->id);
            //$courseStatsTableView     = $this->courseStatsTableView($course->id);
            return View::make('instructors.dashboard.course',compact('course', 'salesView', 'salesCountView'));
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
            $urlIdentifier = 'sales';
            $group = 'instructor';
            if ($frequency == 'week') {
                return View::make('analytics.partials.salesWeekly', compact('sales', 'frequency','group','urlIdentifier'))->render();
            } elseif ($frequency == 'month') {
                return View::make('analytics.partials.salesMonthly', compact('sales', 'frequency','group','urlIdentifier'))->render();
            } elseif ($frequency == 'alltime') {
                return View::make('analytics.partials.salesYearly', compact('sales', 'frequency','group','urlIdentifier'))->render();
            } else {
                $frequency = 'daily';
                return View::make('analytics.partials.sales', compact('sales', 'frequency','group','urlIdentifier'))->render();
            }
        }
    }

    public function secondTierSalesView($frequency = '', $courseId = '', $trackingCode = '')
    {
        if (Auth::user()->is_second_tier_instructor == 'no'){
            return '';
        }


        $sales = null;
        switch ($frequency) {
            case 'alltime' :
                $sales = $this->analyticsHelper->secondTierSalesLastFewYears(5, $courseId, $trackingCode);
                break;
            case 'week' :
                $sales = $this->analyticsHelper->secondTierSalesLastFewWeeks(7, $courseId, $trackingCode);
                break;
            case 'month' :
                $sales = $this->analyticsHelper->secondTierSalesLastFewMonths(7, $courseId, $trackingCode);
                break;
            default:
                $sales = $this->analyticsHelper->secondTierSalesLastFewDays(7, $courseId, $trackingCode);
                break;
        }


        if (is_array($sales)) {
            $urlIdentifier = 'second-tier-sales';
            $group = 'instructor';
            if ($frequency == 'week') {
                return View::make('analytics.partials.salesWeekly', compact('sales', 'frequency','urlIdentifier','group'))->render();
            } elseif ($frequency == 'month') {
                return View::make('analytics.partials.salesMonthly', compact('sales', 'frequency','urlIdentifier','group'))->render();
            } elseif ($frequency == 'alltime') {
                return View::make('analytics.partials.salesYearly', compact('sales', 'frequency','urlIdentifier','group'))->render();
            } else {
                $frequency = 'daily';
                return View::make('analytics.partials.sales', compact('sales', 'frequency','urlIdentifier','group'))->render();
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

    /*public function topAffiliatesTableView($taStartDate = '', $taEndDate = '', $returnAsJson = true)
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
    }*/

    public function detailedSecondTierSales($frequency)
    {
        $purchases = null;

        switch($frequency){
            case 'daily' :
                if (!Input::has('date')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F d, Y',strtotime(Input::get('date')));
                $purchases = Purchase::whereRaw("DATE(created_at) = '". Input::get('date') ."'")->where('second_tier_instructor_id',Auth::id())->paginate(10);
                break;
            case 'week' :
                if (!Input::has('start') && !Input::has('end')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F d, Y',strtotime(Input::get('start'))) . ' - '  . date('F d, Y',strtotime(Input::get('end')));
                $purchases = Purchase::whereRaw("DATE(created_at) BETWEEN '". Input::get('start') ."' AND '". Input::get('end') ."'")->where('second_tier_instructor_id',Auth::id())->paginate(10);
                break;
            case 'month':
                if (!Input::has('month') && !Input::has('year')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F',strtotime(Input::get('month'))) . Input::get('year');
                $purchases = Purchase::whereRaw("MONTH(created_at) =  '". Input::get('month') ."' AND YEAR(created_at) = '". Input::get('year') ."'")->where('second_tier_instructor_id',Auth::id())->paginate(10);
                break;
            case 'alltime':
                if (!Input::has('year')){
                    return Redirect::to('analytics');
                }
                $salesLabel = Input::get('year');
                $purchases = Purchase::whereRaw("YEAR(created_at) = '". Input::get('year') ."'")->where('second_tier_instructor_id',Auth::id())->paginate(10);
                break;
        }

        if ($purchases){
            return View::make('instructors.dashboard.secondTierSalesList',compact('purchases','salesLabel'));
        }

        return Redirect::to('analytics');
    }

    public function detailedSales($frequency)
    {
        $purchases = null;

        switch($frequency){
            case 'daily' :
                if (!Input::has('date')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F d, Y',strtotime(Input::get('date')));
                $purchases = Purchase::whereRaw("DATE(created_at) = '". Input::get('date') ."'")->where('instructor_id',Auth::id())->paginate(10);
                break;
            case 'week' :
                if (!Input::has('start') && !Input::has('end')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F d, Y',strtotime(Input::get('start'))) . ' - '  . date('F d, Y',strtotime(Input::get('end')));
                $purchases = Purchase::whereRaw("DATE(created_at) BETWEEN '". Input::get('start') ."' AND '". Input::get('end') ."'")->where('instructor_id',Auth::id())->paginate(10);
                break;
            case 'month':
                if (!Input::has('month') && !Input::has('year')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F',strtotime(Input::get('month'))) . Input::get('year');
                $purchases = Purchase::whereRaw("MONTH(created_at) =  '". Input::get('month') ."' AND YEAR(created_at) = '". Input::get('year') ."'")->where('instructor_id',Auth::id())->paginate(10);
                break;
            case 'alltime':
                if (!Input::has('year')){
                    return Redirect::to('analytics');
                }
                $salesLabel = Input::get('year');
                $purchases = Purchase::whereRaw("YEAR(created_at) = '". Input::get('year') ."'")->where('instructor_id',Auth::id())->paginate(10);
                break;
        }

        if ($purchases){
            return View::make('instructors.dashboard.salesList',compact('purchases','salesLabel'));
        }

        return Redirect::to('analytics');
    }

    public function courseStatsTableView($courseId, $startDate, $endDate)
    {
        $stats = $this->analyticsHelper->getCourseStats($courseId,$startDate,$endDate);

        return View::make('instructors.analytics.tableCourseStats',compact('stats'))->render();
    }

    public function topAffiliatesTableView($courseId, $startDate, $endDate)
    {
        $page = 1;
        if (Input::has('page')){
            $page = Input::get('page');
        }
        $addThisToRank = ($page - 1) * Config::get('wazaar.PAGINATION');
        $affiliates = $this->analyticsHelper->getTopAffiliatesByCourse($courseId, $startDate, $endDate);

        return View::make('instructors.analytics.tableTopAffiliates',compact('affiliates','addThisToRank'))->render();
    }
}