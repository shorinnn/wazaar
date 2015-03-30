<?php
class AdminHelper
{

    public function userStats($frequency)
    {
        switch($frequency){
            case 'today' : return $this->_userPastFewDays();break;
            case 'week'  : return $this->_weeklyUsers();break;
            case 'month' : return $this->_monthlyUsers();break;
            case 'alltime' : return $this->_yearlyUsers();break;
        }
    }

    private function _userPastFewDays($numOfDays = 7)
    {
        $users = [];

        for ($i = 0; $i <= $numOfDays; $i++){
            $day = date('l',strtotime("-$i day"));
            $date = date('Y-m-d',strtotime("-$i day"));
            $label = $day;
            if ($i === 0){
                $label = 'Today';
            }

            $users[] = ['label' => $label, 'date' => $date, 'day' =>$this->_dailyUsers($date)];
        }

        $usersTotal = 0;
        $max = 0;
        $grandTotal = 0;
        //expects $max and $grandTotal during extraction
        extract($this->_getMaxCount($users,'day'));

        $i = 0;
        foreach($users as $user)
        {
            $usersTotal += $user['day']['total_users'];

            // avoid division by zero
            if ($max == 0) {
                $percentage = 0;
            } else {
                $percentage = ($user['day']['total_users'] / $grandTotal) * 100;
            }

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





    private function _weeklyUsers()
    {

    }

    private function _monthlyUsers()
    {

    }

    private function _yearlyUsers()
    {

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
}