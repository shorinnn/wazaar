<?php 
class AdminAnalyticsController extends BaseController {

    protected $analyticsHelper;
    protected $adminHelper;

    public function __construct()
    {
        $this->adminHelper = new AdminHelper();
        $this->analyticsHelper = new AnalyticsHelper(true,0,'admin');
    }

    public function getIndex()
    {
        return View::make('administration.analytics.index');
    }

    public function getInstructorStudentSignUps($frequency = 'today')
    {
        $this->adminHelper->rolesFilter = [2,3];
        $userStats = $this->adminHelper->userStats($frequency);
        return View::make('administration.dashboard.partials.user.count', compact('frequency', 'userStats'))->render();
    }

    public function getAffiliateSignUps($frequency = 'today')
    {
        $this->adminHelper->rolesFilter = [4];
        $userStats = $this->adminHelper->userStats($frequency);
        return View::make('administration.dashboard.partials.user.count', compact('frequency', 'userStats'))->render();
    }

    public function getSales($frequency = '', $courseId = '', $trackingCode = '')
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
            $urlIdentifier = '';
            $group = '';
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

    public function getSiteStatisticsTable($startDate, $endDate)
    {
        $start = Input::has('page') ? Input::get('page') : 1;
        $siteStatsAll = $this->adminHelper->getSiteStats($startDate,$endDate,null);
        $siteStats = $this->adminHelper->getSiteStats($startDate,$endDate,$start);
        $paginator = Paginator::make($siteStats,count($siteStatsAll),10);
        return View::make('administration.analytics.ajax.siteStats',compact('siteStats','paginator'));
    }

    public function getSalesStatisticsTable($startDate,$endDate)
    {
        $sales = $this->adminHelper->getSalesStats($startDate,$endDate);
        return View::make('administration.analytics.ajax.salesStats',compact('sales'));
    }

    public function getTopCoursesTable($startDate,$endDate)
    {
        $page = 1;
        if (Input::has('page')){
            $page = Input::get('page');
        }
        $addThisToRank = ($page - 1) * Config::get('wazaar.PAGINATION');
        $courses = $this->adminHelper->topCourses('no',0,$startDate,$endDate);
        return View::make('administration.analytics.ajax.topCourses',compact('courses','addThisToRank'));
    }

    public function getTopAffiliatesTable($startDate,$endDate)
    {
        $page = 1;
        if (Input::has('page')){
            $page = Input::get('page');
        }

        $addThisToRank = ($page - 1) * Config::get('wazaar.PAGINATION');
        $affiliates = $this->adminHelper->topAffiliates(0,$startDate,$endDate);
        return View::make('administration.analytics.ajax.topAffiliates',compact('affiliates','addThisToRank'));
    }




}