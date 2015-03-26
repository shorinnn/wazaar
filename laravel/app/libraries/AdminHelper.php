<?php
class AdminHelper
{

    public function userStats($filter = '')
    {
        $sql = "SELECT count(id) as total_users, DATE(created_at) FROM users WHERE id <> 0 {$filter} group by DATE(created_at)";
        return DB::statement($sql);
    }

    public function createdAtSQLFilter($frequency , $params = [])
    {
        switch ($frequency){
            case 'today':
                $date = date('Y-m-d');
                return " AND created_at ='{$date}'";
                break;
            case 'week':
            case 'month':
            case 'alltime':
                extract($params);
                return " AND created_at BETWEEN '{$startDate}' AND '{$endDate}'";
        }

        return null;
    }
}