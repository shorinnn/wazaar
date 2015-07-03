<?php 
class CourseHelper {

    /**
     * @param null $category - The category ID or slug
     * @param string $timeFrame - AT = All Time, 24H = Last 24 Hours, 3D = 3 Days Ago, LW = Last Week, LM = Last Month
     * @param null $perPage - If paginated, set a numeric value to this
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\Paginator|static[]
     */
    public function bestSellers($category = null, $timeFrame = 'AT', $perPage = null)
    {
        $courses = null;

        switch ($timeFrame) {
            case '24H' : $courses = $this->getBestSellersLastTwentyFourHours(); break;
            case '3D'  : $courses = $this->getBestSellersLastThreeDays(); break;
            case 'LW'  : $courses = $this->getBestSellersLastWeek(); break;
            case 'LM'  : $courses = $this->getBestSellersLastMonth();  break;
            default: $courses = $this->_rawCoursesObject();
        }

        if (!empty($category)){
            if (is_string($category)){
                $courses = $courses->where('course_category_slug', $category);
            }
            else{
                $courses = $courses->where('course_category_id',$category);
            }

        }

        if (!empty($perPage)){
            return $courses->paginate($perPage);
        }

        return $courses->get();
    }

    private function _rawCoursesObject(){
        return CourseConsolidatedPurchases::where('id' , '<>',0)
            ->selectRaw('sum(purchase_price) as purchase_price, course_id')
            ->groupBy('course_id');
    }

    public function getBestSellersLastTwentyFourHours()
    {
        $courses = $this->_rawCoursesObject();

        $now = \Carbon\Carbon::now();
        $last24 = \Carbon\Carbon::now()->subHours(24);

        $condition = "purchase_date BETWEEN '{$last24}' AND '{$now}'";
        $courses = $courses->whereRaw($condition);

        return $courses;
    }

    public function getBestSellersLastThreeDays()
    {
        $courses = $this->_rawCoursesObject();

        $now = \Carbon\Carbon::now();
        $last3Days = \Carbon\Carbon::now()->subDays(3);

        $condition = "purchase_date BETWEEN '{$last3Days}' AND '{$now}'";
        $courses = $courses->whereRaw($condition);

        return $courses;
    }

    public function getBestSellersLastWeek()
    {
        $courses = $this->_rawCoursesObject();

        $now = \Carbon\Carbon::now();
        $lastWeek = \Carbon\Carbon::now()->subWeek(1);

        $condition = "purchase_date BETWEEN '{$lastWeek}' AND '{$now}'";
        $courses = $courses->whereRaw($condition);

        return $courses;
    }

    public function getBestSellersLastMonth()
    {
        $courses = $this->_rawCoursesObject();

        $now = \Carbon\Carbon::now();
        $lastMonth = \Carbon\Carbon::now()->subWeek(1);

        $condition = "purchase_date BETWEEN '{$lastMonth}' AND '{$now}'";
        $courses = $courses->whereRaw($condition);

        return $courses;
    }



}