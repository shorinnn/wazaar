<?php

class AnalyticsHelper
{
    protected $affiliateId;
    protected $isAdmin;

    public function __construct($isAdmin, $affiliateId = 0)
    {
        $this->isAdmin = $isAdmin;
        $this->affiliateId = $affiliateId;
    }

    public function topCourses($frequency = '', $courseId = '')
    {
        switch($frequency){
            case 'daily' : return $this->dailyTopCourses($courseId); break;
            case 'week': return $this->weeklyTopCourses($courseId); break;
            case 'month': return $this->monthlyTopCourses($courseId); break;
            case 'alltime' : return $this->allTimeTopCourses($courseId); break;
            default: return $this->dailyTopCourses($courseId);
        }
    }

    public function sales($frequency = '', $courseId = '')
    {
        switch($frequency){
            case 'daily' : return $this->dailySales($courseId); break;
            case 'week': return $this->weeklySales($courseId); break;
            case 'month': return $this->monthlySales($courseId); break;
            case 'alltime' : return $this->allTimeSales($courseId); break;
            default: return $this->dailySales($courseId);
        }
    }

    public function trackingCodes($frequency = '', $courseId = null)
    {
        switch($frequency){
            case 'daily' : return $this->dailyTrackingCodes($courseId); break;
            case 'week': return $this->weeklyTrackingCodes($courseId); break;
            case 'month': return $this->monthlyTrackingCodes($courseId); break;
            case 'alltime' : return $this->allTimeTrackingCodes($courseId); break;
            default: return $this->dailyTrackingCodes($courseId);
        }
    }

    public function courseConversion($frequency = '', $courseId = null)
    {
        switch($frequency){
            case 'daily' : return $this->dailyCourseConversion($courseId); break;
            case 'week': return $this->weeklyCourseConversion($courseId); break;
            case 'month': return $this->monthlyCourseConversion($courseId); break;
            case 'alltime' : return $this->allTimeCourseConversion($courseId); break;
            default: return $this->dailyCourseConversion($courseId);
        }
    }

    public function trackingCodeConversion($frequency = '', $courseId = null)
    {
        switch($frequency){
            case 'daily' : return $this->dailyTrackingCodeConversion($courseId); break;
            case 'week': return $this->weeklyTrackingCodeConversion($courseId); break;
            case 'month': return $this->monthlyTrackingCodeConversion($courseId); break;
            case 'alltime' : return $this->allTimeTrackingCodeConversion($courseId); break;
            default: return $this->dailyTrackingCodeConversion($courseId);
        }
    }

    public function trackingCodeHitsSales($frequency = '', $courseId = null, $trackingCode = '')
    {
        switch($frequency){
            case 'daily' : return $this->dailyHitsSales($courseId, $trackingCode); break;
            case 'week': return $this->weeklyHitsSales($courseId, $trackingCode); break;
            case 'month': return $this->monthlyHitsSales($courseId, $trackingCode); break;
            case 'alltime' : return $this->allTimeHitsSales($courseId, $trackingCode); break;
            default: return $this->dailyHitsSales($courseId, $trackingCode);
        }
    }


