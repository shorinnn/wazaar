<?php

class AdminDashboardController extends BaseController
{

    protected $adminHelper;
    protected $analyticsHelper;

    public function __construct(AdminHelper $adminHelper)
    {
        $this->beforeFilter('admin');
        $this->adminHelper = $adminHelper;
        $this->analyticsHelper = new AnalyticsHelper(true);
    }

    public function index()
    {
        $userCountView = $this->userCountView();
        $salesTotalView =  Route::dispatch(Request::create('dashboard/sales/daily', 'GET'))->getContent();
        $salesCountView = $this->salesCountView();
        return View::make('administration.dashboard.index', compact('userCountView', 'salesTotalView', 'salesCountView'));
    }

    public function userCountView($frequency = 'today')
    {
        $userStats = $this->adminHelper->userStats($frequency);
        return View::make('administration.dashboard.partials.user.count', compact('frequency', 'userStats'))->render();
    }


    public function salesCountView($frequency = 'today')
    {
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



}