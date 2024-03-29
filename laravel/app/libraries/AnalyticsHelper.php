<?php
use Carbon\Carbon;
class AnalyticsHelper
{

    protected $userId;
    protected $isAdmin;
    protected $userType;
    protected $user;
    const CACHE = 15;

    public function __construct($isAdmin, $userId = 0, $userType = '')
    {
        $this->isAdmin  = $isAdmin;
        $this->userId   = $userId;
        $this->userType = $userType;

        $this->user = User::find($userId);
    }

    public function getRegistrationsCount($startDate, $endDate)
    {
        $users = DB::table('users')
            ->select(
                DB::raw("DATE(created_at) as date"),
                DB::raw("sum(case `ltc_affiliate_id` when '{$this->userId}' then 1 else 0 end) as ltc_registrations"),
                DB::raw("sum(case `second_tier_affiliate_id` when '{$this->userId}' then 1 else 0 end) as second_tier_affs")
            )
            //->whereRaw("DATE(created_at) BETWEEN '{$startDate}' AND '{$endDate}'")
            ->where('ltc_affiliate_id', $this->userId)
            ->orWhere('second_tier_affiliate_id', $this->userId)
            ->groupBy(DB::raw("DATE(created_at)"));
        ;

        return $users->paginate(Config::get('wazaar.PAGINATION'));
    }

    public function getTopAffiliatesByCourse($courseId, $startDate, $endDate)
    {
        if (empty($sortOrder)){
            $sortOrder = 'total_sales DESC, sales_count DESC';
        }
        $result =  DB::table('purchases')
            ->select(
                DB::raw("SUM(affiliate_earnings) as total_sales"),
                DB::raw("COUNT(purchases.id) as sales_count"),
                'product_affiliate_id',
                DB::raw("CONCAT(`user_profiles`.last_name, ' ', user_profiles.first_name) as full_name"),
                'users.username',
                'users.email'
            )
            ->join('users','users.id', '=', 'purchases.product_affiliate_id')
            ->join('user_profiles','user_profiles.owner_id', '=', 'users.id', 'LEFT')
            ->where('free_product', 'no')
            ->where('product_id',$courseId)
            ->where('product_type','Course')
            ;

        if ($startDate && $endDate){
            $result = $result->whereRaw("DATE(purchases.created_at) BETWEEN '{$startDate}' AND '{$endDate}'");
        }

        return $result
            ->groupBy('product_affiliate_id', 'username')
            ->orderByRaw($sortOrder)
            ->get();
    }




    public function getCourseStats($courseId, $startDate = null, $endDate = null)
    {
        $stats = DB::table('purchases')
            ->select(
              DB::raw("count(id) as 'sales_count'"),
              DB::raw("COALESCE(sum(purchase_price),0) as 'sales_total'"),
              DB::raw("COALESCE(sum(`instructor_earnings`),0) as 'instructor_earnings'"),
              DB::raw("COALESCE(sum(`affiliate_earnings`),0) as 'affiliate_earnings'"),
              DB::raw("COALESCE(sum(`ltc_affiliate_earnings`),0) as 'ltc_affiliate_earnings'"),
              DB::raw("COALESCE(sum(`second_tier_affiliate_earnings`),0) as 'second_tier_affiliate_earnings'"),
              DB::raw("COALESCE(sum(`site_earnings`),0) as 'site_earnings'"),
              DB::raw("COALESCE(sum(`tax`),0) as 'tax'"),
              DB::raw("DATE(created_at) as 'date'")
            )
            ->where('product_type','Course')
            ->where('product_id',$courseId)
           // ->groupBy(DB::raw("DATE(created_at)"))
        ;

        if ($startDate && $endDate){
            $stats = $stats->whereRaw("DATE(created_at) BETWEEN '{$startDate}' AND '{$endDate}'");
        }

        return $stats->paginate(Config::get('wazaar.PAGINATION'));
    }

    public function getAffiliateSalesByDateRange($startDate, $endDate)
    {
        $sales = DB::table('purchases')
                ->select(
                    DB::raw("count(id) as 'sales_count'"),
                    DB::raw("sum(purchase_price) as 'sales_total'"),
                    DB::raw("sum(affiliate_earnings) as 'revenue'"),
                    DB::raw("sum(tax) as 'tax_total'"),
                    DB::raw("CASE `ltc_affiliate_id`
                            WHEN  '{$this->userId}' THEN sum(`ltc_affiliate_earnings`)
                            ELSE 0
                            END as
                            'ltc_earnings'"
                           ),
                    DB::raw("CASE `second_tier_affiliate_id`
                        WHEN '{$this->userId}' THEN sum(`second_tier_affiliate_earnings`)
                        ELSE 0
                        END
                        as 'second_tier_earnings'"
                           ),
                    DB::raw("DATE(created_at) as 'date'")
                )
                ->where('product_affiliate_id',$this->userId)
                ->where('free_product','no')
                ->whereRaw("DATE(created_at) BETWEEN '{$startDate}' AND '{$endDate}'")
                ->groupBy(DB::raw("DATE(created_at)"))

            ;
        /*$sql = "SELECT count(id) as 'sales_count',
                       sum(purchase_price) as 'sales_total',
                       sum(affiliate_earnings) as 'revenue',

                        CASE `ltc_affiliate_id`
                        WHEN  '{$this->userId}' THEN sum(`ltc_affiliate_earnings`)
                        ELSE 0
                        END as
                        'ltc_earnings',

                        CASE `second_tier_affiliate_id`
                        WHEN '{$this->userId}' THEN sum(`second_tier_affiliate_earnings`)
                        ELSE 0
                        END
                        as 'second_tier_earnings',

                        DATE(created_at) as 'date'

                FROM purchases
                WHERE `product_affiliate_id` = '{$this->userId}'
                AND free_product = 'no'
                AND DATE(created_at) BETWEEN '{$startDate}' AND '{$endDate}'
                GROUP BY 	DATE(created_at)";*/
        return $sales->paginate(Config::get('wazaar.PAGINATION'));
    }

