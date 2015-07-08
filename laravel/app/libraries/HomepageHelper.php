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
                
                if( count( $catCourses[$cat->id] ) == 0) continue;
                $max = count( $catCourses[$cat->id] ) > 3 ? 3 : count( $catCourses[$cat->id] )-1;
                $rand =  rand(0, $max);
                // picked random course from top 3
                $selectedCourse = $catCourses[$cat->id][$rand]['course_id'];
                // remove it from category array so it doesn't show up again
                unset( $catCourses[$cat->id][$rand] );
                $catCourses[$cat->id] = array_values($catCourses[$cat->id]);
                
                
                $course = Course::find( $selectedCourse );
                $course->preview = url('splash/logo.png');
                if( $course->previewImage != null ) $course->preview = cloudfrontUrl( $course->previewImage->url );
                $course->discounted = 0;
                if( $course->isDiscounted() ) $course->discounted = $course->discount_saved;
                $courses[] = $course->toArray();
            }
            ++$i;
            // if after 5 attempts we have missing slots, kill the loop to avoid infinite loop
            if($i>$maxLoops) break;
        }
        while( count($courses) < $courseCount );
        
        if( count($courses) > $courseCount) $courses = array_slice ($courses, 0, $courseCount);
        return $courses;
    }

    
}