    public function dailySales($courseId, $date = '')
    {
        if (empty($date)) {
            $dateFilter = $this->_frequencyEquivalence();
        }
        else{
            $dateFilter = $date;
        }
        $filterQuery = "DATE(purchases.created_at) = '{$dateFilter}'";

        if (!empty($courseId)){
            $filterQuery .= " AND purchases.product_id = '{$courseId}'";
        }

        $query = $this->_salesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function salesLastFewWeeks($numOfWeeks, $courseId = 0)
    {
        $sales = [];

        for ($i = 0; $i <= $numOfWeeks; $i++){
            $start = date('Y-m-d',strtotime('-' . ($i+1) .  ' week'));
            $end = date('Y-m-d',strtotime("-$i week"));
            $label = $i . ( ($i > 1) ? ' weeks' : ' week') . ' ago';
            if ($i === 0){
                $label = 'This week';
            }
            $sales[] = ['label' => $label, 'start' => $start, 'end' => $end, 'week' =>$this->weeklySales($courseId,$start,$end)];
        }
        $salesTotal = 0;

        foreach($sales as $sale){
            $salesTotal += $sale['week']['sales_total'];
        }

        return compact('sales', 'salesTotal');
    }

    public function salesLastFewMonths($numOfMonths, $courseId = 0)
    {
        $sales = [];

        for ($i = 0; $i <= $numOfMonths; $i++){
            $month = date('m',strtotime("-$i month"));
            $year = date('Y',strtotime("-$i month"));
            $label = $i . ( ($i > 1) ? ' months' : ' month') . ' ago';
            if ($i === 0){
                $label = 'This month';
            }
            $sales[] = ['label' => $label, 'month_date' => $month, 'year' => $year, 'month' =>$this->monthlySales($courseId, $month, $year)];
        }
        $salesTotal = 0;

        foreach($sales as $sale){
            $salesTotal += $sale['month']['sales_total'];
        }

        return compact('sales', 'salesTotal');
    }

    public function salesLastFewYears($numOfYears, $courseId = 0)
    {
        $sales = [];

        for ($i = 0; $i <= $numOfYears; $i++){
            $year = date('Y',strtotime("-$i year"));
            $label = $i . ( ($i > 1) ? ' years' : ' year') . ' ago';
            if ($i === 0){
                $label = 'This year';
            }
            $sales[] = ['label' => $label, 'year_date' => $year, 'year' => $year, 'year' =>$this->allTimeSales($courseId, $year)];
        }
        $salesTotal = 0;

        foreach($sales as $sale){
            $salesTotal += $sale['year']['sales_total'];
        }

        return compact('sales', 'salesTotal');
    }


    public function weeklySales($courseId, $dateFilterStart = '', $dateFilterEnd = '')
    {
        if (empty($dateFilterStart)) {
            $dateFilterStart = $this->_frequencyEquivalence('week');
        }

        if (empty($dateFilterEnd)) {
            $dateFilterEnd = date('Y-m-d');
        }

        $filterQuery = "DATE(purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)){
            $filterQuery .= " AND purchases.product_id = '{$courseId}'";
        }
        $query = $this->_salesRawQuery($filterQuery);
        return $this->_transformCoursePurchases($query);
    }