    private function dailyLtcEarnings($affiliateId, $dateFilter = '')
    {
        if (empty($dateFilter)) {
            $dateFilter = $this->_frequencyEquivalence();
        }

        $filterQuery = " AND DATE(purchases.created_at) = '{$dateFilter}'";

        return $this->_affiliateEarnings($affiliateId, $filterQuery);
    }

    private function weeklyLtcEarnings($affiliateId, $dateFilterStart, $dateFilterEnd)
    {
        //$dateFilterStart = date('Y-m-d',strtotime($dateFilterStart . " +1 day"));
        $filterQuery = " AND DATE(purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        return $this->_affiliateEarnings($affiliateId, $filterQuery);
    }

    private function monthlyLtcEarnings($affiliateId, $month, $year)
    {
        $filterQuery = " AND MONTH(purchases.created_at) = '{$month}' AND YEAR(purchases.created_at) = '{$year}'";

        return $this->_affiliateEarnings($affiliateId, $filterQuery);
    }

    private function allTimeLtcEarnings($affiliateId, $year)
    {
        $filterQuery = " AND YEAR(purchases.created_at) = '{$year}'";

        return $this->_affiliateEarnings($affiliateId, $filterQuery);
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
        $dateFilterStart = $dateFilterStart;
        $filterQuery = " AND DATE(users.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";
        //echo $filterQuery . '<br/>';
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
        $sql    = "SELECT count(id) as affiliates_count FROM users WHERE ltc_affiliate_id = '{$affiliateId}' AND id <> 0 {$filter}";
        //echo $sql . '<br/>';
        //$result = Cache::remember('affiliates', self::CACHE, function() use($sql)
        //{
        //    return DB::select($sql);
        //});

        $result = DB::select($sql);

        $result = array_map(function ($val) {
            return json_decode(json_encode($val), true);
        }, $result);
        $output = [
            'data'             => $result,
            'count'            => count($result),
            'affiliates_count' => array_sum(array_column($result, 'affiliates_count')),
        ];

        return $output;
    }


    private function dailySecondAffiliateRegistration($affiliateId, $dateFilter = '')
    {
        if (empty($dateFilter)) {
            $dateFilter = $this->_frequencyEquivalence();
        }

        $filterQuery = " AND DATE(users.created_at) = '{$dateFilter}'";

        return $this->_secondAffiliates($affiliateId, $filterQuery);
    }

    private function weeklySecondAffiliateRegistration($affiliateId, $dateFilterStart, $dateFilterEnd)
    {
//        $dateFilterStart = date('Y-m-d',strtotime($dateFilterStart . " +1 day")); COMMENTING THIS BECAUSE RETURNS BAD NUMBERS!
        $filterQuery = " AND DATE(users.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        return $this->_secondAffiliates($affiliateId, $filterQuery);
    }

    private function monthlySecondAffiliateRegistration($affiliateId, $month, $year)
    {
        $filterQuery = " AND MONTH(users.created_at) = '{$month}' AND YEAR(users.created_at) = '{$year}'";

        return $this->_secondAffiliates($affiliateId, $filterQuery);
    }

    private function allTimeSecondAffiliateRegistration($affiliateId, $year)
    {
        $filterQuery = " AND YEAR(users.created_at) = '{$year}'";

        return $this->_secondAffiliates($affiliateId, $filterQuery);
    }

    private function _secondAffiliates($affiliateId, $filter = '')
    {
        $sql    = "SELECT count(id) as affiliates_count FROM users WHERE second_tier_affiliate_id = '{$affiliateId}' AND id <> 0 {$filter}";

        //echo $sql;
        //$result = Cache::remember('second_affiliates', self::CACHE, function() use($sql)
        //{
        //    return DB::select($sql);
        //});
        $result = DB::select($sql);

        $result = array_map(function ($val) {
            return json_decode(json_encode($val), true);
        }, $result);
        $output = [
            'data'             => $result,
            'count'            => count($result),
            'affiliates_count' => array_sum(array_column($result, 'affiliates_count')),
        ];

        return $output;
    }



