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

    public function topCourses($frequency = '')
    {
        switch($frequency){
            case 'daily' : return $this->dailyTopCourses(); break;
            case 'week': return $this->weeklyTopCourses(); break;
            case 'month': return $this->monthlyTopCourses(); break;
            case 'alltime' : return $this->allTimeTopCourses(); break;
            default: return $this->dailyTopCourses();
        }
    }

    public function sales($frequency = '')
    {
        switch($frequency){
            case 'daily' : return $this->dailySales(); break;
            case 'week': return $this->weeklySales(); break;
            case 'month': return $this->monthlySales(); break;
            case 'alltime' : return $this->allTimeSales(); break;
            default: return $this->dailySales();
        }
    }

    public function dailySales()
    {
        $dateFilter = $this->_frequencyEquivalence();
        $query = $this->_salesRawQuery("DATE(course_purchases.created_at) = '{$dateFilter}'");
        return $this->_transformCoursePurchases($query);
    }

    public function weeklySales()
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd = date('Y-m-d');
        $query = $this->_salesRawQuery("DATE(course_purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'");
        return $this->_transformCoursePurchases($query);
    }

    public function monthlySales()
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd = date('Y-m-d');
        $query = $this->_salesRawQuery("DATE(course_purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'");

        return $this->_transformCoursePurchases($query);
    }

    public function allTimeSales()
    {
        $query = $this->_salesRawQuery();

        return $this->_transformCoursePurchases($query);
    }

    public function dailyTopCourses()
    {
        $dateFilter = $this->_frequencyEquivalence();
        $query = $this->_coursePurchaseRawQuery("DATE(course_purchases.created_at) = '{$dateFilter}'");
        return $this->_transformCoursePurchases($query);
    }

    public function weeklyTopCourses()
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd = date('Y-m-d');
        $query = $this->_coursePurchaseRawQuery("DATE(course_purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'");

        return $this->_transformCoursePurchases($query);
    }

    public function monthlyTopCourses()
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd = date('Y-m-d');
        $query = $this->_coursePurchaseRawQuery("DATE(course_purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'");

        return $this->_transformCoursePurchases($query);
    }

    public function allTimeTopCourses()
    {
        $query = $this->_coursePurchaseRawQuery();

        return $this->_transformCoursePurchases($query);
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


    private function _coursePurchaseRawQuery($criteria = '')
    {
        if (!empty($criteria)){
            $criteria = ' AND ' . $criteria;
        }

        if (!$this->isAdmin AND !empty($this->affiliateId)){
            $criteria .= " AND (course_purchases.ltc_affiliate_id = '{$this->affiliateId}' OR course_purchases.product_affiliate_id = '{$this->affiliateId}' )";
        }

        $sql = "SELECT courses.`name`, SUM(course_purchases.purchase_price) as 'total_purchase'
                FROM course_purchases
                JOIN courses ON courses.id = course_purchases.course_id WHERE course_purchases.id <> 0
                {$criteria}
                GROUP BY courses.id
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