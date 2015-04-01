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
        $affiliateId = Input::get('affiliateId');
        $taStartDate = '';
        $taEndDate = '';

        if (Input::has('taStartDate') AND Input::has('taEndDate')){

            $taStartDate = Input::get('taStartDate');
            $taEndDate = Input::get('taEndDate');
        }

        Paginator::setPageName('page_aff');
        $topAffiliatesTable = $this->topAffiliatesTableView($affiliateId,$taStartDate, $taEndDate);

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

        return View::make('administration.dashboard.index', compact('userCountView', 'salesTotalView', 'salesCountView', 'topAffiliatesTable', 'affiliateId', 'taStartDate', 'taEndDate','topCoursesFreeView', 'topCoursesPaidView'));
    }


    public function topAffiliatesTableView($affiliateId,$taStartDate, $taEndDate)
    {
        Paginator::setPageName('page_aff');
        $topAffiliates = $this->adminHelper->topAffiliates($affiliateId,$taStartDate, $taEndDate);
        return View::make('administration.dashboard.partials.user.tableWithPagination',compact('topAffiliates', 'affiliateId', 'taStartDate', 'taEndDate'))->render();
    }

    public function topCoursesByCategory($categoryId = 0, $freeCourse = 'no')
    {
        ## Possible filters for Top Courses Free
        $startDate = '';
        $endDate = '';

        if (Input::has('startDate') AND Input::has('endDate')){
            $startDate = Input::get('startDate');
            $endDate = Input::get('endDate');
        }

        $courses = $this->adminHelper->topCourses($freeCourse,$categoryId,$startDate,$endDate);

        return View::make('administration.dashboard.coursesByCategory',compact('categoryId', 'freeCourse', 'courses', 'startDate', 'endDate'));
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