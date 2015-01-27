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
            return $this->affiliateDashboard();
        }
        elseif(Auth::user()->username == 'superadmin'){
            return $this->adminDashboard();
        }

        return $this->studentDashboard();
    }

    private function affiliateDashboard()
    {
        $topCoursesToday = $this->analyticsHelper->dailyTopCourses();
        $weeklySales = $this->analyticsHelper->weeklySales();
        return View::make('affiliate.dashboard.index', compact('topCoursesToday', 'weeklySales'));
    }

    private function adminDashboard()
    {
        return View::make('administration.dashboard.index');
    }

    private function studentDashboard()
    {
        return View::make('student.dashboard.index');
    }
}