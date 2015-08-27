<?php
class AdminHelper
{

    public function userStats($frequency)
    {
        switch($frequency){
            case 'today' : return $this->_usersLastFewDays();break;
            case 'week'  : return $this->_usersLastFewWeeks();break;
            case 'month' : return $this->_usersLastFewMonths();break;
            case 'alltime' : return $this->salesLastFewYears();break;
        }
    }
    
    public function affiliateRank($affiliateID){
        $affiliates = $this->_topAffiliates('','total_sales DESC')->lists('product_affiliate_id');
        $index = array_search($affiliateID, $affiliates);
        if($index===false) return '-';
        return $index + 1;
    }

    public function topAffiliatesByInstructor($instructorId, $affiliateId = 0, $startDate = '', $endDate = '', $sortOrder = 0)
    {
        $filter = " AND (purchases.instructor_id = '{$instructorId}' OR purchases.second_tier_instructor_id='{$instructorId}')";

        if (!empty($affiliateId)){
            $filter .= " AND (purchases.product_affiliate_id = '{$affiliateId}' OR purchases.second_tier_affiliate_id = '{$affiliateId}')";
        }

        if (!empty($startDate) AND !empty($endDate)){
            $startDate =  date('Y-m-d',strtotime($startDate));
            $endDate =  date('Y-m-d',strtotime($endDate));
            $filter .= " AND purchases.created_at BETWEEN '{$startDate}' AND '{$endDate}'";
        }

        $sortOrders = [
            '',
            'total_sales ASC',
            'total_sales DESC',
            'sales_count ASC',
            'sales_count DESC',
        ];

        return $this->_topAffiliates($filter, $sortOrders[$sortOrder])->paginate(Config::get('wazaar.PAGINATION'));
    }

    public function topAffiliates($affiliateId = 0, $startDate = '', $endDate = '', $sortOrder = 0)
    {
        $filter = '';

        if (!empty($affiliateId)){
            $filter .= " AND purchases.product_affiliate_id = '{$affiliateId}'";
        }

        if (!empty($startDate) AND !empty($endDate)){
            $startDate =  date('Y-m-d',strtotime($startDate));
            $endDate =  date('Y-m-d',strtotime($endDate));
            $filter .= " AND purchases.created_at BETWEEN '{$startDate}' AND '{$endDate}'";
        }

        $sortOrders = [
            '',
            'total_sales ASC',
            'total_sales DESC',
            'sales_count ASC',
            'sales_count DESC',
        ];

        return $this->_topAffiliates($filter, $sortOrders[$sortOrder])->paginate(Config::get('wazaar.PAGINATION'));
    }
    
    public function courseRank($courseId, $categoryId){
        $courses = $this->topCourses('no', $categoryId, '','', false, 2)->lists('course_id');
        $index = array_search($courseId, $courses);
        if($index===false) return '-';
        return $index + 1;
    }

    public function topCourses($freeProduct = 'no', $categoryId = 0, $startDate = '', $endDate = '', $paginate = true, $sortOrder = 0)
    {
        $filter = '';

        if (!empty($categoryId)){
            $filter .= " AND courses.course_category_id = '{$categoryId}'";
        }

        if (!empty($startDate) AND !empty($endDate)){
            $startDate =  date('Y-m-d',strtotime($startDate));
            $endDate =  date('Y-m-d',strtotime($endDate));
            $filter .= " AND purchases.created_at BETWEEN '{$startDate}' AND '{$endDate}'";
        }

        $sortOrders = [
            '',
            'total_sales ASC',
            'total_sales DESC',
            'sales_count ASC',
            'sales_count DESC',
        ];

        $topCourses = $this->_topCourses($freeProduct, $filter, $sortOrders[$sortOrder]);


        if ($paginate) {
            return $topCourses->paginate(Config::get('wazaar.PAGINATION'));
        }
        else{
            return $topCourses;
        }
    }

    /**************************************** PRIVATE METHODS *********************************************************/

