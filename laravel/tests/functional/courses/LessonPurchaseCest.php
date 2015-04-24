<?php 
use \FunctionalTester;

class LessonPurchaseCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        Purchase::boot();
    }

    public function seeCrashLessonButton(FunctionalTester $I){
        $course = Course::where('name','Business App Development')->first();
        $I->amOnPage( action('CoursesController@show', $course->slug) );
        $I->see('crash-lesson-button');
    }
    
    
    public function seeDisabledCrashAlreadyBoughtLesson(FunctionalTester $I){
        Db::table('lessons')->update( ['price'=>1] );
        $course = Course::where('name','Business App Development')->orderBy('id','asc')->first();
        $user = Student::where('username','mac')->first();
        Purchase::where('student_id', $user->id)->delete();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['ORDERID'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['giftID'] = null;
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $lesson = Lesson::find(10);
        $I->dontSeeRecord( 'purchases', ['student_id' => $user->id, 'product_type' => 'Lesson'] );
        
        $user->purchase($lesson, null, $data);
        $I->seeRecord( 'purchases', ['student_id' => $user->id, 'product_type' => 'Lesson'] );
        
        $I->amLoggedAs($user);
        $I->amOnPage( action('CoursesController@show', $course->slug) );
        $I->see('data-crash-disabled');
    }
    
    public function seeDisabledCrashAlreadyBoughtCourse(FunctionalTester $I){
        Db::table('lessons')->update( ['price'=>1] );
        $course = Course::where('name','Business App Development')->first();
        $user = User::where('username','sorin')->first();
        $I->amLoggedAs($user);
        $I->seeRecord('purchases', [ 'student_id' => $user->id, 'product_type' => 'Course', 'product_id' => $course->id ] );
        $I->amOnPage( action('CoursesController@show', $course->slug) );
        $I->see('data-crash-disabled');
    }
    
}