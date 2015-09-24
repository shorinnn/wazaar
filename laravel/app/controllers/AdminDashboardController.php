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
        
        $app = app();
        //$controller = $app->make('AffiliateDashboardController');

        $userCountView = $this->userCountView();
        $salesTotalView =  '';//$controller->callAction('salesView', $parameters = array());
        $salesCountView = $this->salesCountView();

        $topAffiliatesTable = $this->topAffiliatesTableView(0,'','',false);
        $topCoursesFreeView = $this->_topCoursesView('yes',false);
        $topCoursesPaidView = $this->_topCoursesView('no',false);

        return View::make('administration.dashboard.index', compact('userCountView', 'salesTotalView', 'salesCountView', 'topAffiliatesTable', 'topCoursesFreeView', 'topCoursesPaidView'));
    }


    public function topAffiliatesTableView($affiliateId = 0,$taStartDate = '', $taEndDate = '', $returnAsJson = true)
    {
        $sortOrder = 0;
        $pageNumber = Input::has('page') ? Input::get('page') : 1;

        if (Input::has('taStartDate') OR Input::has('affiliateId')){
            $affiliateId = Input::get('affiliateId');
            $taStartDate = Input::get('taStartDate');
            $taEndDate = Input::get('taEndDate');
            $sortOrder = Input::get('sortOrder');
        }

        $topAffiliates = $this->adminHelper->topAffiliates($affiliateId,$taStartDate, $taEndDate,$sortOrder);
        $topAffiliates->setBaseUrl('dashboard/admin/affiliatestable');

        $view = View::make('administration.dashboard.partials.user.tableWithPagination',compact('topAffiliates', 'affiliateId', 'taStartDate', 'taEndDate', 'pageNumber'))->render();


        if ($returnAsJson){
            return Response::json(['html' => $view]);
        }
        else {
            return $view;
        }
    }

    public function topCoursesTableView($freeCourse = 'no', $categoryId = 0, $startDate = '', $endDate = '', $returnAsJson = true)
    {
        $pageNumber = Input::has('page') ? Input::get('page') : 1;
        $sortOrder = 0;
        if (Input::has('categoryId') OR Input::has('startDate') OR Input::has('endDate')){
            $categoryId = Input::get('categoryId');
            $startDate = Input::get('startDate');
            $endDate = Input::get('endDate');
            $sortOrder = Input::get('sortOrder');
        }

        $courses = $this->adminHelper->topCourses($freeCourse,$categoryId,$startDate,$endDate,true, $sortOrder);
        $courses->setBaseUrl('dashboard/admin/courses/' . $freeCourse);

        $view = View::make('administration.dashboard.partials.courses.tableWithPagination',compact('courses', 'freeCourse', 'pageNumber'))->render();

        if ($returnAsJson){
            return Response::json(['html' => $view]);
        }
        else {
            return $view;
        }
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

    private function _topCoursesView($freeCourse = 'no', $returnAsJson = true)
    {
        $topCoursesTableView = $this->topCoursesTableView($freeCourse,0,'','',$returnAsJson);
        $data = compact('freeCourse', 'topCoursesTableView');
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
    
    public function purchases(){
        
        if(Input::has('filter') && Input::get('filter')!='all'){
            $filter = Input::get('filter')=='free' ? 'yes' : 'no';
            $purchases = Purchase::where('free_product', $filter)->orderBy('id','desc')->paginate(20);
        }
        else{
            $purchases = Purchase::orderBy('id','desc')->paginate(50);
        }
        return View::make('administration.dashboard.purchases')->with( compact('purchases') );
    }
    
    public function ltcPurchases(){
        $purchases = Purchase::where('ltc_affiliate_id','>',0)->where('purchase_price','>', 0)->paginate(20);
        return View::make('administration.dashboard.ltc-purchases')->with( compact('purchases') );
    }
    
    public function yozawaList(){
        $st = User::where('email','yozawa@exraise-venture.asia')->first();
        $users = Instructor::where('second_tier_instructor_id',$st->id)->with('profile')->get();
        return View::make('administration.dashboard.yazawa')->withUsers($users);
        
    }
    
    public function purchasesCsv(){
       header('Content-Type: text/csv; charset=UTF-8');
       $rows = DB::table('purchases')->get();
       $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
       $csv->insertOne(\Schema::getColumnListing('purchases'));
       foreach ($rows as $row) {
           $row = json_decode( json_encode($row), true);
           $csv->insertOne( $row );
        }
        $csv->output('purchases.csv');
    }
    
    public function transactionsCsv(){
       header('Content-Type: text/csv; charset=UTF-8');
       $rows = DB::table('transactions')->get();
       $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
       $csv->insertOne(\Schema::getColumnListing('transactions'));
       foreach ($rows as $row) {
           $row = json_decode( json_encode($row), true);
           $csv->insertOne( $row );
        }
        $csv->output('transactions.csv');
    }
    
    public function usersCsv(){
        try{
            header('Content-Type: text/csv; charset=UTF-8');
            $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
            $csv->setEncodingFrom('iso-8859-15');
            $csv->insertOne(\Schema::getColumnListing('users'));
            $skip = 0;
            while( $users = DB::table('users')->limit(1000)->skip($skip)->get() ){
                foreach ($users as $user) {
                    $user = json_decode( json_encode($user), true);
                    $csv->insertOne( $user);
                } 
                $skip+= 1000;
            }
            $csv->output('users.csv');
        }
        catch(Exception $e){
            echo $e->getMessage();
            $users = DB::table('users')->get();
            $header = \Schema::getColumnListing('users');
            echo implode(',', $header)."\n";
            foreach ($users as $user) {
                $user = json_decode( json_encode($user), true);
                echo implode(',', $user)."\n";
             }
        }
    }
}