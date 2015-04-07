<?php

class AnalyticsHelper
{

    protected $affiliateId;
    protected $isAdmin;

    public function __construct($isAdmin, $affiliateId = 0)
    {
        $this->isAdmin     = $isAdmin;
        $this->affiliateId = $affiliateId;
    }

    private function dailyLtcRegistration($affiliateId, $dateFilter = '')
    {
        if (empty($dateFilter)) {
            $dateFilter = $this->_frequencyEquivalence();
        }

        $filterQuery = " AND DATE(users.created_at) = '{$dateFilter}'";
        return $this->_affiliates($affiliateId, $filterQuery);
    }

    private function weeklyLtcRegistration($affiliateId, $dateFilterStart, $dateFilterEnd)
    {
        $filterQuery = " AND DATE(users.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";
        return $this->_affiliates($affiliateId, $filterQuery);
    }

    private function monthlyLtcRegistration($affiliateId, $month, $year)
    {
        $filterQuery = " AND MONTH(users.created_at) = '{$month}' AND YEAR(users.created_at) = '{$year}'";
        return $this->_affiliates($affiliateId, $filterQuery);
    }


    private function allTimeLtcRegistration($affiliateId, $year)
    {
        $filterQuery = " AND YEAR(users.created_at) = '{$year}'";
        return $this->_affiliates($affiliateId, $filterQuery);
    }

    private function _affiliates($affiliateId, $filter = '')
    {
        $sql = "SELECT count(id) as affiliates_count FROM users WHERE ltc_affiliate_id = '{$affiliateId}' AND id <> 0 {$filter}";
        $result = DB::select($sql);

        $result = array_map(function ($val) {
            return json_decode(json_encode($val), true);
        }, $result);
        $output = [
            'data'        => $result,
            'count'       => count($result),
            'affiliates_count' => array_sum(array_column($result, 'affiliates_count')),
        ];

        return $output;
    }

    public function topCourses($frequency = '', $courseId = '')
    {
        switch ($frequency) {
            case 'daily' :
                return $this->dailyTopCourses($courseId);
                break;
            case 'week':
                return $this->weeklyTopCourses($courseId);
                break;
            case 'month':
                return $this->monthlyTopCourses($courseId);
                break;
            case 'alltime' :
                return $this->allTimeTopCourses($courseId);
                break;
            default:
                return $this->dailyTopCourses($courseId);
        }
    }

    public function sales($frequency = '', $courseId = '', $trackingCode = '')
    {
        switch ($frequency) {
            case 'daily' :
                return $this->dailySales($courseId, $trackingCode);
                break;
            case 'week':
                return $this->weeklySales($courseId, '', '', $trackingCode);
                break;
            case 'month':
                return $this->monthlySales($courseId);
                break;
            case 'alltime' :
                return $this->allTimeSales($courseId);
                break;
            default:
                return $this->dailySales($courseId);
        }
    }

    public function salesByDateRangeAndCourse($startDate, $endDate, $courseId, $trackingCode = '')
    {
        $filterQuery = "DATE(purchases.created_at) BETWEEN '{$startDate}' AND '{$endDate}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND purchases.product_id = '{$courseId}'";
        }

        if (!empty($trackingCode)) {
            $filterQuery .= " AND purchases.tracking_code = '{$trackingCode}'";
        }

        $query = $this->_salesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function trackingCodes($frequency = '', $courseId = null)
    {
        switch ($frequency) {
            case 'daily' :
                return $this->dailyTrackingCodes($courseId);
                break;
            case 'week':
                return $this->weeklyTrackingCodes($courseId);
                break;
            case 'month':
                return $this->monthlyTrackingCodes($courseId);
                break;
            case 'alltime' :
                return $this->allTimeTrackingCodes($courseId);
                break;
            default:
                return $this->dailyTrackingCodes($courseId);
        }
    }

