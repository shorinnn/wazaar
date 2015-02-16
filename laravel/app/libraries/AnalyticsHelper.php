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


    public function dailySales($courseId)
    {
        $dateFilter = $this->_frequencyEquivalence();
        $filterQuery = "DATE(course_purchases.created_at) = '{$dateFilter}'";

        if (!empty($courseId)){
            $filterQuery .= " AND course_purchases.course_id = '{$courseId}'";
        }

        $query = $this->_salesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function weeklySales($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = "DATE(course_purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)){
            $filterQuery .= " AND course_purchases.course_id = '{$courseId}'";
        }
        $query = $this->_salesRawQuery($filterQuery);
        return $this->_transformCoursePurchases($query);
    }

    public function monthlySales($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = "DATE(course_purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)){
            $filterQuery .= " AND course_purchases.course_id = '{$courseId}'";
        }
        $query = $this->_salesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function allTimeSales($courseId)
    {
        $filterQuery = "";
        if (!empty($courseId)){
            $filterQuery = " course_purchases.course_id = '{$courseId}'";
        }

        $query = $this->_salesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function dailyTopCourses($courseId)
    {
        $dateFilter = $this->_frequencyEquivalence();
        $filterQuery = "DATE(course_purchases.created_at) = '{$dateFilter}'";

        if (!empty($courseId)){
            $filterQuery .= " AND course_id = '{$courseId}'";
        }

        $query = $this->_coursePurchaseRawQuery($filterQuery);
        return $this->_transformCoursePurchases($query);
    }

    public function weeklyTopCourses($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = "DATE(course_purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)){
            $filterQuery .= " AND course_id = '{$courseId}'";
        }

        $query = $this->_coursePurchaseRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function monthlyTopCourses($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = "DATE(course_purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)){
            $filterQuery .= " AND course_id = '{$courseId}'";
        }

        $query = $this->_coursePurchaseRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function allTimeTopCourses($courseId)
    {
        $filterQuery = "";

        if (!empty($courseId)){
            $filterQuery = " AND course_id = '{$courseId}'";
        }

        $query = $this->_coursePurchaseRawQuery($filterQuery);

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
            $filterQuery .= " AND course_id = '{$courseId}'";
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
            $filterQuery .= " AND course_id = '{$courseId}'";
        }

        $query = $this->_trackingCodesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function allTimeTrackingCodes($courseId)
    {
        $filterQuery = "";

        if (!empty($courseId)){
            $filterQuery = " course_id = '{$courseId}'";
        }
        $query = $this->_trackingCodesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function dailyHitsSales($courseId, $trackingCode)
    {
        $dateFilter = $this->_frequencyEquivalence();
        $filterQuery = " AND DATE(created_at) = '{$dateFilter}'";


        $query = $this->_codeStatisticsRawQuery($trackingCode, $courseId, $filterQuery);

        return DB::select($query);
    }

    public function weeklyHitsSales($courseId, $trackingCode)
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = " AND DATE(created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        $query = $this->_codeStatisticsRawQuery($trackingCode, $courseId, $filterQuery);

        return DB::select($query);
    }

    public function monthlyHitsSales($courseId, $trackingCode)
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd = date('Y-m-d');

        $filterQuery = " AND DATE(created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        $query = $this->_codeStatisticsRawQuery($trackingCode, $courseId, $filterQuery);

        return DB::select($query);
    }

    public function allTimeHitsSales($courseId, $trackingCode)
    {
        $filterQuery = "";

        $query = $this->_codeStatisticsRawQuery($trackingCode, $courseId, $filterQuery);

        return DB::select($query);
    }

    public function dailyCourseConversion($courseId)
    {
        $dateFilter = $this->_frequencyEquivalence();
        $filterQuery = "DATE(cp.created_at) = '{$dateFilter}'";

        if (!empty($courseId)){
            $filterQuery .= " AND cp.course_id = '{$courseId}'";
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
            $filterQuery .= " AND cp.course_id = '{$courseId}'";
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
            $filterQuery .= " AND cp.course_id = '{$courseId}'";
        }

        $query = $this->_coursePurchaseConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function allTimeCourseConversion($courseId = "")
    {
        $filterQuery = "";

        if (!empty($courseId)){
            $filterQuery = "cp.course_id = '{$courseId}'";
        }
        $query = $this->_coursePurchaseConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function dailyTrackingCodeConversion($courseId = "")
    {
        $dateFilter = $this->_frequencyEquivalence();
        $filterQuery = "DATE(cp.created_at) = '{$dateFilter}'";

        if (!empty($courseId)){
            $filterQuery = "cp.course_id = '{$courseId}'";
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
            $filterQuery = "cp.course_id = '{$courseId}'";
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
            $filterQuery = "cp.course_id = '{$courseId}'";
        }

        $query = $this->_trackingCodeConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function allTimeTrackingCodeConversion($courseId = "")
    {
        $filterQuery = "";

        if (!empty($courseId)){
            $filterQuery = "cp.course_id = '{$courseId}'";
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
            $data[] =  number_format($sale['total_purchase'],2);
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


    private function _coursePurchaseRawQuery($criteria = '')
    {
        if (!empty($criteria)){
            $criteria = ' AND ' . $criteria;
        }

        if (!$this->isAdmin AND !empty($this->affiliateId)){
            $criteria .= " AND (course_purchases.ltc_affiliate_id = '{$this->affiliateId}' OR course_purchases.product_affiliate_id = '{$this->affiliateId}' )";
        }

        $sql = "SELECT courses.id, courses.`name`, SUM(course_purchases.purchase_price) as 'total_purchase'
                FROM course_purchases
                JOIN courses ON courses.id = course_purchases.course_id WHERE course_purchases.id <> 0
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
            $criteria .= " AND (course_purchases.ltc_affiliate_id = '{$this->affiliateId}' OR course_purchases.product_affiliate_id = '{$this->affiliateId}' )";
        }

        $sql = "SELECT created_at, SUM(course_purchases.purchase_price) as 'total_purchase'
                FROM course_purchases WHERE id <> 0
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
            $criteriaPurchase .= " AND (cp.ltc_affiliate_id = '{$this->affiliateId}' OR cp.product_affiliate_id = '{$this->affiliateId}' )";
            $criteriaPurchase2 .= " AND (course_purchases.ltc_affiliate_id = '{$this->affiliateId}' OR course_purchases.product_affiliate_id = '{$this->affiliateId}' )";
        }

        $sql = "SELECT courses.`name`, cp.course_id,
               (
                       SELECT COUNT(course_purchases.id)
                      FROM course_purchases
                      WHERE course_purchases.course_id = cp.course_id
                      {$criteriaPurchase2}
                ) as 'purchases',
               (
                         SELECT COUNT(tracking_code_hits.id)
                        FROM tracking_code_hits
                        WHERE tracking_code_hits.course_id = cp.course_id
                        {$criteria}
                 ) as 'hits'
            FROM course_purchases cp
            JOIN courses ON courses.id = cp.course_id
            WHERE cp.id <> 0
            {$criteriaPurchase}
            GROUP BY courses.name, cp.course_id
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
            $criteriaPurchase2 .= " AND (course_purchases.ltc_affiliate_id = '{$this->affiliateId}' OR course_purchases.product_affiliate_id = '{$this->affiliateId}' )";
        }

        $sql = "SELECT DISTINCT cp.tracking_code, cp.course_id,
               (
                       SELECT COUNT(course_purchases.id)
                      FROM course_purchases
                      WHERE course_purchases.tracking_code = cp.tracking_code
                      {$criteriaPurchase2}
                ) as 'purchases',
               (
                         SELECT COUNT(tracking_code_hits.id)
                        FROM tracking_code_hits
                        WHERE tracking_code_hits.tracking_code = cp.tracking_code
                        {$criteria}
                 ) as 'hits'
            FROM course_purchases cp
            WHERE cp.id <> 0 AND cp.tracking_code <> ''
            {$criteriaPurchase}
            GROUP BY cp.tracking_code, cp.course_id
            ORDER BY (purchases/hits) DESC
            LIMIT {$limit}";

        return $sql;
    }

    private function _codeStatisticsRawQuery($code, $courseId, $criteria = '')
    {
        $sql = "SELECT (SELECT count(id) FROM tracking_code_hits WHERE tracking_code = '{$code}' AND course_id = '{$courseId}' {$criteria}) as 'hits',
			           (SELECT count(id) FROM course_purchases WHERE tracking_code = '{$code}' AND course_id = '{$courseId}' {$criteria}) as 'sales_count',
                       (SELECT sum(purchase_price) FROM course_purchases WHERE tracking_code = '{$code}' AND course_id = '{$courseId}' {$criteria}) as 'sales_total' ";

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