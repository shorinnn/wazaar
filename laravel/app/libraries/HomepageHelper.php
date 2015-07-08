<?php
class HomepageHelper{
    
    public static function generateVariations( $count = 8 ){
        $variations = [];
        for( $i = 0; $i< $count; ++$i ){
            $variations[] = self::topCourses();
        }
//        dd($variations);
        return $variations;
    }
    
    public static function topCourses( $courseCount = 8 ){
        if( CourseConsolidatedPurchases::count()==0){
            Artisan::call('wazaar:consolidate-purchases');
        }
        $helper = new CourseHelper();
        $courses = [];
        do{
            $categories = CourseCategory::limit($courseCount)->orderBy( DB::raw('RAND()') )->get();
            foreach($categories as $cat){
                $catCourse = $helper->bestSellers($cat->slug, '24h');
                $max = count($catCourse) > 3 ? 3 : count($catCourse)-1;
                $course = Course::find( $catCourse[ rand(0, $max) ]->course_id );
                $course->preview = url('splash/logo.png');
                if( $course->previewImage != null ) $course->preview = cloudfrontUrl( $course->previewImage->url );
                $course->discounted = 0;
                if( $course->isDiscounted() ){
                    $course->discounted = $course->discount_saved;
                }
                $courses[] = $course->toArray();
//                $courses[] = $catCourse[ rand(0, $max) ]->course_id;
            }
        }
        while( count($courses) < $courseCount );
        if( count($courses) > $courseCount) $courses = array_slice ($courses, 0, $courseCount);
        return $courses;
    }

    
}