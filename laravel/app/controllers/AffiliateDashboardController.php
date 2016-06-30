<?php

class AffiliateDashboardController extends BaseController
{
    protected $analyticsHelper;

    public function __construct()
    {
        $this->beforeFilter('affiliate|admin');
        $this->analyticsHelper = new AnalyticsHelper(Auth::user()->hasRole('Admin') ? true : false, Auth::id(), Auth::user()->hasRole('Admin') ? '' : 'affiliate');
    }

    public function index()
    {
        $user =  Auth::user();
        $sawLetter = $user->getCustom('saw_aff_welcome_letter');
        if(Input::has('show-letter-again')) $sawLetter = null;
        Auth::user()->sawLetter = $sawLetter;
        return $this->_affiliateDashboard();
    }

    public function topCoursesView($frequency = '', $courseId = '', $free = 'no')
    {
        $topCourses = $this->analyticsHelper->topCourses($frequency, $courseId, $free);
        if (is_array($topCourses)) {
            return View::make('analytics.partials.topCourses', compact('topCourses','frequency'))->render();
        }
    }

    public function topFreeCoursesView($frequency = '', $courseId = '', $free = 'yes')
    {
        $topCourses = $this->analyticsHelper->topCourses($frequency, $courseId, $free);
        if (is_array($topCourses)) {
            return View::make('analytics.partials.topFreeCourses', compact('topCourses','frequency'))->render();
        }
    }

    public function secondTierRegistrationsView($frequency = '')
    {
        //if( Auth::user()->is_vip=='no' && Auth::user()->is_super_vip=='no') return '';
        $frequencyOverride = 'day';
        switch($frequency){
            case 'alltime' :
                $frequencyOverride = 'year';
                $affiliates = $this->analyticsHelper->secondAffiliatesLastFewYears(Auth::id());break;
            case 'week' :
                $frequencyOverride = 'week';
                $affiliates = $this->analyticsHelper->secondAffiliatesLastFewWeeks(Auth::id());break;
            case 'month' :
                $frequencyOverride = 'month';
                $affiliates = $this->analyticsHelper->secondAffiliatesLastFewMonths(Auth::id());break;
            default:
                $affiliates = $this->analyticsHelper->secondAffiliatesLastFewDays(Auth::id());
        }
        $urlIdentifier = '';// 'second-tier-ltc-registrations';
        if (is_array($affiliates)) {
            return View::make('analytics.partials.ltcRegistrations', compact('affiliates', 'frequencyOverride','frequency','urlIdentifier'))->render();
        }

    }

    public function ltcRegistrationsView($frequency = '')
    {
        $frequencyOverride = 'day';
        switch($frequency){
            case 'alltime' :
                $frequencyOverride = 'year';
                $affiliates = $this->analyticsHelper->affiliatesLastFewYears(Auth::id());break;
            case 'week' :
                $frequencyOverride = 'week';
                $affiliates = $this->analyticsHelper->affiliatesLastFewWeeks(Auth::id());break;
            case 'month' :
                $frequencyOverride = 'month';
                $affiliates = $this->analyticsHelper->affiliatesLastFewMonths(Auth::id());break;
            default:
                $affiliates = $this->analyticsHelper->affiliatesLastFewDays(Auth::id());break;
        }

        if (is_array($affiliates)) {
            $urlIdentifier = '';// 'ltc-registrations';
            return View::make('analytics.partials.ltcRegistrations', compact('affiliates', 'frequencyOverride','frequency','urlIdentifier'))->render();
        }
    }