    public function monthlySales($courseId, $month = '', $year = '')
    {
        if (empty($month)){
            $month = date('m');
        }

        if (empty($year)){
            $year = date('Y');
        }
        //$dateFilterStart = $this->_frequencyEquivalence('month');
        //$dateFilterEnd = date('Y-m-d');

        //$filterQuery = "DATE(purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";
        $filterQuery = "YEAR(purchases.created_at) = '{$year}' AND MONTH(purchases.created_at) = '{$month}'";

        if (!empty($courseId)){
            $filterQuery .= " AND purchases.product_id = '{$courseId}'";
        }
        $query = $this->_salesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function allTimeSales($courseId, $year = '')
    {
        if (empty($year)){
            $year = date('Y');
        }
        $filterQuery = "YEAR(purchases.created_at) = '{$year}'";
        if (!empty($courseId)){
            $filterQuery .= " AND purchases.product_id = '{$courseId}'";
        }

        $query = $this->_salesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function dailyTopCourses($courseId)
    {
        $dateFilter = $this->_frequencyEquivalence();
        $filterQuery = "DATE(purchases.created_at) = '{$dateFilter}'";

        if (!empty($courseId)){
            $filterQuery .= " AND product_id = '{$courseId}'";
        }

        $query = $this->_purchaseRawQuery($filterQuery);
        return $this->_transformCoursePurchases($query);
    }

    public function weeklyTopCourses($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = "DATE(purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)){
            $filterQuery .= " AND product_id = '{$courseId}'";
        }

        $query = $this->_purchaseRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function monthlyTopCourses($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = "DATE(purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)){
            $filterQuery .= " AND product_id = '{$courseId}'";
        }

        $query = $this->_purchaseRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function allTimeTopCourses($courseId)
    {
        $filterQuery = "";

        if (!empty($courseId)){
            $filterQuery = " AND product_id = '{$courseId}'";
        }

        $query = $this->_purchaseRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function dailyTrackingCodes($courseId)
    {
        $dateFilter = $this->_frequencyEquivalence();
        $filterQuery = "DATE(created_at) = '{$dateFilter}'";

        if (!empty($courseId)){
            $filterQuery .= " AND course_id = '{$courseId}'";
        }

        $query = $this->_trackingCodesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function weeklyTrackingCodes($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = "DATE(created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)){
            $filterQuery .= " AND product_id = '{$courseId}'";
        }

        $query = $this->_trackingCodesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function monthlyTrackingCodes($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = "DATE(created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)){
            $filterQuery .= " AND product_id = '{$courseId}'";
        }

        $query = $this->_trackingCodesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function allTimeTrackingCodes($courseId)
    {
        $filterQuery = "";

        if (!empty($courseId)){
            $filterQuery = " product_id = '{$courseId}'";
        }
        $query = $this->_trackingCodesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function dailyHitsSales($courseId, $trackingCode)
    {
        $dateFilter = $this->_frequencyEquivalence();
        $filterQuery = " AND DATE(created_at) = '{$dateFilter}'";


        $query = $this->_codeStatisticsRawQuery($courseId,$trackingCode,  $filterQuery);

        return DB::select($query);
    }

    public function weeklyHitsSales($courseId, $trackingCode)
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = " AND DATE(created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        $query = $this->_codeStatisticsRawQuery($courseId,$trackingCode, $filterQuery);

        return DB::select($query);
    }

    public function monthlyHitsSales($courseId, $trackingCode)
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = " AND DATE(created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        $query = $this->_codeStatisticsRawQuery($courseId,$trackingCode, $filterQuery);

        return DB::select($query);
    }

    public function allTimeHitsSales($courseId, $trackingCode)
    {
        $filterQuery = "";

        $query = $this->_codeStatisticsRawQuery($courseId, $trackingCode, $filterQuery);

        return DB::select($query);
    }

    public function dailyCourseConversion($courseId)
    {
        $dateFilter = $this->_frequencyEquivalence();
        $filterQuery = "DATE(cp.created_at) = '{$dateFilter}'";

        if (!empty($courseId)){
            $filterQuery .= " AND cp.product_id = '{$courseId}'";
        }

        $query = $this->_coursePurchaseConversionRawQuery($filterQuery);


        return $this->_transformCoursePurchaseConversion($query);
    }

    public function weeklyCourseConversion($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd = date('Y-m-d');
        $filterQuery = "DATE(cp.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)){
            $filterQuery .= " AND cp.product_id = '{$courseId}'";
        }

        $query = $this->_coursePurchaseConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function monthlyCourseConversion($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd = date('Y-m-d');
        $filterQuery = "DATE(cp.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)){
            $filterQuery .= " AND cp.product_id = '{$courseId}'";
        }

        $query = $this->_coursePurchaseConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function allTimeCourseConversion($courseId = "")
    {
        $filterQuery = "";

        if (!empty($courseId)){
            $filterQuery = "cp.product_id = '{$courseId}'";
        }
        $query = $this->_coursePurchaseConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function dailyTrackingCodeConversion($courseId = "")
    {
        $dateFilter = $this->_frequencyEquivalence();
        $filterQuery = "DATE(cp.created_at) = '{$dateFilter}'";

        if (!empty($courseId)){
            $filterQuery = "cp.product_id = '{$courseId}'";
        }

        $query = $this->_trackingCodeConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function weeklyTrackingCodeConversion($courseId = "")
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = "DATE(cp.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)){
            $filterQuery = "cp.product_id = '{$courseId}'";
        }

        $query = $this->_trackingCodeConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function monthlyTrackingCodeConversion($courseId = "")
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = "DATE(cp.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)){
            $filterQuery = "cp.product_id = '{$courseId}'";
        }

        $query = $this->_trackingCodeConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function allTimeTrackingCodeConversion($courseId = "")
    {
        $filterQuery = "";

        if (!empty($courseId)){
            $filterQuery = "cp.product_id = '{$courseId}'";
        }

        $query = $this->_trackingCodeConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function jsonCoursePurchases($sales)
    {
        $labels = [];
        $data = [];

        foreach($sales['data'] as $sale){
            $labels[] = date('F d, Y', strtotime($sale['created_at']));
            $data[] =  $sale['total_purchase'];
        }

        $labels = array_reverse($labels);
        $data = array_reverse($data);
        return compact('labels', 'data');
    }

    private function _transformCoursePurchases($query)
    {
        $result = DB::select($query);
        $result = array_map(function($val)
                {
                            return json_decode(json_encode($val), true);
                }, $result);
        $output = [
            'data' => $result,
            'count' => count($result),
            'sales_total' => array_sum(array_column($result,'total_purchase'))
        ];

        return $output;
    }

    private function _transformCoursePurchaseConversion($query)
    {
        $result = DB::select($query);
        $result = array_map(function($val)
        {
            return json_decode(json_encode($val), true);
        }, $result);
        $output = [
            'data' => $result,
            'count' => count($result)
        ];

        return $output;
    }


    private function _purchaseRawQuery($criteria = '', $type = 'Course')
    {


        if (!empty($criteria)){
            $criteria = ' AND ' . $criteria;
        }

        if(!empty($type)){
            $criteria .= " AND product_type='{$type}'";
        }

        if (!$this->isAdmin AND !empty($this->affiliateId)){
            //$criteria .= " AND (purchases.ltc_affiliate_id = '{$this->affiliateId}' OR purchases.product_affiliate_id = '{$this->affiliateId}' )";
            $criteria .= " AND (purchases.product_affiliate_id = '{$this->affiliateId}' )";
        }

        $sql = "SELECT courses.id, courses.`name`, SUM(purchases.purchase_price) as 'total_purchase'
                FROM purchases
                JOIN courses ON courses.id = purchases.product_id WHERE purchases.id <> 0
                {$criteria}
                GROUP BY courses.id, courses.name
                ORDER BY total_purchase DESC
                ";
        return $sql;
    }

    private function _salesRawQuery($criteria = '')
    {
        if (!empty($criteria)){
            $criteria = ' AND ' . $criteria;
        }

        if (!$this->isAdmin AND !empty($this->affiliateId)){
            //$criteria .= " AND (purchases.ltc_affiliate_id = '{$this->affiliateId}' OR purchases.product_affiliate_id = '{$this->affiliateId}' )";
            $criteria .= " AND (purchases.product_affiliate_id = '{$this->affiliateId}' )";

        }

        $sql = "SELECT created_at, SUM(purchases.purchase_price) as 'total_purchase'
                FROM purchases WHERE id <> 0
                {$criteria}
                GROUP BY DATE(created_at)
                ORDER BY created_at DESC
                ";
        return $sql;
    }

    private function _trackingCodesRawQuery($criteria = '', $limit = 10)
    {
        if (!empty($criteria)){
            $criteria = ' AND ' . $criteria;
        }

        if (!$this->isAdmin AND !empty($this->affiliateId)){
            $criteria .= " AND affiliate_id = '{$this->affiliateId}'";
        }

        $sql = "SELECT course_id, tracking_code, count(tracking_code) as 'count'
                FROM tracking_code_hits  WHERE id <> 0
                 {$criteria}
                GROUP BY course_id, tracking_code
                ORDER BY count DESC LIMIT {$limit}";
        return $sql;
    }

    private function _coursePurchaseConversionRawQuery($criteria = '', $limit = 10)
    {

        if (!empty($criteria)){
            $criteria = ' AND ' . $criteria;
        }

        $criteriaPurchase = $criteria;
        $criteriaPurchase2 = $criteria;
        if (!$this->isAdmin AND !empty($this->affiliateId)){
            $criteria .= " AND affiliate_id = '{$this->affiliateId}'";
            //$criteriaPurchase .= " AND (cp.ltc_affiliate_id = '{$this->affiliateId}' OR cp.product_affiliate_id = '{$this->affiliateId}' )";
            //$criteriaPurchase2 .= " AND (purchases.ltc_affiliate_id = '{$this->affiliateId}' OR purchases.product_affiliate_id = '{$this->affiliateId}' )";
            $criteriaPurchase .= " AND cp.product_affiliate_id = '{$this->affiliateId}'";
            $criteriaPurchase2 .= " AND purchases.product_affiliate_id = '{$this->affiliateId}'";
        }

        $sql = "SELECT courses.`name`, cp.product_id,
               (
                       SELECT COUNT(purchases.id)
                      FROM purchases
                      WHERE purchases.product_id = cp.product_id
                      {$criteriaPurchase2}
                ) as 'purchases',
               (
                         SELECT COUNT(tracking_code_hits.id)
                        FROM tracking_code_hits
                        WHERE tracking_code_hits.course_id = cp.product_id
                        {$criteria}
                 ) as 'hits'
            FROM purchases cp
            JOIN courses ON courses.id = cp.product_id
            WHERE cp.id <> 0
            {$criteriaPurchase}
            GROUP BY courses.name, cp.product_id
            ORDER BY (purchases/hits) DESC
            LIMIT {$limit}";
        return $sql;
    }

    private function _trackingCodeConversionRawQuery($criteria = '', $limit = 10)
    {

        if (!empty($criteria)){
            $criteria = ' AND ' . $criteria;
        }

        $criteriaPurchase = $criteria;
        $criteriaPurchase2 = $criteria;
        if (!$this->isAdmin AND !empty($this->affiliateId)){
            $criteria .= " AND affiliate_id = '{$this->affiliateId}'";
            $criteriaPurchase .= " AND (cp.ltc_affiliate_id = '{$this->affiliateId}' OR cp.product_affiliate_id = '{$this->affiliateId}' )";
            $criteriaPurchase2 .= " AND (purchases.ltc_affiliate_id = '{$this->affiliateId}' OR purchases.product_affiliate_id = '{$this->affiliateId}' )";
        }

        $sql = "SELECT DISTINCT cp.tracking_code, cp.product_id,
               (
                       SELECT COUNT(purchases.id)
                      FROM purchases
                      WHERE purchases.tracking_code = cp.tracking_code
                      {$criteriaPurchase2}
                ) as 'purchases',
               (
                         SELECT COUNT(tracking_code_hits.id)
                        FROM tracking_code_hits
                        WHERE tracking_code_hits.tracking_code = cp.tracking_code
                        {$criteria}
                 ) as 'hits'
            FROM purchases cp
            WHERE cp.id <> 0 AND cp.tracking_code <> ''
            {$criteriaPurchase}
            GROUP BY cp.tracking_code, cp.product_id
            ORDER BY (purchases/hits) DESC
            LIMIT {$limit}";

        return $sql;
    }

    private function _codeStatisticsRawQuery($courseId, $code, $criteria = '')
    {
        $sql = "SELECT (SELECT count(id) FROM tracking_code_hits WHERE tracking_code = '{$code}' AND course_id = '{$courseId}' {$criteria}) as 'hits',
			           (SELECT count(id) FROM purchases WHERE tracking_code = '{$code}' AND product_id = '{$courseId}' {$criteria}) as 'sales_count',
                       (SELECT sum(purchase_price) FROM purchases WHERE tracking_code = '{$code}' AND product_id = '{$courseId}' {$criteria}) as 'sales_total' ";

        return $sql;
    }

    private function _frequencyEquivalence($frequency = null)
    {
        if ($frequency == 'week'){
            return date('Y-m-d', strtotime('-1 week'));
        }
        if ($frequency == 'month'){
            return date('Y-m-d', strtotime('-1 month'));
        }

        return date('Y-m-d');
    }



}