    private function _topCourses($freeProduct = 'no', $filter = '', $sortOrder = '')
    {
        if (empty($sortOrder)){
            $sortOrder = 'total_sales DESC, sales_count DESC';
        }

        return DB::table('purchases')
                ->select(
                            DB::raw("SUM(purchase_price) as total_sales"),
                            DB::raw("COUNT(purchases.id) as sales_count"),
                            'purchases.product_id as course_id',
                            'courses.name as course_name',
                            'courses.course_category_id',
                            'courses.slug',
                            'course_categories.name as category_name'
                        )
                ->join('courses', 'courses.id', '=', 'purchases.product_id')
                ->join('course_categories', 'course_categories.id' , '=', 'courses.course_category_id')
                ->whereRaw("purchases.`product_type` = 'Course' AND purchases.`free_product` = '{$freeProduct}' {$filter}")
                ->groupBy('purchases.product_id')
                ->orderByRaw($sortOrder);
    }

    private function _topAffiliates($filter = '', $sortOrder = '')
    {
        if (empty($sortOrder)){
            $sortOrder = 'total_sales DESC, sales_count DESC';
        }
        return  DB::table('purchases')
                ->select(
                          DB::raw("SUM(affiliate_earnings) as total_sales"),
                          DB::raw("COUNT(purchases.id) as sales_count"),
                         'product_affiliate_id',
                          DB::raw("CONCAT(`user_profiles`.last_name, ' ', user_profiles.first_name) as full_name"),
                         'users.username'
                        )
                ->join('users','users.id', '=', 'purchases.product_affiliate_id')
                ->join('user_profiles','user_profiles.owner_id', '=', 'users.id', 'LEFT')
                ->whereRaw("purchases.id <> 0 {$filter}")
                ->groupBy('product_affiliate_id', 'username')
                ->orderByRaw($sortOrder);
    }