    public function courseConversion($frequency = '', $courseId = null)
    {
        switch ($frequency) {
            case 'daily' :
                return $this->dailyCourseConversion($courseId);
                break;
            case 'week':
                return $this->weeklyCourseConversion($courseId);
                break;
            case 'month':
                return $this->monthlyCourseConversion($courseId);
                break;
            case 'alltime' :
                return $this->allTimeCourseConversion($courseId);
                break;
            default:
                return $this->dailyCourseConversion($courseId);
        }
    }

    public function trackingCodeConversion($frequency = '', $courseId = null)
    {
        switch ($frequency) {
            case 'daily' :
                return $this->dailyTrackingCodeConversion($courseId);
                break;
            case 'week':
                return $this->weeklyTrackingCodeConversion($courseId);
                break;
            case 'month':
                return $this->monthlyTrackingCodeConversion($courseId);
                break;
            case 'alltime' :
                return $this->allTimeTrackingCodeConversion($courseId);
                break;
            default:
                return $this->dailyTrackingCodeConversion($courseId);
        }
    }

    public function trackingCodeHitsSales($frequency = '', $courseId = null, $trackingCode = '')
    {
        switch ($frequency) {
            case 'daily' :
                return $this->dailyHitsSales($courseId, $trackingCode);
                break;
            case 'week':
                return $this->weeklyHitsSales($courseId, $trackingCode);
                break;
            case 'month':
                return $this->monthlyHitsSales($courseId, $trackingCode);
                break;
            case 'alltime' :
                return $this->allTimeHitsSales($courseId, $trackingCode);
                break;
            default:
                return $this->dailyHitsSales($courseId, $trackingCode);
        }
    }


    public function dailySales($courseId, $date = '', $trackingCode = '')
    {
        if (empty($date)) {
            $dateFilter = $this->_frequencyEquivalence();
        } else {
            $dateFilter = $date;
        }
        $filterQuery = "DATE(purchases.created_at) = '{$dateFilter}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND purchases.product_id = '{$courseId}'";
        }

        if (!empty($trackingCode)) {
            $filterQuery .= "And purchases.tracking_code = '{$trackingCode}'";
        }

