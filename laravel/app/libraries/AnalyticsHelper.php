<?php

class AnalyticsHelper
{
    public function dailyTopCourses()
    {
        $dateFilter = $this->_frequencyEquivalence();
        $query = $this->_coursePurchaseRawQuery("DATE(course_purchases.created_at) = '{$dateFilter}'");

        return DB::select($query);
    }

    public function weeklyTopCourses()
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd = date('Y-m-d');
        $query = $this->_coursePurchaseRawQuery("DATE(course_purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'");

        return DB::select($query);
    }

    public function monthlyTopCourses()
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd = date('Y-m-d');
        $query = $this->_coursePurchaseRawQuery("DATE(course_purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'");

        return DB::select($query);
    }


    private function _coursePurchaseRawQuery($criteria = '')
    {
        $sql = "SELECT courses.`name`, SUM(course_purchases.purchase_price) as 'total_purchase'
                FROM course_purchases
                JOIN courses ON courses.id = course_purchases.course_id WHERE
                {$criteria}
                GROUP BY courses.id
                ORDER BY total_purchase DESC
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