    private function _usersLastFewDays($numOfDays = 7)
    {
        $users = [];

        for ($i = 0; $i <= $numOfDays; $i++){
            $day = date('l',strtotime("-$i day"));
            $date = date('Y-m-d',strtotime("-$i day"));
            $label =  trans('analytics.' . $day);// $day;
            if ($i === 0){
                $label = trans('analytics.today');// 'Today';
            }

            $users[] = ['label' => $label, 'date' => $date, 'today' =>$this->_dailyUsers($date)];
        }

        $usersTotal = 0;
        $max = 0;
        $grandTotal = 0;
        //expects $max and $grandTotal during extraction
        extract($this->_getMaxCount($users,'today'));

        $i = 0;
        foreach($users as $user)
        {
            $usersTotal += $user['today']['total_users'];

            // avoid division by zero
            if ($max == 0) {
                $percentage = 0;
            } else {
                $percentage = ($user['today']['total_users'] / $grandTotal) * 100;
            }

            $users[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;
            $i++;
        }
        return compact('users', 'usersTotal');
    }

    private function _usersLastFewWeeks($numOfWeeks = 7)
    {
        $users = [];

        for ($i = 0; $i <= $numOfWeeks; $i++){

            $startDate = date('Y-m-d',strtotime('-' . ($i+1) .  ' week'));
            $endDate = date('Y-m-d',strtotime("-$i week"));
            $label = trans('analytics.' .  $i . (($i > 1) ? 'Weeks' : 'Week') . 'Ago');// $i . ( ($i > 1) ? ' weeks' : ' week') . ' ago';

            if ($i === 0){
                $label = trans('analytics.thisWeek');
            }

            $users[] = ['label' => $label, 'start' => $startDate, 'end' => $endDate, 'week' =>$this->_weeklyUsers($startDate, $endDate)];
        }

        $usersTotal = 0;
        $max = 0;
        $grandTotal = 0;
        //expects $max and $grandTotal during extraction
        extract($this->_getMaxCount($users,'week'));

        $i = 0;
        foreach($users as $user)
        {
            $usersTotal += $user['week']['total_users'];

            // avoid division by zero
            if ($max == 0) {
                $percentage = 0;
            } else {
                $percentage = ($user['week']['total_users'] / $grandTotal) * 100;
            }

            $users[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;
            $i++;
        }
        return compact('users', 'usersTotal');
    }

    private function _usersLastFewMonths($numOfMonths = 7)
    {
        $users = [];

        for ($i = 0; $i <= $numOfMonths; $i++){
            $month = date('m',strtotime("-$i month"));
            $year = date('Y',strtotime("-$i month"));
            $label = trans('analytics.' .  $i . (($i > 1) ? 'Months' : 'Month') . 'Ago');
            if ($i === 0){
                $label = trans('analytics.thisMonth');// 'This month';
            }
            $users[] = ['label' => $label, 'month_date' => $month, 'year' => $year, 'month' =>$this->_monthlyUsers($year,$month)];
        }

        $usersTotal = 0;
        $max = 0;
        $grandTotal = 0;
        //expects $max and $grandTotal during extraction
        extract($this->_getMaxCount($users,'month'));

        $i = 0;



        foreach($users as $user){
            $usersTotal += $user['month']['total_users'];
            // avoid division by zero
            if($max === 0) $percentage = 0;
            else $percentage = ($user['month']['total_users'] / $max) * 100;
            $users[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;
            $i++;
        }


        return compact('users', 'usersTotal');
    }

    public function salesLastFewYears($numOfYears = 7)
    {
        $users = [];

        for ($i = 0; $i <= $numOfYears; $i++){
            $year = date('Y',strtotime("-$i year"));
            $label = trans('analytics.' .  $i . (($i > 1) ? 'Years' : 'Year') . 'Ago');
            if ($i === 0){
                $label = trans('analytics.thisYear');
            }
            $users[] = ['label' => $label, 'year' => $year, 'alltime' => $this->_yearlyUsers($year)];
        }

        $usersTotal = 0;
        $max = 0;
        $grandTotal = 0;
        //expects $max and $grandTotal during extraction
        extract($this->_getMaxCount($users,'alltime'));

        $i = 0;

        foreach($users as $user){
            $usersTotal += $user['alltime']['total_users'];
            // avoid division by zero
            if($max === 0) $percentage = 0;
            else $percentage = ($user['alltime']['total_users'] / $max) * 100;
            $users[$i]['percentage'] = ($percentage > 0) ? $percentage : 1;
            $i++;
        }


        return compact('users', 'usersTotal');
    }

    private function _dailyUsers($date)
    {
        $filter = " AND DATE(created_at) = '{$date}'";
        return $this->_userStatsData($filter);
    }

    private function _weeklyUsers($start, $end)
    {
        $filter = " AND DATE(created_at) BETWEEN '{$start}' AND '{$end}'";
        return $this->_userStatsData($filter);
    }

    private function _monthlyUsers($year, $month)
    {
        $filter = " AND YEAR(created_at) = '{$year}' AND MONTH(created_at) = '{$month}'";
        return $this->_userStatsData($filter);
    }

    private function _yearlyUsers($year)
    {
        $filter = " AND YEAR(created_at) = '{$year}'";
        return $this->_userStatsData($filter);
    }

    private function _getMaxCount($users,$frequency)
    {
        $max = 0;
        $grandTotal = 0;
        foreach($users as $user){

            if ($user[$frequency]['total_users'] > $max) {
                $max = $user[$frequency]['total_users'];
            }

            $grandTotal += $user[$frequency]['total_users'];
        }
        return compact('max', 'grandTotal');
    }

    private function _userStatsData($filter = '')
    {
        $sql = "SELECT count(id) as total_users, DATE(created_at) FROM users WHERE id <> 0 {$filter} group by DATE(created_at)";
        $users = DB::select($sql);

        return $this->_transformUserCount($users);
    }

    private function _datesInArrayByFrequency($frequency = '')
    {
        if ($frequency == 'today'){
            $frequency = 'day';
        }

        if ($frequency == 'alltime'){
            $frequency = 'year';
        }

        $dates = [];

        for ($i = 0; $i <=7; $i++){
            $dates[] = date('Y-m-d', strtotime("-{$i} {$frequency}"));
        }

        return $dates;
    }

    private function _transformUserCount($result)
    {
        $result = array_map(function($val)
        {
            return json_decode(json_encode($val), true);
        }, $result);
        $output = [
            'data' => $result,
            'count' => count($result),
            'total_users' => array_sum(array_column($result,'total_users'))
        ];

        return $output;
    }

    public static function sortOptions()
    {
        return [
          '0' => trans('admin.dashboard.sortOrder'),
          '1' => trans('admin.dashboard.salesTotalASC'),
          '2' => trans('admin.dashboard.salesTotalDESC'),
          '3' => trans('admin.dashboard.salesCountASC'),
          '4' => trans('admin.dashboard.salesCountDESC'),
        ];
    }
}