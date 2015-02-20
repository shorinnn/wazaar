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
    
    public function buyLesson(FunctionalTester $I){
        $course = Course::where('name','Business App Development')->first();
        $user = User::where('username','mac')->first();
        $I->amLoggedAs($user);
        $I->amOnPage( action('CoursesController@show', $course->slug) );
        $I->dontSeeRecord( 'purchases', ['student_id' => $user->id, 'product_type' => 'Lesson'] );
        $I->click('CRASH LESSON');
        $I->seeRecord( 'purchases', ['student_id' => $user->id, 'product_type' => 'Lesson'] );
    }
    
    public function seeDisabledCrashAlreadyBoughtLesson(FunctionalTester $I){
        $course = Course::where('name','Business App Development')->first();
        $user = User::where('username','mac')->first();
        $I->amLoggedAs($user);
        $I->amOnPage( action('CoursesController@show', $course->slug) );
        $I->dontSee('data-crash-disabled');
        $I->dontSeeRecord( 'purchases', ['student_id' => $user->id, 'product_type' => 'Lesson'] );
        $I->click('CRASH LESSON');
        $I->seeRecord( 'purchases', ['student_id' => $user->id, 'product_type' => 'Lesson'] );
        $I->amOnPage( action('CoursesController@show', $course->slug) );
        $I->see('data-crash-disabled');
    }
    
    public function seeDisabledCrashAlreadyBoughtCourse(FunctionalTester $I){
        $course = Course::where('name','Business App Development')->first();
        $user = User::where('username','sorin')->first();
        $I->amLoggedAs($user);
        $I->seeRecord('purchases', [ 'student_id' => $user->id, 'product_type' => 'Course', 'product_id' => $course->id ] );
        $I->amOnPage( action('CoursesController@show', $course->slug) );
        $I->see('data-crash-disabled');
    }
    
    public function buyLessonAjax(FunctionalTester $I){
        $course = Course::where('name','Business App Development')->first();
        $user = User::where('username','mac')->first();
        $lesson = $course->modules()->first()->lessons()->first();
        $I->amLoggedAs($user);
        $I->dontSeeRecord( 'purchases', ['student_id' => $user->id, 'product_type' => 'Lesson'] );
        $I->sendAjaxPostRequest( action( 'CoursesController@purchaseLesson', [ $course->slug, $lesson->id ] ) );
        $I->seeRecord( 'purchases', ['student_id' => $user->id, 'product_type' => 'Lesson'] );
    }
    
    public function failBuyAlreadyBoughtAjax(FunctionalTester $I){
        $course = Course::where('name','Business App Development')->first();
        $user = User::where('username','mac')->first();
        $lesson = $course->modules()->first()->lessons()->first();
        $I->amLoggedAs($user);
        $I->dontSeeRecord( 'purchases', ['student_id' => $user->id, 'product_type' => 'Lesson'] );
        $I->sendAjaxPostRequest( action( 'CoursesController@purchaseLesson', [ $course->slug, $lesson->id ] ) );
        $I->seeRecord( 'purchases', [ 'student_id' => $user->id, 'product_type' => 'Lesson' ] );
        $I->sendAjaxPostRequest( action( 'CoursesController@purchaseLesson', [ $course->slug, $lesson->id ] ) );
        $I->assertEquals(1, Purchase::where('student_id', $user->id)->count() );
    }
    
    public function failBuyAlreadyBoughtCourseAjax(FunctionalTester $I){
        $user = Student::where('username','sorin')->first();
        $I->amLoggedAs($user);
        $course = Course::where('name','Business App Development')->first();
        $lesson = $course->modules()->first()->lessons()->first();
        $I->assertTrue( $user->purchased($course) );
        $I->dontSeeRecord( 'purchases', ['student_id' => $user->id, 'product_type' => 'Lesson'] );
        $I->sendAjaxPostRequest( action( 'CoursesController@purchaseLesson', [ $course->slug, $lesson->id ] ) );
        $I->dontSeeRecord( 'purchases', [ 'student_id' => $user->id, 'product_type' => 'Lesson' ] );
    }
    
}