    private function _affiliateEarnings($affiliateId, $filter = '')
    {
        $sql    = "SELECT sum(ltc_affiliate_earnings) as affiliates_earning FROM purchases WHERE ltc_affiliate_id = '{$affiliateId}' AND id <> 0 {$filter}";

        $result = DB::select($sql);
        //$result = Cache::remember('affiliate_earnings', self::CACHE, function() use($sql)
        //{
        //    return DB::select($sql);
        //});

        $result = array_map(function ($val) {
            return json_decode(json_encode($val), true);
        }, $result);
        $output = [
            'data'               => $result,
            'count'              => count($result),
            'affiliates_earning' => array_sum(array_column($result, 'affiliates_earning')),
        ];

        return $output;
    }

    public function topCourses($frequency = '', $courseId = '', $free = 'no')
    {
        switch ($frequency) {
            case 'daily' :
                return $this->dailyTopCourses($courseId,$free);
                break;
            case 'week':
                return $this->weeklyTopCourses($courseId,$free);
                break;
            case 'month':
                return $this->monthlyTopCourses($courseId,$free);
                break;
            case 'alltime' :
                return $this->allTimeTopCourses($courseId,$free);
                break;
            default:
                return $this->dailyTopCourses($courseId,$free);
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

    public function secondTierSalesLastFewDays($numOfDays, $courseId = 0, $trackingCode = '')
    {
        $sales = [];

        for ($i = 0; $i <= $numOfDays; $i ++) {
            $day   =  trans('analytics.' . date('l', strtotime("-$i day"))) ;
            $date  = date('Y-m-d', strtotime("-$i day"));
            $label = $day;
            if ($i === 0) {
                $label = trans('analytics.today');
            }
            $sales[] = [
                'label' => $label,
                'date'  => $date,
                'day'   => $this->dailySecondTierSales($courseId, $date, $trackingCode)
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

    public function secondTierSalesLastFewWeeks($numOfWeeks, $courseId = 0, $trackingCode = '')
    {
        $sales = [];

        for ($i = 0; $i <= $numOfWeeks; $i ++) {
            $start = date('Y-m-d', strtotime('-' . ($i + 1) . ' week'));
            $start = date('Y-m-d', strtotime($start . ' +1 day'));
            $end   = date('Y-m-d', strtotime("-$i week"));
            //$end   = date('Y-m-d', strtotime("-1 day"));
            $label = trans('analytics.' .  $i . (($i > 1) ? 'Weeks' : 'Week') . 'Ago');// $i . (($i > 1) ? ' weeks' : ' week') . ' ago';
            if ($i === 0) {
                $label = trans('analytics.thisWeek');// 'This week';
            }
            $sales[] = [
                'label' => $label,
                'start' => $start,
                'end'   => $end,
                'week'  => $this->weeklySecondTierSales($courseId, $start, $end, $trackingCode)
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

    public function secondTierSalesLastFewMonths($numOfMonths, $courseId = 0, $trackingCode = '')
    {
        $sales = [];

        for ($i = 0; $i <= $numOfMonths; $i ++) {
            $month = date('m', strtotime("-$i month"));
            $year  = date('Y', strtotime("-$i month"));
            $label =  trans('analytics.' .  $i . (($i > 1) ? 'Months' : 'Month') . 'Ago');
            if ($i === 0) {
                $label = trans('analytics.thisMonth');
            }
            $sales[] = [
                'label'      => $label,
                'month_date' => $month,
                'year'       => $year,
                'month'      => $this->monthlySecondTierSales($courseId, $month, $year, $trackingCode)
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

    public function secondTierSalesLastFewYears($numOfYears, $courseId = 0, $trackingCode = '')
    {
        $sales = [];

        for ($i = 0; $i <= $numOfYears; $i ++) {
            $year  = date('Y', strtotime("-$i year"));
            $label = trans('analytics.' .  $i . (($i > 1) ? 'Years' : 'Year') . 'Ago');
            if ($i === 0) {
                $label =  trans('analytics.thisYear');// 'This year';
            }
            $sales[] = [
                'label'     => $label,
                'year_date' => $year,
                'year'      => $this->allTimeSecondTierSales($courseId, $year, $trackingCode)
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

    public function salesLastFewDays($numOfDays, $courseId = 0, $trackingCode = '')
    {
        $sales = [];

        for ($i = 0; $i <= $numOfDays; $i ++) {
            $day   =  trans('analytics.' . date('l', strtotime("-$i day"))) ;
            $date  = date('Y-m-d', strtotime("-$i day"));
            $label = $day;
            if ($i === 0) {
                $label = trans('analytics.today');
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

    public function salesLastFewWeeks($numOfWeeks, $courseId = 0, $trackingCode = '')
    {
        $sales = [];

        for ($i = 0; $i <= $numOfWeeks; $i ++) {
            $start = date('Y-m-d', strtotime('-' . ($i + 1) . ' week'));
            $start = date('Y-m-d', strtotime($start . ' +1 day'));
            $end   = date('Y-m-d', strtotime("-$i week"));
            $label = trans('analytics.' .  $i . (($i > 1) ? 'Weeks' : 'Week') . 'Ago');// $i . (($i > 1) ? ' weeks' : ' week') . ' ago';
            if ($i === 0) {
                $label = trans('analytics.thisWeek');// 'This week';
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

    public function salesLastFewMonths($numOfMonths, $courseId = 0, $trackingCode = '')
    {
        $sales = [];

        for ($i = 0; $i <= $numOfMonths; $i ++) {
            $month = date('m', strtotime("-$i month"));
            $year  = date('Y', strtotime("-$i month"));
            $label =  trans('analytics.' .  $i . (($i > 1) ? 'Months' : 'Month') . 'Ago');
            if ($i === 0) {
                $label = trans('analytics.thisMonth');
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
            $label = trans('analytics.' .  $i . (($i > 1) ? 'Years' : 'Year') . 'Ago');
            if ($i === 0) {
                $label =  trans('analytics.thisYear');// 'This year';
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


    public function weeklySecondTierSales($courseId, $dateFilterStart = '', $dateFilterEnd = '', $trackingCode = '')
    {
        if (empty($dateFilterStart)) {
            $dateFilterStart = $this->_frequencyEquivalence('week');
        }

        if (empty($dateFilterEnd)) {
            $dateFilterEnd = date('Y-m-d');
        }
        //$dateFilterStart = date('Y-m-d',strtotime($dateFilterStart . " +1 day"));

        $filterQuery = "DATE(purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND purchases.product_id = '{$courseId}'";
        }

        if (!empty($trackingCode)) {
            $filterQuery .= " AND purchases.tracking_code = '{$trackingCode}'";
        }

        $query = $this->_secondTierSalesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function monthlySecondTierSales($courseId, $month = '', $year = '', $trackingCode = '')
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

        $query = $this->_secondTierSalesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function allTimeSecondTierSales($courseId, $year = '', $trackingCode = '')
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

        $query = $this->_secondTierSalesRawQuery($filterQuery);

        return $this->_transformCoursePurchases($query);
    }

    public function dailySecondTierSales($courseId, $date = '', $trackingCode = '')
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

        $query = $this->_secondTierSalesRawQuery($filterQuery);



        return $this->_transformCoursePurchases($query);
    }

    public function weeklySales($courseId, $dateFilterStart = '', $dateFilterEnd = '', $trackingCode = '')
    {
        if (empty($dateFilterStart)) {
            $dateFilterStart = $this->_frequencyEquivalence('week');
        }

        if (empty($dateFilterEnd)) {
            $dateFilterEnd = date('Y-m-d');
        }
        //$dateFilterStart = date('Y-m-d',strtotime($dateFilterStart . " +1 day"));

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

        //echo $query . '<br/>';

        return $this->_transformCoursePurchases($query);
    }



    public function dailyTopCourses($courseId, $free)
    {
        $dateFilter  = $this->_frequencyEquivalence();
        $filterQuery = "DATE(purchases.created_at) = '{$dateFilter}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND product_id = '{$courseId}'";
        }

        $query = $this->_purchaseRawQuery($filterQuery,'Course',$free);

        return $this->_transformCoursePurchases($query);
    }

    public function weeklyTopCourses($courseId, $free)
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd   = date('Y-m-d');

        //$dateFilterStart = date('Y-m-d',strtotime($dateFilterStart . " +1 day"));
        $filterQuery = "DATE(purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND product_id = '{$courseId}'";
        }

        $query = $this->_purchaseRawQuery($filterQuery,'Course',$free);

        return $this->_transformCoursePurchases($query);
    }

    public function monthlyTopCourses($courseId, $free)
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd   = date('Y-m-d');

        $filterQuery = "DATE(purchases.created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        if (!empty($courseId)) {
            $filterQuery .= " AND product_id = '{$courseId}'";
        }

        $query = $this->_purchaseRawQuery($filterQuery,'Course',$free);

        return $this->_transformCoursePurchases($query);
    }

    public function allTimeTopCourses($courseId, $free)
    {
        $filterQuery = "";

        if (!empty($courseId)) {
            $filterQuery = " AND product_id = '{$courseId}'";
        }

        $query = $this->_purchaseRawQuery($filterQuery,'Course',$free);

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

        //$dateFilterStart = date('Y-m-d',strtotime($dateFilterStart . " +1 day"));
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


        $sql = $this->_codeStatisticsRawQuery($courseId, $trackingCode, $filterQuery);

        //$result = Cache::remember('daily_hit_sales', self::CACHE, function() use($sql)
        //{
        //    return DB::select($sql);
        //});
        //return $result;
        return DB::select($sql);
    }

    public function weeklyHitsSales($courseId, $trackingCode)
    {
        $dateFilterStart = $this->_frequencyEquivalence('week');
        $dateFilterEnd   = date('Y-m-d');

        //$dateFilterStart = date('Y-m-d',strtotime($dateFilterStart . " +1 day"));
        $filterQuery = " AND DATE(created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        $sql = $this->_codeStatisticsRawQuery($courseId, $trackingCode, $filterQuery);

        //$result = Cache::remember('weekly_hits_sales', self::CACHE, function() use($sql)
        //{
        //    return DB::select($sql);
        //});

        //return $result;
        return DB::select($sql);
    }

    public function monthlyHitsSales($courseId, $trackingCode)
    {
        $dateFilterStart = $this->_frequencyEquivalence('month');
        $dateFilterEnd   = date('Y-m-d');

        $filterQuery = " AND DATE(created_at) BETWEEN '{$dateFilterStart}' AND '{$dateFilterEnd}'";

        $sql = $this->_codeStatisticsRawQuery($courseId, $trackingCode, $filterQuery);

        //$result = Cache::remember('monthly_hits_sales', self::CACHE, function() use($sql)
        //{
        //    return DB::select($sql);
        //});

        //return $result;
        return DB::select($sql);
    }

    public function allTimeHitsSales($courseId, $trackingCode)
    {
        $filterQuery = "";

        $sql = $this->_codeStatisticsRawQuery($courseId, $trackingCode, $filterQuery);

        $result = Cache::remember('alltime_hits_sales', self::CACHE, function() use($sql)
        {
            return DB::select($sql);
        });

        return $sql;
        //return DB::select($query);
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

    private function _transformCoursePurchases($sql)
    {
        $result = DB::select($sql);

        //$result = Cache::remember('course_purchases', self::CACHE, function() use($sql)
        //{
        //    return DB::select($sql);
        //});

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

    private function _transformCoursePurchaseConversion($sql)
    {
        $result = DB::select($sql);

        //$result = Cache::remember('course_purchase_conversion', self::CACHE, function() use($sql)
        //{
        //    return DB::select($sql);
        //});

        $result = array_map(function ($val) {
            return json_decode(json_encode($val), true);
        }, $result);
        $output = [
            'data'  => $result,
            'count' => count($result)
        ];

        return $output;
    }

    private function _purchaseRawQuery($criteria = '', $type = 'Course', $free = 'no')
    {


        if (!empty($criteria)) {
            $criteria = ' AND ' . $criteria;
        }

        if (!empty($type)) {
            $criteria .= " AND product_type='{$type}'";
        }
        $sum = "SUM(purchases.purchase_price)";
        //Sales for affiliates are taken from another column
        if ($this->userType == 'affiliate') {
            //$sum = "IF(product_affiliate_id = '{$this->userId}', sum(`affiliate_earnings`),0) + IF(second_tier_affiliate_id = '{$this->userId}',sum(second_tier_affiliate_earnings),0)";
            $sum = "sum(`affiliate_earnings`)";
            $criteria .= " AND purchases.product_affiliate_id = '{$this->userId}'";
        }
        elseif($this->userType == 'instructor'){
            //$sum = "IF(instructor_id = '{$this->userId}', sum(`instructor_earnings`),0) + IF(second_tier_instructor_id = '{$this->userId}',sum(second_tier_instructor_earnings),0)";
            $sum = "sum(`instructor_earnings`)";
            $criteria .= " AND purchases.instructor_id='{$this->userId}'";
        }

        //if (!$this->isAdmin AND !empty($this->userId)) {
            //$criteria .= " AND (purchases.ltc_affiliate_id = '{$this->userId}' OR purchases.product_affiliate_id = '{$this->userId}' )";
        //    $criteria .= " AND (purchases.product_affiliate_id = '{$this->userId}' )";
        //}

        $sql = "SELECT courses.id, courses.`name`, {$sum} as 'total_purchase', count(courses.id) as 'total_count'
                FROM purchases
                JOIN courses ON courses.id = purchases.product_id WHERE purchases.id <> 0
                AND courses.`free` = '{$free}'
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

        $sum = 'SUM(purchases.purchase_price)';
        $countCriteria = '';
        //Sales for affiliates are taken from another column
        if ($this->userType == 'affiliate') {

            //$sum = "IF(product_affiliate_id = '{$this->userId}', sum(`affiliate_earnings`),0) + IF(second_tier_affiliate_id = '{$this->userId}',sum(second_tier_affiliate_earnings),0)";
            $sum = "sum(`affiliate_earnings`)";
            $countCriteria = "AND  product_affiliate_id = '{$this->userId}'";
            $countCriteria = "(SELECT COUNT(purchases.id) FROM purchases WHERE id <> 0 {$countCriteria} {$criteria}) ";
            $criteria .= " AND (purchases.product_affiliate_id = '{$this->userId}')";
        }
        elseif($this->userType == 'instructor'){
            $sum = "sum(`instructor_earnings`)";
            $countCriteria = "COUNT(purchases.id)";
            $criteria .= " AND (purchases.instructor_id = '{$this->userId}')";
        }
        elseif($this->userType == 'admin'){
            $sum = "sum(`purchase_price`)";
            $countCriteria = "COUNT(purchases.id)";
            //$criteria .= " AND (purchases.instructor_id = '{$this->userId}')";
        }

        $sql = "SELECT created_at, {$sum} as 'total_purchase', {$countCriteria} as 'total_count'
                FROM purchases WHERE id <> 0
                {$criteria}
                GROUP BY DATE(created_at)
                ORDER BY created_at DESC
                ";
        //echo $sql;die;
        return $sql;
    }

    private function _secondTierSalesRawQuery($criteria = ''){

        if ($this->userType == 'instructor') {
            $sum = "sum(`second_tier_instructor_earnings`)";
            $whereColumn = "second_tier_instructor_id";
        }
        elseif ($this->userType == 'affiliate'){
            $sum = "sum(`second_tier_affiliate_earnings`)";
            $whereColumn = "second_tier_affiliate_id";
        }

        $sql = "SELECT created_at, {$sum} as 'total_purchase', COUNT(purchases.id) as 'total_count'
                FROM purchases WHERE {$whereColumn} = '{$this->userId}' AND
                {$criteria}
                GROUP BY DATE(created_at)
                ORDER BY created_at DESC
                ";
        //echo $sql . '<br/>';
        return $sql;
    }

    private function _trackingCodesRawQuery($criteria = '', $limit = 10)
    {
        if (!empty($criteria)) {
            $criteria = ' AND ' . $criteria;
        }

        $purchaseCriteria = '';

        if ($this->userType == 'affiliate') {
            $purchaseCriteria = " AND (product_affiliate_id = '{$this->userId}' OR second_tier_affiliate_id = '{$this->userId}')";
            $criteria .= " AND tracking_code_hits.affiliate_id='{$this->userId}'";
        }
        elseif ($this->userType == 'instructor'){
            $purchaseCriteria = " AND (instructor_id = '{$this->userId}' OR second_tier_instructor_id = '{$this->userId}')";
        }

        $sql = "SELECT course_id, tracking_code, count(tracking_code) as 'count', courses.name as 'course_name',
                (SELECT sum(purchase_price) FROM purchases WHERE tracking_code = tracking_code_hits.tracking_code {$purchaseCriteria}) as 'purchase_total',
                (SELECT count(purchase_price) FROM purchases WHERE tracking_code = tracking_code_hits.tracking_code {$purchaseCriteria}) as 'purchase_count'
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

        if ($this->userType == 'affiliate') {
            $criteria .= " AND (affiliate_id = '{$this->userId}')";
            $criteriaPurchase .= " AND (cp.product_affiliate_id = '{$this->userId}' OR cp.second_tier_affiliate_id = '{$this->userId}')";
            $criteriaPurchase2 .= " AND (purchases.product_affiliate_id = '{$this->userId}' OR purchases.second_tier_affiliate_id = '{$this->userId}')";
        }
        elseif ($this->userType == 'instructor'){
            //$purchaseCriteria = " AND (instructor_id = '{$this->userId}' OR second_tier_instructor_id = '{$this->userId}')";
            $criteria .= " AND (affiliate_id = '{$this->userId}')";
            $criteriaPurchase .= " AND (cp.instructor_id = '{$this->userId}' OR cp.second_tier_instructor_id = '{$this->userId}')";
            $criteriaPurchase2 .= " AND (purchases.instructor_id = '{$this->userId}' OR purchases.second_tier_instructor_id = '{$this->userId}')";
        }

        /*if (!$this->isAdmin AND !empty($this->userId)) {
            $criteria .= " AND affiliate_id = '{$this->userId}'";
            $criteriaPurchase .= " AND cp.product_affiliate_id = '{$this->userId}'";
            $criteriaPurchase2 .= " AND purchases.product_affiliate_id = '{$this->userId}'";
        }*/

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

        if ($this->userType == 'affiliate') {
            $criteria .= " AND (affiliate_id = '{$this->userId}')";
            $criteriaPurchase .= " AND (cp.product_affiliate_id = '{$this->userId}' OR cp.second_tier_affiliate_id = '{$this->userId}')";
            $criteriaPurchase2 .= " AND (purchases.product_affiliate_id = '{$this->userId}' OR purchases.second_tier_affiliate_id = '{$this->userId}')";
        }
        elseif ($this->userType == 'instructor'){
            $criteria .= " AND (affiliate_id = '{$this->userId}')";
            $criteriaPurchase .= " AND (cp.instructor_id = '{$this->userId}' OR cp.second_tier_instructor_id = '{$this->userId}')";
            $criteriaPurchase2 .= " AND (purchases.instructor_id = '{$this->userId}' OR purchases.second_tier_instructor_id = '{$this->userId}')";
        }

        /*if (!$this->isAdmin AND !empty($this->userId)) {
            $criteria .= " AND affiliate_id = '{$this->userId}'";
            $criteriaPurchase .= " AND (cp.ltc_affiliate_id = '{$this->userId}' OR cp.product_affiliate_id = '{$this->userId}' )";
            $criteriaPurchase2 .= " AND (purchases.ltc_affiliate_id = '{$this->userId}' OR purchases.product_affiliate_id = '{$this->userId}' )";
        }*/

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

    public function affiliateEarningsLastFewDays($affiliateId = 0, $numOfDays = 7)
    {
        $affiliates = [];

        for ($i = 0; $i <= $numOfDays; $i ++) {
            $day   = trans('analytics.' . date('l', strtotime("-$i day"))) ;//date('l', strtotime("-$i day"));
            $date  = date('Y-m-d', strtotime("-$i day"));
            $label = $day;
            if ($i === 0) {
                $label = trans('analytics.today');
            }
            $affiliates[] = [
                'label' => $label,
                'date'  => $date,
                'day'   => $this->dailyLtcEarnings($affiliateId, $date)
            ];
        }


        $affTotal = $this->_getAffiliateEarningsTotal($affiliates, 'day');

        $i = 0;

        foreach ($affiliates as $aff) {
            // avoid division by zero
            if ($affTotal == 0) {
                $percentage = 0;
            } else {
                $percentage = ($aff['day']['affiliates_earning'] / $affTotal) * 100;
            }

            $affiliates[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;
            $i ++;
        }

        return compact('affiliates', 'affTotal');
    }

    public function affiliateEarningsLastFewWeeks($affiliateId, $numOfWeeks = 7)
    {
        $affiliates = [];

        for ($i = 0; $i <= $numOfWeeks; $i ++) {
            $start = date('Y-m-d', strtotime('-' . ($i + 1) . ' week'));
            $start = date('Y-m-d', strtotime($start . ' +1 day'));
            $end   = date('Y-m-d', strtotime("-$i week"));
            $label = trans('analytics.' .  $i . (($i > 1) ? 'Weeks' : 'Week') . 'Ago'); //$i . (($i > 1) ? ' weeks' : ' week') . ' ago';
            if ($i === 0) {
                $label = trans('analytics.thisWeek');// 'This week';
            }
            $affiliates[] = [
                'label' => $label,
                'start' => $start,
                'end'   => $end,
                'week'  => $this->weeklyLtcEarnings($affiliateId, $start, $end)
            ];
        }

        $affTotal = $this->_getAffiliateEarningsTotal($affiliates, 'week');

        $i = 0;

        foreach ($affiliates as $aff) {
            // avoid division by zero
            if ($affTotal == 0) {
                $percentage = 0;
            } else {
                $percentage = ($aff['week']['affiliates_earning'] / $affTotal) * 100;
            }

            $affiliates[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;
            $i ++;
        }

        return compact('affiliates', 'affTotal');
    }

    public function affiliateEarningsLastFewMonths($affiliateId, $numOfMonths = 7)
    {
        $affiliates = [];

        for ($i = 0; $i <= $numOfMonths; $i ++) {
            $month = date('m', strtotime("-$i month"));
            $year  = date('Y', strtotime("-$i month"));
            $label = trans('analytics.'. $i . (($i > 1) ? 'Months' : 'Month') . 'Ago');// $i . (($i > 1) ? ' months' : ' month') . ' ago';
            if ($i === 0) {
                $label = trans('analytics.thisMonth');// 'This month';
            }
            $affiliates[] = [
                'label'      => $label,
                'month_date' => $month,
                'year'       => $year,
                'month'      => $this->monthlyLtcEarnings($affiliateId, $month, $year)
            ];
        }
        $affTotal = $this->_getAffiliateEarningsTotal($affiliates, 'month');

        $i = 0;

        foreach ($affiliates as $aff) {
            // avoid division by zero
            if ($affTotal == 0) {
                $percentage = 0;
            } else {
                $percentage = ($aff['month']['affiliates_earning'] / $affTotal) * 100;
            }

            $affiliates[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;
            $i ++;
        }

        return compact('affiliates', 'affTotal');
    }

    public function affiliateEarningsLastFewYears($affiliateId, $numOfYears = 7)
    {
        $affiliates = [];

        for ($i = 0; $i <= $numOfYears; $i ++) {
            $year  = date('Y', strtotime("-$i year"));
            $label = trans('analytics.'. $i . (($i > 1) ? 'Years' : 'Year') . 'Ago');

            if ($i === 0) {
                $label = trans('analytics.thisYear');// 'This year';
            }
            $affiliates[] = [
                'label'     => $label,
                'year_date' => $year,
                'year'      => $this->allTimeLtcEarnings($affiliateId, $year)
            ];
        }

        $affTotal = $this->_getAffiliateEarningsTotal($affiliates, 'year');

        $i = 0;

        foreach ($affiliates as $aff) {
            // avoid division by zero
            if ($affTotal == 0) {
                $percentage = 0;
            } else {
                $percentage = ($aff['year']['affiliates_earning'] / $affTotal) * 100;
            }

            $affiliates[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;
            $i ++;
        }

        return compact('affiliates', 'affTotal');
    }

    private function _getAffiliateEarningsTotal($affiliates, $frequency)
    {
        $totalAff = 0;

        foreach ($affiliates as $aff) {
            $totalAff += $aff[$frequency]['affiliates_earning'];
        }

        return $totalAff;
    }

    public function affiliatesLastFewDays($affiliateId = 0, $numOfDays = 7)
    {
        $affiliates = [];

        for ($i = 0; $i <= $numOfDays; $i ++) {
            $day   = trans('analytics.' . date('l', strtotime("-$i day"))) ;//date('l', strtotime("-$i day"));
            $date  = date('Y-m-d', strtotime("-$i day"));
            $label = $day;
            if ($i === 0) {
                $label = trans('analytics.today');
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
            $start = date('Y-m-d', strtotime($start . ' +1 day'));
            $end   = date('Y-m-d', strtotime("-$i week"));
            $label = trans('analytics.' .  $i . (($i > 1) ? 'Weeks' : 'Week') . 'Ago'); // $i . (($i > 1) ? ' weeks' : ' week') . ' ago';
            if ($i === 0) {
                $label = trans('analytics.thisWeek');
            }
            $affiliates[] = [
                'label' => $label,
                'start' => $start,
                'end'   => $end,
                'week'  => $this->weeklyLtcRegistration($affiliateId, $start, $end)
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
            $label = trans('analytics.'. $i . (($i > 1) ? 'Months' : 'Month') . 'Ago');
            if ($i === 0) {
                $label = trans('analytics.thisMonth');
            }
            $affiliates[] = [
                'label'      => $label,
                'month_date' => $month,
                'year'       => $year,
                'month'      => $this->monthlyLtcRegistration($affiliateId, $month, $year)
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
            $label = trans('analytics.'. $i . (($i > 1) ? 'Years' : 'Year') . 'Ago');
            if ($i === 0) {
                $label = trans('analytics.thisYear');// 'This year';
            }
            $affiliates[] = [
                'label'     => $label,
                'year_date' => $year,
                'year'      => $this->allTimeLtcRegistration($affiliateId, $year)
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
    public function secondAffiliatesLastFewDays($affiliateId = 0, $numOfDays = 7)
    {
        $affiliates = [];

        for ($i = 0; $i <= $numOfDays; $i ++) {
            $day   = trans('analytics.' . date('l', strtotime("-$i day"))) ;//date('l', strtotime("-$i day"));
            $date  = date('Y-m-d', strtotime("-$i day"));
            $label = $day;
            if ($i === 0) {
                $label = trans('analytics.today');
            }
            $affiliates[] = [
                'label' => $label,
                'date'  => $date,
                'day'   => $this->dailySecondAffiliateRegistration($affiliateId, $date)
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

    public function secondAffiliatesLastFewWeeks($affiliateId, $numOfWeeks = 7)
    {
        $affiliates = [];

        for ($i = 0; $i <= $numOfWeeks; $i ++) {
            $start = date('Y-m-d', strtotime('-' . ($i + 1) . ' week'));
            $start = date('Y-m-d', strtotime($start . ' +1 day'));
            $end   = date('Y-m-d', strtotime("-$i week"));
            $label = trans('analytics.' .  $i . (($i > 1) ? 'Weeks' : 'Week') . 'Ago'); // $i . (($i > 1) ? ' weeks' : ' week') . ' ago';
            if ($i === 0) {
                $label = trans('analytics.thisWeek');
            }
            $affiliates[] = [
                'label' => $label,
                'start' => $start,
                'end'   => $end,
                'week'  => $this->weeklySecondAffiliateRegistration($affiliateId, $start, $end)
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

    public function secondAffiliatesLastFewMonths($affiliateId, $numOfMonths = 7)
    {
        $affiliates = [];

        for ($i = 0; $i <= $numOfMonths; $i ++) {
            $month = date('m', strtotime("-$i month"));
            $year  = date('Y', strtotime("-$i month"));
            $label = trans('analytics.'. $i . (($i > 1) ? 'Months' : 'Month') . 'Ago');
            if ($i === 0) {
                $label = trans('analytics.thisMonth');
            }
            $affiliates[] = [
                'label'      => $label,
                'month_date' => $month,
                'year'       => $year,
                'month'      => $this->monthlySecondAffiliateRegistration($affiliateId, $month, $year)
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

    public function secondAffiliatesLastFewYears($affiliateId, $numOfYears = 7)
    {
        $affiliates = [];

        for ($i = 0; $i <= $numOfYears; $i ++) {
            $year  = date('Y', strtotime("-$i year"));
            $label = trans('analytics.'. $i . (($i > 1) ? 'Years' : 'Year') . 'Ago');
            if ($i === 0) {
                $label = trans('analytics.thisYear');// 'This year';
            }
            $affiliates[] = [
                'label'     => $label,
                'year_date' => $year,
                'year'      => $this->allTimeSecondAffiliateRegistration($affiliateId, $year)
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

    public static function getQueryStringParams($frequency, $data)
    {
        if ($frequency == 'week'){
            return 'start=' . $data['start'] .'&end=' . $data['end'];
        }
        elseif($frequency == 'month'){
            return 'month=' . $data['month_date'] . '&year=' . $data['year'];
        }
        elseif($frequency == 'alltime'){
            return 'year=' . $data['year_date'];
        }
        else{
            return 'date=' . $data['date'];
        }
    }

    public static function fillObjectWithDates($startDate, $endDate, $object, $dateField = 'created_at')
    {
        $sd = new Carbon($startDate);// Carbon($startDate);
        $ed = new Carbon($endDate);

        $diffInDays = $sd->diffInDays($ed);

        $filledObject = [];
        for ($i = 0; $i<$diffInDays; $i++){

        }

    }


}