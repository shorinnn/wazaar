<?php 
use \FunctionalTester;

class ManageCourseCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
         Course::boot();
    }
//
//    public function createCourse(FunctionalTester $I){
//        $instructor = Instructor::where('username', 'instructor')->first();
//        $I->amLoggedAs($instructor);
//        $I->amOnPage('/courses/create');
//        $I->fillField(['name' => 'name'], 'Codecept Course');
//        $I->click('Create Course');
//        $I->seeRecord( 'courses', ['name'=>'Codecept Course'] );
//    }
//    
//    public function seeModule(FunctionalTester $I){
//        $instructor = Instructor::where('username', 'instructor')->first();
//        $I->amLoggedAs($instructor);
//        $I->amOnPage('courses/app-development/curriculum');
//        $I->see('Module <span class="module-order">1</span>');
//    }
//    
//    public function addModule(FunctionalTester $I){
//        $instructor = Instructor::where('username', 'instructor')->first();
//        $I->amLoggedAs($instructor);
//        $I->amOnPage('courses/app-development/curriculum');
//        $I->dontSee('Module <span class="module-order">2</span>');
//        $I->click('Add Module');
//        $I->see('Module <span class="module-order">2</span>');
//    }
//    
//    public function deleteModule(FunctionalTester $I){
//        $instructor = Instructor::where('username', 'instructor')->first();
//        $I->amLoggedAs($instructor);
//        $I->amOnPage('courses/app-development/curriculum');
//        $I->see('Module <span class="module-order">1</span>');
//        $I->click('delete-module-1');
//        $I->amOnPage('courses/app-development/curriculum');
//        $I->dontSee('Module <span class="module-order">1</span>');
//    }
    
    public function seeLesson(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/app-development/curriculum');
        $I->see('Lesson <span class="lesson-order">1</span>');
    }
    
    public function addLesson(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/app-development/curriculum');
        $I->dontSee('Lesson <span class="lesson-order">2</span>');
        $I->click('Add Lesson');
        $I->see('Lesson <span class="lesson-order">2</span>');
    }
    
    public function deleteLesson(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/app-development/curriculum');
        $I->see('Lesson <span class="lesson-order">1</span>');
        $I->click('delete-lesson-1');
        $I->amOnPage('courses/app-development/curriculum');
        $I->dontSee('Lesson <span class="lesson-order">2</span>');
    }
    
    public function seeBlock(){
        
    }
    
    public function deleteBlock(){
        
    }
    
    /**
     * Todo: tests above should fail for other users
     */
    
}