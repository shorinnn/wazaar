<?php 
use \FunctionalTester;

class ClassroomCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        $student = Student::where('username','student')->first();
        $lesson = Lesson::first();
        $student->purchase( $lesson->module->course );
    }

    public function seeNoCourse(FunctionalTester $I){
        $user = Student::where('username','mac')->first();
        $I->amLoggedAs($user);
        $I->amOnPage('/student/mycourses');
        $I->dontSee('Go To Dashboard');
    }   
    
    public function seePurchasedCourse(FunctionalTester $I){
        $user = Student::where('username','mac')->first();
        $lesson = Lesson::first();
        $user->purchase( $lesson->module->course );
        $I->amLoggedAs($user);
        $I->amOnPage('/student/mycourses');
        $I->see('Go To Dashboard');
    }
    
    public function goToCourseDash(FunctionalTester $I){
        $user = Student::where('username','mac')->first();
        $lesson = Lesson::first();
        $user->purchase( $lesson->module->course );
        $I->amLoggedAs($user);
        $I->amOnPage('/student/mycourses');
        $I->click('Go To Dashboard');
        $I->seeCurrentUrlEquals("/classroom/".$lesson->module->course->slug."/dashboard");
    }
    
    public function markLessonViewed(FunctionalTester $I){
        $user = Student::where('username','mac')->first();
        $lesson = Lesson::first();
        $I->assertTrue( $user->purchase( $lesson->module->course ) );
        $I->assertFalse( $user->isLessonViewed($lesson) );
        $I->amLoggedAs($user);
        $I->dontSeeRecord('viewed_lessons', ['student_id' => $user->id, 'lesson_id' => $lesson->id]);
        $I->amOnPage( action('ClassroomController@lesson', ['course'=>$lesson->module->course->slug, 'module' => $lesson->module->slug, 'lesson'=>$lesson->slug] ) );    
        
        $I->seeCurrentUrlEquals("/classroom/".$lesson->module->course->slug."/".$lesson->module->slug.'/'.$lesson->slug);
        $user = Student::where('username','mac')->first();
        $I->seeRecord('viewed_lessons', ['student_id' => $user->id, 'lesson_id' => $lesson->id]);
        $I->assertTrue( $user->isLessonViewed($lesson) );
    }
    
}