    public function ltcEarningsView($frequency = '')
    {
        $frequencyOverride = 'day';
        switch($frequency){
            case 'alltime' :
                $frequencyOverride = 'year';
                $affiliates = $this->analyticsHelper->affiliateEarningsLastFewYears(Auth::id());break;
            case 'week' :
                $frequencyOverride = 'week';
                $affiliates = $this->analyticsHelper->affiliateEarningsLastFewWeeks(Auth::id());break;
            case 'month' :
                $frequencyOverride = 'month';
                $affiliates = $this->analyticsHelper->affiliateEarningsLastFewMonths(Auth::id());break;
            default:
                $affiliates = $this->analyticsHelper->affiliateEarningsLastFewDays(Auth::id());break;
        }

        if (is_array($affiliates)) {
            $urlIdentifier = 'ltc-earnings';
            return View::make('analytics.partials.ltcEarnings', compact('affiliates', 'frequencyOverride','urlIdentifier','frequency'))->render();
        }
    }
    public function salesView($frequency = '', $courseId = '', $trackingCode = '')
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
            $urlIdentifier = 'sales';
            $group = 'affiliate';
            if ($frequency == 'week'){
                return View::make('analytics.partials.salesWeekly', compact('sales', 'frequency','urlIdentifier','group'))->render();
            }
            elseif($frequency == 'month'){
                return View::make('analytics.partials.salesMonthly', compact('sales', 'frequency','urlIdentifier','group'))->render();
            }
            elseif($frequency == 'alltime'){
                return View::make('analytics.partials.salesYearly', compact('sales', 'frequency','urlIdentifier','group'))->render();
            }
            else {
                return View::make('analytics.partials.sales', compact('sales', 'frequency','urlIdentifier','group'))->render();
            }
        }
    }

    public function trackingCodesSalesView($frequency = '', $courseId = '')
    {
        $trackingCodes = $this->analyticsHelper->trackingCodes($frequency,$courseId);
        if (is_array($trackingCodes)) {
            return View::make('analytics.partials.trackingCodes', compact('trackingCodes', 'frequency'))->render();
        }
    }

    public function courseConversionView($frequency = '')
    {
        $courseConversions = $this->analyticsHelper->courseConversion($frequency);
        if (is_array($courseConversions)) {
            return View::make('analytics.partials.courseConversions', compact('courseConversions', 'frequency'))->render();
        }
    }

    public function trackingCodeConversionView($frequency = '', $courseId = '')
    {
        $trackingCodeConversions = $this->analyticsHelper->trackingCodeConversion($frequency, $courseId);
        if (is_array($trackingCodeConversions)) {

            return View::make('analytics.partials.trackingCodeConversions', compact('trackingCodeConversions', 'frequency'))->render();
        }
    }

    public function trackingCodeHitsSalesView($courseId = '', $trackingCode = '', $frequency = '')
    {
        $trackingHitsSales = $this->analyticsHelper->trackingCodeHitsSales($frequency, $courseId,$trackingCode)[0];
        return View::make('analytics.partials.trackingCodeHitsSales', compact('trackingHitsSales', 'frequency'))->render();

    }

    public function courseStatistics($courseId)
    {
        $course = Course::find($courseId);

        if ($course) {
            $sales = $this->analyticsHelper->sales('week',$courseId);
            $salesLabelData = $this->analyticsHelper->purchasesLabelData($sales);

            $trackingCodesSalesView = $this->trackingCodesSalesView('', $courseId);
            $salesView = $this->salesView('', $courseId);
            $trackingCodeConversionView = $this->trackingCodeConversionView('', $courseId);
            $courses = ProductAffiliate::courses(Auth::id());
            $trackingCodesTableView = $this->trackingCodesTableView('', $courseId);

            return View::make('analytics.courseStatistics', compact('course','trackingCodesSalesView', 'salesView','trackingCodeConversionView','salesLabelData', 'courses', 'trackingCodesTableView'));
        }
    }

    public function trackingCodesTableView($frequency = '', $courseId = 0)
    {
        $startDate = '';
        $endDate = '';

        switch($frequency){
            case 'daily':
                $startDate = date('Y-m-d');
                break;
            case 'weekly':
                $startDate = date('Y-m-d',strtotime('-7 days'));
                $endDate = date('Y-m-d');
                break;
            case 'monthly':
                $startDate = date('Y-m-d', strtotime('-1 month'));
                $endDate = date('Y-m-d');
        }

        $trackingCodes = $this->analyticsHelper->trackingCodesByCourse($courseId, $startDate, $endDate);
        return View::make('analytics.partials.trackingCodesTable',compact('trackingCodes'))->render();
    }

    public function compareTrackingCodes($trackingCode)
    {
        if (Input::has('trackingCodes') AND Input::has('startDate') AND Input::has('endDate')) {
            $trackingCodes = Input::get('trackingCodes');

            $startDate = new \Carbon\Carbon(Input::get('startDate'));
            $endDate = new Carbon\Carbon(Input::get('endDate'));


            $datesDiff = $startDate->diffInDays($endDate);

            $datesArr = [];

            for($i = 0; $i <= $datesDiff; $i++){
                $datesArr[] = date('F d, Y',strtotime(Input::get('endDate') . ' -'. $i .' days'));
            }


            $codesInArr = explode(',',$trackingCodes);
            $codesInArr[] = $trackingCode;
            //$courses = Tracki::whereIn('id', $codesInArr)->get();
            $dataSets = [];

            $index = 0;
            $label = '';

            foreach($codesInArr as $code){
                $sales = $this->analyticsHelper->salesByDateRangeAndCourse($startDate->format('Y-m-d'),$endDate->format('Y-m-d'),0,$code);
                $salesLabelAndData = $this->analyticsHelper->purchasesLabelData($sales, $datesArr);
                $colorCombo = $this->analyticsHelper->chartColorCombo($index);
                $dataSet = [
                    'label' => $code,
                    'fillColor' =>  $colorCombo[0],
                    'strokeColor' =>  $colorCombo[1],
                    'pointColor' => $colorCombo[2],
                    'pointStrokeColor' =>  $colorCombo[2],
                    'pointHighlightFill' =>  $colorCombo[2],
                    'pointHighlightStroke' => $colorCombo[2],
                    'data' => $salesLabelAndData['data']
                ];
                $label = $salesLabelAndData['labels'];

                $dataSets[] = $dataSet;
                $index++;
            }

            return Response::json(compact('label','dataSets'));

        }
    }

    public function compareCourses($defaultCourseId)
    {
        if (Input::has('courseIds') AND Input::has('startDate') AND Input::has('endDate')) {
            $courseIds = Input::get('courseIds');

            $startDate = new \Carbon\Carbon(Input::get('startDate'));
            $endDate = new Carbon\Carbon(Input::get('endDate'));


            $datesDiff = $startDate->diffInDays($endDate);

            $datesArr = [];

            for($i = 0; $i <= $datesDiff; $i++){
                $datesArr[] = date('F d, Y',strtotime(Input::get('endDate') . ' -'. $i .' days'));
            }


            $idsInArr = explode(',',$courseIds);
            $idsInArr[] = $defaultCourseId;
            $courses = Course::whereIn('id', $idsInArr)->get();
            $dataSets = [];

            $index = 0;
            $label = '';

            foreach($courses as $course){
                $sales = $this->analyticsHelper->salesByDateRangeAndCourse($startDate->format('Y-m-d'),$endDate->format('Y-m-d'),$course->id);
                $salesLabelAndData = $this->analyticsHelper->purchasesLabelData($sales, $datesArr);
                $colorCombo = $this->analyticsHelper->chartColorCombo($index);
                $dataSet = [
                        'label' => $course->name,
                        'fillColor' =>  $colorCombo[0],
                        'strokeColor' =>  $colorCombo[1],
                        'pointColor' => $colorCombo[2],
                        'pointStrokeColor' =>  $colorCombo[2],
                        'pointHighlightFill' =>  $colorCombo[2],
                        'pointHighlightStroke' => $colorCombo[2],
                        'data' => $salesLabelAndData['data']
                ];
                $label = $salesLabelAndData['labels'];

                $dataSets[] = $dataSet;
                $index++;
            }

            return Response::json(compact('label','dataSets'));

        }
    }

    public function trackingCodesAll()
    {
        $trackingCodes = $this->analyticsHelper->trackingCodesAll();
        return View::make('analytics.trackingCodes',compact('trackingCodes'));
    }

    public function courseTrackingCodesStatistics($courseId, $trackingCode)
    {
        $course = Course::find($courseId);

        if ($course){
            $hitsSalesView = $this->trackingCodeHitsSalesView($courseId, $trackingCode);
            $salesView = $this->salesView('', $courseId,$trackingCode);
            $trackingCodes = TrackingCodeHits::distinct()->select('tracking_code')->where('affiliate_id', Auth::id())->get();
            $sales = $this->analyticsHelper->sales('week',$courseId,$trackingCode);
            $salesLabelData = $this->analyticsHelper->purchasesLabelData($sales);

            return View::make('analytics.courseTrackingCodeStatistics',compact('course', 'trackingCode', 'hitsSalesView', 'salesView','trackingCodes','salesLabelData'));
        }
    }

    public function secondTierEarningsView($frequency = '', $courseId = '', $trackingCode = '')
    {
        if (Auth::user()->is_second_tier_instructor == 'no'){
            //return '';
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
            $group = 'affiliate';
            if ($frequency == 'week') {
                return View::make('analytics.partials.salesWeekly', compact('sales', 'frequency','urlIdentifier','group'))->render();
            } elseif ($frequency == 'month') {
                return View::make('analytics.partials.salesMonthly', compact('sales', 'frequency','urlIdentifier','group'))->render();
            } elseif ($frequency == 'alltime') {
                return View::make('analytics.partials.salesYearly', compact('sales', 'frequency','urlIdentifier','group'))->render();
            } else {
                return View::make('analytics.partials.sales', compact('sales', 'frequency','urlIdentifier','group'))->render();
            }
        }
    }

    private function _affiliateDashboard()
    {
        $topCoursesView = '';//$this->topCoursesView();
        $salesView = '';//$this->salesView();
        $trackingCodesSalesView = '';//$this->trackingCodesSalesView();
        $courseConversionView = '';//$this->courseConversionView();
        $trackingCodeConversionView = '';//$this->trackingCodeConversionView();
        $ltcRegistrationsView = '';//$this->ltcRegistrationsView();
        $secondTierRegistrationsView = '';//$this->secondTierRegistrationsView();
        $ltcEarningsView = '';//$this->ltcEarningsView();


        if (Input::has('new')){
            return $this->renderIndexV2();
        }


        return View::make('affiliate.dashboard.index', compact('secondTierRegistrationsView','ltcEarningsView', 'topCoursesView', 'salesView', 'trackingCodesSalesView', 'courseConversionView', 'trackingCodeConversionView','ltcRegistrationsView'));
    }

    private function renderIndexV2()
    {
        $sales = $this->analyticsHelper->getAffiliateSalesByDateRange('2015-09-01', '2015-09-30');
        return View::make('affiliate.dashboard.index2',compact('sales'));
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
                $purchases = Purchase::whereRaw("DATE(created_at) = '". Input::get('date') ."'")
                    ->where('product_affiliate_id',Auth::id())
                    ->where('free_product','no')
                    ->paginate(10);
                break;
            case 'week' :
                if (!Input::has('start') && !Input::has('end')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F d, Y',strtotime(Input::get('start'))) . ' - '  . date('F d, Y',strtotime(Input::get('end')));
                $purchases = Purchase::whereRaw("DATE(created_at) BETWEEN '". Input::get('start') ."' AND '". Input::get('end') ."'")
                    ->where('product_affiliate_id',Auth::id())
                    ->where('free_product','no')
                    ->paginate(10);
                break;
            case 'month':
                if (!Input::has('month') && !Input::has('year')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F',strtotime(Input::get('month'))) . Input::get('year');
                $purchases = Purchase::whereRaw("MONTH(created_at) =  '". Input::get('month') ."' AND YEAR(created_at) = '". Input::get('year') ."'")
                    ->where('product_affiliate_id',Auth::id())
                    ->where('free_product','no')
                    ->paginate(10);
                break;
            case 'alltime':
                if (!Input::has('year')){
                    return Redirect::to('analytics');
                }
                $salesLabel = Input::get('year');
                $purchases = Purchase::whereRaw("YEAR(created_at) = '". Input::get('year') ."'")
                    ->where('product_affiliate_id',Auth::id())
                    ->where('free_product','no')
                    ->paginate(10);
                break;
        }

        if ($purchases){
            return View::make('analytics.salesList',compact('purchases','salesLabel'));
        }

        return Redirect::to('analytics');
    }

    public function detailedLtcSales($frequency)
    {
        $purchases = null;

        switch($frequency){
            case 'daily' :
                if (!Input::has('date')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F d, Y',strtotime(Input::get('date')));
                $purchases = Purchase::whereRaw("DATE(created_at) = '". Input::get('date') ."'")
                    ->where('ltc_affiliate_id',Auth::id())
                    ->where('free_product','no')
                    ->paginate(10);
                break;
            case 'week' :
                if (!Input::has('start') && !Input::has('end')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F d, Y',strtotime(Input::get('start'))) . ' - '  . date('F d, Y',strtotime(Input::get('end')));
                $purchases = Purchase::whereRaw("DATE(created_at) BETWEEN '". Input::get('start') ."' AND '". Input::get('end') ."'")
                    ->where('ltc_affiliate_id',Auth::id())
                    ->where('free_product','no')
                    ->paginate(10);
                break;
            case 'month':
                if (!Input::has('month') && !Input::has('year')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F',strtotime(Input::get('month'))) . Input::get('year');
                $purchases = Purchase::whereRaw("MONTH(created_at) =  '". Input::get('month') ."' AND YEAR(created_at) = '". Input::get('year') ."'")
                    ->where('ltc_affiliate_id',Auth::id())
                    ->where('free_product','no')
                    ->paginate(10);
                break;
            case 'alltime':
                if (!Input::has('year')){
                    return Redirect::to('analytics');
                }
                $salesLabel = Input::get('year');
                $purchases = Purchase::whereRaw("YEAR(created_at) = '". Input::get('year') ."'")
                    ->where('ltc_affiliate_id',Auth::id())
                    ->where('free_product','no')
                    ->paginate(10);
                break;
        }

        if ($purchases){
            return View::make('analytics.ltcSalesList',compact('purchases','salesLabel'));
        }

        return Redirect::to('analytics');
    }
    public function detailedSecondTierSales($frequency)
    {
        $purchases = null;

        switch($frequency){
            case 'daily' :
                if (!Input::has('date')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F d, Y',strtotime(Input::get('date')));
                $purchases = Purchase::whereRaw("DATE(created_at) = '". Input::get('date') ."'")
                    ->where('second_tier_affiliate_id',Auth::id())
                    ->where('free_product','no')
                    ->paginate(10);
                break;
            case 'week' :
                if (!Input::has('start') && !Input::has('end')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F d, Y',strtotime(Input::get('start'))) . ' - '  . date('F d, Y',strtotime(Input::get('end')));
                $purchases = Purchase::whereRaw("DATE(created_at) BETWEEN '". Input::get('start') ."' AND '". Input::get('end') ."'")
                    ->where('second_tier_affiliate_id',Auth::id())
                    ->where('free_product','no')
                    ->paginate(10);
                break;
            case 'month':
                if (!Input::has('month') && !Input::has('year')){
                    return Redirect::to('analytics');
                }
                $salesLabel = date('F',strtotime(Input::get('month'))) . Input::get('year');
                $purchases = Purchase::whereRaw("MONTH(created_at) =  '". Input::get('month') ."' AND YEAR(created_at) = '". Input::get('year') ."'")
                    ->where('second_tier_affiliate_id',Auth::id())
                    ->where('free_product','no')
                    ->paginate(10);
                break;
            case 'alltime':
                if (!Input::has('year')){
                    return Redirect::to('analytics');
                }
                $salesLabel = Input::get('year');
                $purchases = Purchase::whereRaw("YEAR(created_at) = '". Input::get('year') ."'")
                    ->where('second_tier_affiliate_id',Auth::id())
                    ->where('free_product','no')
                    ->paginate(10);
                break;
        }

        if ($purchases){
            return View::make('analytics.secondTierSalesList',compact('purchases','salesLabel'));
        }

        return Redirect::to('analytics');
    }

    public function salesTableView($startDate, $endDate)
    {
        $sales = $this->analyticsHelper->getAffiliateSalesByDateRange($startDate,$endDate);
        return View::make('affiliate.analytics.tableSales',compact('sales'))->render();
    }

    public function registrationsTableView($startDate, $endDate)
    {
        $users = $this->analyticsHelper->getRegistrationsCount($startDate, $endDate);
        return View::make('affiliate.analytics.tableRegistrations',compact('users'))->render();
    }

}