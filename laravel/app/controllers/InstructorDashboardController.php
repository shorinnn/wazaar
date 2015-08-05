<?php 
class InstructorDashboardController extends BaseController {

    protected $analyticsHelper;

    public function __construct()
    {
        $this->analyticsHelper = new AnalyticsHelper(false,Auth::id());
    }
    public function index()
    {
        $salesView = $this->sales();
       return View::make('instructors.dashboard.index',compact('salesView'));
    }

    public function sales($frequency = '', $courseId = '', $trackingCode = '')
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
}