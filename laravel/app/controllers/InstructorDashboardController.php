<?php 
class InstructorDashboardController extends BaseController {

    protected $analyticsHelper;

    public function __construct()
    {
        $this->analyticsHelper = new AnalyticsHelper(false,Auth::id(),'instructor');
    }
    public function index()
    {
        $sales = $this->_getSales();
        $salesView = $this->salesView($sales);
        $salesCountView = $this->salesCountView($sales);
        $trackingCodesView = $this->trackingCodesView();
        return View::make('instructors.dashboard.index',compact('salesView','salesCountView','trackingCodesView'));
    }

    public function salesCountView($sales = '', $frequency = '', $courseId = '', $trackingCode = '')
    {
        if (empty($sales)){
            $sales = $this->_getSales($frequency, $courseId = '', $trackingCode = '');
        }

        if (is_array($sales)) {
            if ($frequency == 'week'){
                return View::make('analytics.partials.salesWeeklyCount', compact('sales', 'frequency'))->render();
            }
            elseif($frequency == 'month'){
                return View::make('analytics.partials.salesMonthlyCount', compact('sales', 'frequency'))->render();
            }
            elseif($frequency == 'alltime'){
                return View::make('analytics.partials.salesYearlyCount', compact('sales', 'frequency'))->render();
            }
            else {
                return View::make('analytics.partials.salesCount', compact('sales', 'frequency'))->render();
            }
        }
    }

    public function salesView($sales = '', $frequency = '', $courseId = '', $trackingCode = '')
    {
        if (empty($sales)){
            $sales = $this->_getSales($frequency, $courseId = '', $trackingCode = '');
        }


        $frequencyOverride = $frequency;
        switch($frequency){
            case 'alltime' :
                $frequencyOverride = 'year';
                $sales = $this->analyticsHelper->salesLastFewYears(7);break;
            case 'week' :
                $sales = $this->analyticsHelper->salesLastFewWeeks(7);break;
            case 'month' :
                $sales = $this->analyticsHelper->salesLastFewMonths(7);break;
            default:
                $frequencyOverride = 'day';
                $sales = $this->analyticsHelper->salesLastFewDays(7);break;
        }

        return View::make('administration.dashboard.partials.sales.count', compact('frequencyOverride', 'sales'))->render();
    }

    public function trackingCodesView($frequency = '', $courseId = '')
    {
        $trackingCodes = $this->analyticsHelper->trackingCodes($frequency,$courseId);
        if (is_array($trackingCodes)) {
            return View::make('analytics.partials.trackingCodes', compact('trackingCodes', 'frequency'))->render();
        }
    }
    private function _getSales($frequency = '', $courseId = '', $trackingCode = '')
    {
        switch($frequency){
            case 'alltime' :
                $sales = $this->analyticsHelper->salesLastFewYears(5, $courseId,$trackingCode);break;
            case 'week' :
                $sales = $this->analyticsHelper->salesLastFewWeeks(7,$courseId,$trackingCode);break;
            case 'month' :
                $sales = $this->analyticsHelper->salesLastFewMonths(7,$courseId,$trackingCode);break;
            default:
                $sales = $this->analyticsHelper->salesLastFewDays(7, $courseId,$trackingCode);break;
        }

        return $sales;
    }
}