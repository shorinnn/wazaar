<?php
class HomepageHelper{
    
    public static function generateVariations( $count = 8 ){
        $variations = [];
        for( $i = 0; $i< $count; ++$i ){
            $variations[] = self::topCourses();
        }
        return $variations;
    }
    
    public static function topCourses( $courseCount = 8 ){
        if( CourseConsolidatedPurchases::count()==0){
            Artisan::call('wazaar:consolidate-purchases');
        }
        $helper = new CourseHelper();
        $courses = [];
        $catCourses = [];
        $ids = [];
        
        // add the manually selected courses for homepage
        $picks = WazaarPicks::limit(11)->orderBy('order','ASC')->lists('course_id');
        if( count($picks)==0 ) $picks = [0];
        
        $featured = Course::whereIn('id',$picks)->get();
        
        foreach($featured as $course){
            $courses[] = self::_prep( $course->id, true );
            $ids[] = $course->id;
        }
        
        $maxLoops = 5;
        $i = 0;
        // try to fill the required course slot number
        do{
            // get random categories
            $categories = CourseCategory::limit($courseCount)->orderBy( DB::raw('RAND()') )->get();
            // get best sellers from this category
            foreach($categories as $cat){
                // store bestsellers in an array, so we can discard an already used course
                if( !isset($catCourses[$cat->id])){
                    $catCourses[$cat->id] = $helper->bestSellers($cat->slug, '24h')->toArray();
                }
                
                if( count( $catCourses[$cat->id] ) == 0 ) continue;
                $max = count( $catCourses[$cat->id] ) > 3 ? 3 : count( $catCourses[$cat->id] )-1;
                $rand =  rand(0, $max);
                // picked random course from top 3
                $selectedCourse = $catCourses[$cat->id][$rand]['course_id'];
                // skip, if this course already added
                if( in_array( $selectedCourse, $ids ) ) continue;
                
                // remove it from category array so it doesn't show up again
                unset( $catCourses[$cat->id][$rand] );
                $catCourses[$cat->id] = array_values($catCourses[$cat->id]);
                $courses[] = self::_prep( $selectedCourse );
                $ids[] = $selectedCourse;
            }
            ++$i;
            // if after 5 attempts we have missing slots, kill the loop to avoid infinite loop
            if($i>$maxLoops) break;
        }
        while( count($courses) < $courseCount );
        
        if( count($courses) > $courseCount) $courses = array_slice ($courses, 0, $courseCount);
        return $courses;
    }
    
    private static function _prep($id, $manual=false){
        $course = Course::find( $id );
        if($course ==null ) return null;
        $course->preview = url('splash/logo.png');
        if( $course->previewImage != null ) $course->preview = cloudfrontUrl( $course->previewImage->url );
        $course->discounted = 0;
        if( $course->isDiscounted() ) $course->discounted = $course->discount_saved;
        return $course->toArray();
    }

    
}