        $query = $this->_salesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function salesLastFewWeeks($numOfWeeks, $courseId = 0, $trackingCode = '')
    {
        $sales = [];

        for ($i = 0; $i <= $numOfWeeks; $i ++) {
            $start = date('Y-m-d', strtotime('-' . ($i + 1) . ' week'));
            $end   = date('Y-m-d', strtotime("-$i week"));
            $label = $i . (($i > 1) ? ' weeks' : ' week') . ' ago';
            if ($i === 0) {
                $label = 'This week';
            }
            $sales[] = [
                'label' => $label,
                'start' => $start,
                'end'   => $end,
                'week'  => $this->weeklySales($courseId, $start, $end, $trackingCode)
            ];
        }

        $salesTotal = 0;
        $salesCount = 0;
        $maxSale    = $this->_getMaxSalesValue($sales, 'week');
        $maxCount   = $this->_getMaxSalesCount($sales, 'week');

        $i = 0;
        foreach ($sales as $sale) {
            $salesTotal += $sale['week']['sales_total'];
            $salesCount += $sale['week']['sales_count'];
            // avoid division by zero
            if ($maxSale == 0) {
                $percentage = 0;
            } else {
                $percentage = ($sale['week']['sales_total'] / $maxSale) * 100;
            }
            $sales[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;

            // avoid division by zero
            if ($maxCount == 0) {
                $percentage = 0;
            } else {
                $percentage = ($sale['week']['sales_count'] / $maxCount) * 100;
            }
            $sales[$i]['percentage_count'] = ($percentage > 0) ? $percentage : 1;

            $i ++;
        }

        return compact('sales', 'salesTotal', 'salesCount');
    }


    public function salesLastFewDays($numOfDays, $courseId = 0, $trackingCode = '')
    {
        $sales = [];

        for ($i = 0; $i <= $numOfDays; $i ++) {
            $day   = date('l', strtotime("-$i day"));
            $date  = date('Y-m-d', strtotime("-$i day"));
            $label = $day;
            if ($i === 0) {
                $label = 'Today';
            }
            $sales[] = [
                'label' => $label,
                'date'  => $date,
                'day'   => $this->courseDailySales($courseId, $date, $trackingCode)
            ];
        }
        $salesTotal = 0;
        $salesCount = 0;

        $maxSale  = $this->_getMaxSalesValue($sales, 'day');
        $maxCount = $this->_getMaxSalesCount($sales, 'day');

        $i = 0;

        foreach ($sales as $sale) {
            $salesTotal += $sale['day']['sales_total'];
            $salesCount += $sale['day']['sales_count'];
            // avoid division by zero
            if ($maxSale == 0) {
                $percentage = 0;
            } else {
                $percentage = ($sale['day']['sales_total'] / $maxSale) * 100;
            }
            $sales[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;

            // avoid division by zero
            if ($maxCount == 0) {
                $percentage = 0;
            } else {
                $percentage = ($sale['day']['sales_count'] / $maxCount) * 100;
            }
            $sales[$i]['percentage_count'] = ($percentage > 0) ? $percentage : 1;

            $i ++;
        }

        return compact('sales', 'salesTotal', 'salesCount');
    }

    public function salesLastFewMonths($numOfMonths, $courseId = 0, $trackingCode = '')
    {
        $sales = [];

        for ($i = 0; $i <= $numOfMonths; $i ++) {
            $month = date('m', strtotime("-$i month"));
            $year  = date('Y', strtotime("-$i month"));
            $label = $i . (($i > 1) ? ' months' : ' month') . ' ago';
            if ($i === 0) {
                $label = 'This month';
            }
            $sales[] = [
                'label'      => $label,
                'month_date' => $month,
                'year'       => $year,
                'month'      => $this->monthlySales($courseId, $month, $year, $trackingCode)
            ];
        }
        $salesTotal = 0;
        $salesCount = 0;

        $maxSale  = $this->_getMaxSalesValue($sales, 'month');
        $maxCount = $this->_getMaxSalesCount($sales, 'month');

        $i = 0;

        foreach ($sales as $sale) {
            $salesTotal += $sale['month']['sales_total'];
            $salesCount += $sale['month']['sales_count'];
            // avoid division by zero
            if ($maxSale == 0) {
                $percentage = 0;
            } else {
                $percentage = ($sale['month']['sales_total'] / $maxSale) * 100;
            }
            $sales[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;

            // avoid division by zero
            if ($maxCount == 0) {
                $percentage = 0;
            } else {
                $percentage = ($sale['month']['sales_count'] / $maxCount) * 100;
            }
            $sales[$i]['percentage_count'] = ($percentage > 0) ? $percentage : 1;

            $i ++;
        }

        return compact('sales', 'salesTotal', 'salesCount');
    }

    public function salesLastFewYears($numOfYears, $courseId = 0, $trackingCode = '')
    {
        $sales = [];

        for ($i = 0; $i <= $numOfYears; $i ++) {
            $year  = date('Y', strtotime("-$i year"));
            $label = $i . (($i > 1) ? ' years' : ' year') . ' ago';
            if ($i === 0) {
                $label = 'This year';
            }
            $sales[] = [
                'label'     => $label,
                'year_date' => $year,
                'year'      => $this->allTimeSales($courseId, $year, $trackingCode)
            ];
        }
        $salesTotal = 0;
        $salesCount = 0;

        $maxSale  = $this->_getMaxSalesValue($sales, 'year');
        $maxCount = $this->_getMaxSalesCount($sales, 'year');

        $i = 0;
        foreach ($sales as $sale) {
            $salesTotal += $sale['year']['sales_total'];
            $salesCount += $sale['year']['sales_count'];
            // avoid division by zero
            if ($maxSale == 0) {
                $percentage = 0;
            } else {
                $percentage = ($sale['year']['sales_total'] / $maxSale) * 100;
            }
            $sales[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;

            // avoid division by zero
            if ($maxCount == 0) {
                $percentage = 0;
            } else {
                $percentage = ($sale['year']['sales_count'] / $maxCount) * 100;
            }
            $sales[$i]['percentage_count'] = ($percentage > 0) ? $percentage : 1;

            $i ++;
        }

        return compact('sales', 'salesTotal', 'salesCount');
    }

    private function _getMaxSalesValue($sales, $frequency)
    {
        $max = 0;

        foreach ($sales as $sale) {
            if ($sale[$frequency]['sales_total'] > $max) {
                $max = $sale[$frequency]['sales_total'];
            }
        }

        return $max;
    }

    private function _getMaxSalesCount($sales, $frequency)
    {
        $max = 0;

        foreach ($sales as $sale) {
            if ($sale[$frequency]['sales_count'] > $max) {
                $max = $sale[$frequency]['sales_count'];
            }
        }

        return $max;
    }

    public function weeklySales($courseId, $dateFilterStart = '', $dateFilterEnd = '', $trackingCode = '')
    {
        if (empty($dateFilterStart)) {
            $dateFilterStart = $this->_frequencyEquivalence('week');
        }

        if (empty($dateFilterEnd)) {
            $dateFilterEnd = date('Y-m-d');
        }

        $filterQuery = "DATE(purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND purchases.product_id = '{$courseId}'";
        }

        if (!empty($trackingCode)) {
            $filterQuery .= " AND purchases.tracking_code = '{$trackingCode}'";
        }

        $query = $this->_salesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function monthlySales($courseId, $month = '', $year = '', $trackingCode = '')
    {
        if (empty($month)) {
            $month = date('m');
        }

        if (empty($year)) {
            $year = date('Y');
        }
        $filterQuery = "YEAR(purchases.created_at) = '{$year}' AND MONTH(purchases.created_at) = '{$month}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND purchases.product_id = '{$courseId}'";
        }

        if (!empty($trackingCode)) {
            $filterQuery .= " AND purchases.tracking_code = '{$trackingCode}'";
        }

        $query = $this->_salesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function allTimeSales($courseId, $year = '', $trackingCode = '')
    {
        if (empty($year)) {
            $year = date('Y');
        }
        $filterQuery = "YEAR(purchases.created_at) = '{$year}'";
        if (!empty($courseId)) {
            $filterQuery .= " AND purchases.product_id = '{$courseId}'";
        }

        if (!empty($trackingCode)) {
            $filterQuery .= " AND purchases.tracking_code = '{$trackingCode}'";
        }

        $query = $this->_salesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function courseDailySales($courseId, $date = '', $trackingCode = '')
    {
        if (empty($date)) {
            $date = date('Y-m-d');
        }
        $filterQuery = "DATE(purchases.created_at) = '{$date}'";
        if (!empty($courseId)) {
            $filterQuery .= " AND purchases.product_id = '{$courseId}'";
        }

        if (!empty($trackingCode)) {
            $filterQuery .= " AND purchases.tracking_code = '{$trackingCode}'";
        }

        $query = $this->_salesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function dailyTopCourses($courseId)
    {
        $dateFilter  = $this->_frequencyEquivalence();
        $filterQuery = "DATE(purchases.created_at) = '{$dateFilter}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND product_id = '{$courseId}'";
        }

        $query = $this->_purchaseRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function weeklyTopCourses($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd   = date('Y-m-d');

        $filterQuery = "DATE(purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND product_id = '{$courseId}'";
        }

        $query = $this->_purchaseRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function monthlyTopCourses($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd   = date('Y-m-d');

        $filterQuery = "DATE(purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND product_id = '{$courseId}'";
        }

        $query = $this->_purchaseRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function allTimeTopCourses($courseId)
    {
        $filterQuery = "";

        if (!empty($courseId)) {
            $filterQuery = " AND product_id = '{$courseId}'";
        }

        $query = $this->_purchaseRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function dailyTrackingCodes($courseId)
    {
        $dateFilter  = $this->_frequencyEquivalence();
        $filterQuery = "DATE(tracking_code_hits.created_at) = '{$dateFilter}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND course_id = '{$courseId}'";
        }

        $query = $this->_trackingCodesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function weeklyTrackingCodes($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd   = date('Y-m-d');

        $filterQuery = "DATE(tracking_code_hits.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND course_id = '{$courseId}'";
        }

        $query = $this->_trackingCodesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function monthlyTrackingCodes($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd   = date('Y-m-d');

        $filterQuery = "DATE(tracking_code_hits.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND course_id = '{$courseId}'";
        }

        $query = $this->_trackingCodesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function trackingCodesAll()
    {
        $query = $this->_trackingCodesRawQuery('', 0);

        return $this->_transformCoursePurchases($query);
    }

    public function allTimeTrackingCodes($courseId)
    {
        $filterQuery = "";

        if (!empty($courseId)) {
            $filterQuery = " course_id = '{$courseId}'";
        }
        $query = $this->_trackingCodesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function dailyHitsSales($courseId, $trackingCode)
    {
        $dateFilter  = $this->_frequencyEquivalence();
        $filterQuery = " AND DATE(created_at) = '{$dateFilter}'";


        $query = $this->_codeStatisticsRawQuery($courseId, $trackingCode, $filterQuery);

        return DB::select($query);
    }

    public function weeklyHitsSales($courseId, $trackingCode)
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd   = date('Y-m-d');

        $filterQuery = " AND DATE(created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        $query = $this->_codeStatisticsRawQuery($courseId, $trackingCode, $filterQuery);

        return DB::select($query);
    }

    public function monthlyHitsSales($courseId, $trackingCode)
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd   = date('Y-m-d');

        $filterQuery = " AND DATE(created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        $query = $this->_codeStatisticsRawQuery($courseId, $trackingCode, $filterQuery);

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
        $dateFilter  = $this->_frequencyEquivalence();
        $filterQuery = "DATE(cp.created_at) = '{$dateFilter}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND cp.product_id = '{$courseId}'";
        }

        $query = $this->_coursePurchaseConversionRawQuery($filterQuery);


        return $this->_transformCoursePurchaseConversion($query);
    }

    public function weeklyCourseConversion($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd   = date('Y-m-d');
        $filterQuery     = "DATE(cp.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND cp.product_id = '{$courseId}'";
        }

        $query = $this->_coursePurchaseConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function monthlyCourseConversion($courseId)
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd   = date('Y-m-d');
        $filterQuery     = "DATE(cp.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND cp.product_id = '{$courseId}'";
        }

        $query = $this->_coursePurchaseConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function allTimeCourseConversion($courseId = "")
    {
        $filterQuery = "";

        if (!empty($courseId)) {
            $filterQuery = "cp.product_id = '{$courseId}'";
        }
        $query = $this->_coursePurchaseConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function dailyTrackingCodeConversion($courseId = "")
    {
        $dateFilter  = $this->_frequencyEquivalence();
        $filterQuery = "DATE(cp.created_at) = '{$dateFilter}'";

        if (!empty($courseId)) {
            $filterQuery = "cp.product_id = '{$courseId}'";
        }

        $query = $this->_trackingCodeConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function weeklyTrackingCodeConversion($courseId = "")
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd   = date('Y-m-d');

        $filterQuery = "DATE(cp.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)) {
            $filterQuery = "cp.product_id = '{$courseId}'";
        }

        $query = $this->_trackingCodeConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function monthlyTrackingCodeConversion($courseId = "")
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd   = date('Y-m-d');

        $filterQuery = "DATE(cp.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)) {
            $filterQuery = "cp.product_id = '{$courseId}'";
        }

        $query = $this->_trackingCodeConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function allTimeTrackingCodeConversion($courseId = "")
    {
        $filterQuery = "";

        if (!empty($courseId)) {
            $filterQuery = "cp.product_id = '{$courseId}'";
        }

        $query = $this->_trackingCodeConversionRawQuery($filterQuery);

        return $this->_transformCoursePurchaseConversion($query);
    }

    public function purchasesLabelData($sales, $dates = [])
    {
        $labels = [];
        $data   = [];

        if (count($dates) == 0) {
            for ($i = 0; $i <= 7; $i ++) {
                $dates[] = date('F d, Y', strtotime(Input::get('startDate') . ' -' . $i . ' days'));
            }
        }

        foreach ($dates as $date) {
            $saleValue = 0;
            foreach ($sales['data'] as $sale) {
                $purchaseDate = date('F d, Y', strtotime($sale['created_at']));

                if ($purchaseDate == $date) {
                    $saleValue = $sale['total_purchase'];
                    break;
                }
            }

            $labels[] = $date;
            $data[]   = $saleValue;
        }


        $labels = array_reverse($labels);
        $data   = array_reverse($data);

        return compact('labels', 'data');
    }

    private function _transformCoursePurchases($query)
    {
        $result = DB::select($query);
        $result = array_map(function ($val) {
            return json_decode(json_encode($val), true);
        }, $result);
        $output = [
            'data'        => $result,
            'count'       => count($result),
            'sales_total' => array_sum(array_column($result, 'total_purchase')),
            'sales_count' => array_sum(array_column($result, 'total_count')),
        ];

        return $output;
    }

    private function _transformCoursePurchaseConversion($query)
    {
        $result = DB::select($query);
        $result = array_map(function ($val) {
            return json_decode(json_encode($val), true);
        }, $result);
        $output = [
            'data'  => $result,
            'count' => count($result)
        ];

        return $output;
    }


    private function _purchaseRawQuery($criteria = '', $type = 'Course')
    {


        if (!empty($criteria)) {
            $criteria = ' AND ' . $criteria;
        }

        if (!empty($type)) {
            $criteria .= " AND product_type='{$type}'";
        }

        if (!$this->isAdmin AND !empty($this->affiliateId)) {
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
        if (!empty($criteria)) {
            $criteria = ' AND ' . $criteria;
        }

        if (!$this->isAdmin AND !empty($this->affiliateId)) {
            //$criteria .= " AND (purchases.ltc_affiliate_id = '{$this->affiliateId}' OR purchases.product_affiliate_id = '{$this->affiliateId}' )";
            $criteria .= " AND (purchases.product_affiliate_id = '{$this->affiliateId}' )";

        }

        $sql = "SELECT created_at, SUM(purchases.purchase_price) as 'total_purchase', COUNT(purchases.id) as 'total_count'
                FROM purchases WHERE id <> 0
                {$criteria}
                GROUP BY DATE(created_at)
                ORDER BY created_at DESC
                ";

        return $sql;
    }

    private function _trackingCodesRawQuery($criteria = '', $limit = 10)
    {
        if (!empty($criteria)) {
            $criteria = ' AND ' . $criteria;
        }

        if (!$this->isAdmin AND !empty($this->affiliateId)) {
            $criteria .= " AND affiliate_id = '{$this->affiliateId}'";
        }

        $sql = "SELECT course_id, tracking_code, count(tracking_code) as 'count', courses.name as 'course_name'
                FROM tracking_code_hits
                JOIN courses ON courses.id = tracking_code_hits.course_id WHERE tracking_code_hits.id <> 0
                 {$criteria}
                GROUP BY course_id, tracking_code
                ";

        if ($limit > 0) {
            $sql .= " ORDER BY count DESC LIMIT {$limit}";
        }

        return $sql;
    }

    private function _coursePurchaseConversionRawQuery($criteria = '', $limit = 10)
    {

        if (!empty($criteria)) {
            $criteria = ' AND ' . $criteria;
        }

        $criteriaPurchase  = $criteria;
        $criteriaPurchase2 = $criteria;
        if (!$this->isAdmin AND !empty($this->affiliateId)) {
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

    public function trackingCodesByCourse($courseId, $startDate = '', $endDate = '')
    {
        $criteria = "cp.product_id = '$courseId'";
        if (!empty($startDate) AND !empty($endDate)) {
            $criteria .= " AND cp.created_at BETWEEN '{$startDate}' AND '{$endDate}'";
        }

        if (!empty($startDate) AND empty($endDate)) {
            $criteria .= " AND cp.created_at = '{$startDate}'";
        }
        $query = $this->_trackingCodeConversionRawQuery($criteria, 0);

        return $this->_transformCoursePurchaseConversion($query);
    }

    private function _trackingCodeConversionRawQuery($criteria = '', $limit = 10)
    {

        if (!empty($criteria)) {
            $criteria = ' AND ' . $criteria;
        }

        $criteriaPurchase  = $criteria;
        $criteriaPurchase2 = $criteria;
        if (!$this->isAdmin AND !empty($this->affiliateId)) {
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
                       SELECT SUM(purchases.purchase_price)
                      FROM purchases
                      WHERE purchases.tracking_code = cp.tracking_code
                      {$criteriaPurchase2}
                ) as 'purchases_total',
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
           ";

        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }

        return $sql;
    }

    private function _codeStatisticsRawQuery($courseId, $code, $criteria = '')
    {
        $sql = "SELECT (SELECT count(id) FROM tracking_code_hits WHERE tracking_code = '{$code}' AND course_id = '{$courseId}' {$criteria}) as 'hits',
			           (SELECT count(id) FROM purchases WHERE tracking_code = '{$code}' AND product_id = '{$courseId}' {$criteria}) as 'sales_count',
                       (SELECT sum(purchase_price) FROM purchases WHERE tracking_code = '{$code}' AND product_id = '{$courseId}' {$criteria}) as 'sales_total' ";

        return $sql;
    }




    public function affiliatesLastFewDays($affiliateId = 0, $numOfDays = 7)
    {
        $affiliates = [];

        for ($i = 0; $i <= $numOfDays; $i ++) {
            $day   = date('l', strtotime("-$i day"));
            $date  = date('Y-m-d', strtotime("-$i day"));
            $label = $day;
            if ($i === 0) {
                $label = 'Today';
            }
            $affiliates[] = [
                'label' => $label,
                'date'  => $date,
                'day'   => $this->dailyLtcRegistration($affiliateId, $date)
            ];
        }



        $affTotal = $this->_getAffiliatesTotal($affiliates, 'day');

        $i = 0;

        foreach ($affiliates as $aff) {
            // avoid division by zero
            if ($affTotal == 0) {
                $percentage = 0;
            } else {
                $percentage = ($aff['day']['affiliates_count'] / $affTotal) * 100;
            }

            $affiliates[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;
            $i ++;
        }

        return compact('affiliates', 'affTotal');
    }

    public function affiliatesLastFewWeeks($affiliateId, $numOfWeeks = 7)
    {
        $affiliates = [];

        for ($i = 0; $i <= $numOfWeeks; $i ++) {
            $start = date('Y-m-d', strtotime('-' . ($i + 1) . ' week'));
            $end   = date('Y-m-d', strtotime("-$i week"));
            $label = $i . (($i > 1) ? ' weeks' : ' week') . ' ago';
            if ($i === 0) {
                $label = 'This week';
            }
            $affiliates[] = [
                'label' => $label,
                'start' => $start,
                'end'   => $end,
                'week'  => $this->weeklyLtcRegistration($affiliateId, $start,$end)
            ];
        }

        $affTotal = $this->_getAffiliatesTotal($affiliates, 'week');

        $i = 0;

        foreach ($affiliates as $aff) {
            // avoid division by zero
            if ($affTotal == 0) {
                $percentage = 0;
            } else {
                $percentage = ($aff['week']['affiliates_count'] / $affTotal) * 100;
            }

            $affiliates[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;
            $i ++;
        }

        return compact('affiliates', 'affTotal');
    }

    public function affiliatesLastFewMonths($affiliateId, $numOfMonths = 7)
    {
        $affiliates = [];

        for ($i = 0; $i <= $numOfMonths; $i ++) {
            $month = date('m', strtotime("-$i month"));
            $year  = date('Y', strtotime("-$i month"));
            $label = $i . (($i > 1) ? ' months' : ' month') . ' ago';
            if ($i === 0) {
                $label = 'This month';
            }
            $affiliates[] = [
                'label'      => $label,
                'month_date' => $month,
                'year'       => $year,
                'month'      => $this->monthlyLtcRegistration($affiliateId,$month,$year)
            ];
        }
        $affTotal = $this->_getAffiliatesTotal($affiliates, 'month');

        $i = 0;

        foreach ($affiliates as $aff) {
            // avoid division by zero
            if ($affTotal == 0) {
                $percentage = 0;
            } else {
                $percentage = ($aff['month']['affiliates_count'] / $affTotal) * 100;
            }

            $affiliates[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;
            $i ++;
        }

        return compact('affiliates', 'affTotal');
    }

    public function affiliatesLastFewYears($affiliateId, $numOfYears = 7)
    {
        $affiliates = [];

        for ($i = 0; $i <= $numOfYears; $i ++) {
            $year  = date('Y', strtotime("-$i year"));
            $label = $i . (($i > 1) ? ' years' : ' year') . ' ago';
            if ($i === 0) {
                $label = 'This year';
            }
            $affiliates[] = [
                'label'     => $label,
                'year_date' => $year,
                'year'      => $this->allTimeLtcRegistration($affiliateId,$year)
            ];
        }

        $affTotal = $this->_getAffiliatesTotal($affiliates, 'year');

        $i = 0;

        foreach ($affiliates as $aff) {
            // avoid division by zero
            if ($affTotal == 0) {
                $percentage = 0;
            } else {
                $percentage = ($aff['year']['affiliates_count'] / $affTotal) * 100;
            }

            $affiliates[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;
            $i ++;
        }

        return compact('affiliates', 'affTotal');
    }

    private function _getAffiliatesTotal($affiliates, $frequency)
    {
        $totalAff = 0;

        foreach ($affiliates as $aff) {
                $totalAff += $aff[$frequency]['affiliates_count'];
        }

        return $totalAff;
    }


    private function _frequencyEquivalence($frequency = null)
    {
        if ($frequency == 'week') {
            return date('Y-m-d', strtotime('-1 week'));
        }
        if ($frequency == 'month') {
            return date('Y-m-d', strtotime('-1 month'));
        }

        return date('Y-m-d');
    }

    public static function frequencyReadable($frequency)
    {
        switch ($frequency) {
            case 'week':
                return trans('analytics.week');
            case 'month' :
                return trans('analytics.month');
            case 'alltime':
                return trans('analytics.alltime');
            default:
                return trans('analytics.today');
        }
    }

    public function chartColorCombo($index)
    {
        $colorCombo = [
            ['#787A40', '#9FBF8C', '#C8AB65'],
            ['#E8D0A9', '#B7AFA3', '#C1DAD6'],
            ['#FFFF66', '#FFCC00', '#FF9900'],
            ['#4F2412', '#C9A798', '#E9E0DB'],
            ['#999967', '#666666', '#CCCCCC'],
            ['#999967', '#666666', '#000000'],
        ];

        return $colorCombo[$index];
    }


}