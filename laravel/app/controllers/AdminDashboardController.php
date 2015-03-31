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
        ## Possible filters for Top Affiliates
        $affiliateId = 0;
        $taStartDate = '';
        $taEndDate = '';
        if (Input::has('affiliateId') AND Input::has('taStartDate')){
            $affiliateId = Input::get('affiliateId');
            $taStartDate = Input::get('taStartDate');
            $taEndDate = Input::get('taEndDate');
        }

        Paginator::setPageName('page_aff');
        $topAffiliates = $this->adminHelper->topAffiliates($affiliateId,$taStartDate, $taEndDate);

        ## Possible filters for Top Courses Free
        $tcyStartDate = '';
        $tcyEndDate = '';
        $tcyCategoryId = Input::get('tcyCategoryId');

        if (Input::has('tcyStartDate') AND Input::has('tcyEndDate')){
            $tcyStartDate = Input::get('tcyStartDate');
            $tcyEndDate = Input::get('tcyEndDate');
        }


        Paginator::setPageName('page_yes');
        $topCoursesFree = $this->adminHelper->topCourses('yes',$tcyCategoryId,$tcyStartDate,$tcyEndDate);

        ## Possible filters for Top Courses Paid
        $tcnStartDate = '';
        $tcnEndDate = '';
        $tcnCategoryId = Input::get('tcnCategoryId');

        if (Input::has('tcnStartDate') AND Input::has('tcnEndDate')){
            $tcnStartDate = Input::get('tcnStartDate');
            $tcnEndDate = Input::get('tcnEndDate');
        }

        Paginator::setPageName('page_no');
        $topCoursesPaid = $this->adminHelper->topCourses('no',$tcnCategoryId,$tcnStartDate,$tcnEndDate);



        $topCoursesFreeView = $this->_topCoursesView('yes', $topCoursesFree, $tcyCategoryId, $tcyStartDate, $tcyEndDate);

        $topCoursesPaidView = $this->_topCoursesView('no',$topCoursesPaid, $tcnCategoryId, $tcnStartDate, $tcnEndDate);

        $userCountView = $this->userCountView();
        $salesTotalView =  Route::dispatch(Request::create('dashboard/sales/daily', 'GET'))->getContent();
        $salesCountView = $this->salesCountView();

        return View::make('administration.dashboard.index', compact('userCountView', 'salesTotalView', 'salesCountView', 'topAffiliates', 'affiliateId', 'taStartDate', 'taEndDate','topCoursesFreeView', 'topCoursesPaidView'));
    }

    private function _topCoursesView($freeCourse = 'no', $courses, $categoryId, $startDate, $endDate)
    {
        if ($freeCourse == 'no'){
            $objNames = ['categoryId' => 'tcnCategoryId', 'startDate' => 'tcnStartDate', 'endDate' => 'tcnEndDate'];
        }
        else{
            $objNames = ['categoryId' => 'tcyCategoryId', 'startDate' => 'tcyStartDate', 'endDate' => 'tcyEndDate'];
        }

        $appendThis = [$objNames['categoryId'] => $categoryId,$objNames['startDate'] => $startDate, $objNames['endDate'] => $endDate];

        $data = compact('freeCourse', 'courses', 'categoryId', 'startDate', 'endDate', 'objNames','appendThis');

        return View::make('administration.dashboard.partials.courses.count', $data)->render();
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