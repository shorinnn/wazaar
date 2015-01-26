<?php 
use \FunctionalTester;

class ManageCourseCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
         Course::boot();
    }
    
    public function seeModule(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/app-development/curriculum');
        $I->see('Module <span class="module-order">1</span>');
    }
    
    public function addModule(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/app-development/curriculum');
        $I->seeNumberOfElements('#modules-list > li', 3);
        $I->click('Add Module');
        $I->seeNumberOfElements('#modules-list > li', 4);
    }
    
    public function deleteModule(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/app-development/curriculum');
        $I->see('Module <span class="module-order">1</span>');
        $I->click('delete-module-1');
        $I->amOnPage('courses/app-development/curriculum');
        $I->dontSee('Module <span class="module-order">1</span>');
    }
    
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
        $I->seeNumberOfElements('#lessons-holder-1 > li', 2);
        $I->click('Add Lesson');
        $I->seeNumberOfElements('#lessons-holder-1 > li', 3);
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
    

    
    public function deleteBlock(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->seeRecord('blocks',['name'=>'Test Block']);
        $I->amOnAction('BlocksController@destroy',[ 'lesson_id'=>1, 'id'=>1 ]);
        $I->sendAjaxRequest('DELETE', '/lessons/blocks/1/1');
        $I->dontSeeRecord('blocks',['name'=>'Test Block']);
    }
    
    public function failViewingCurriculum(FunctionalTester $I){
        $instructor = Instructor::where('username', 'second_instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/app-development/curriculum');
        $I->seeCurrentUrlEquals('');
    }
    
     public function failAddingModule(FunctionalTester $I){
        $instructor = Instructor::where('username', 'second_instructor')->first();
        $I->amLoggedAs($instructor);
        $course = Course::find(1);
        $I->assertEquals(3, $course->modules()->count());
        $I->sendAjaxRequest('POST', 'blocks/1');
        $I->assertEquals(3, $course->modules()->count());
    }
    
    public function failDeletingModule(FunctionalTester $I){
        $instructor = Instructor::where('username', 'second_instructor')->first();
        $I->amLoggedAs($instructor);
        $course = Course::find(1);
        $I->assertEquals(3, $course->modules()->count());
        $I->sendAjaxRequest('DELETE', 'courses/1/modules/1');
        $I->assertEquals(3, $course->modules()->count());
    }
    
    
    public function failAddingLesson(FunctionalTester $I){
        $instructor = Instructor::where('username', 'second_instructor')->first();
        $I->amLoggedAs($instructor);
        $module = Module::find(1);
        $I->assertEquals(2, $module->lessons()->count());
        $I->sendAjaxRequest('POST', 'modules/1/lessons');
        $I->assertEquals(2, $module->lessons()->count());
    }
    
    public function failDeleteLesson(FunctionalTester $I){
        $instructor = Instructor::where('username', 'second_instructor')->first();
        $I->amLoggedAs($instructor);
        $module = Module::find(1);
        $I->assertEquals(2, $module->lessons()->count());
        $I->sendAjaxRequest('DELETE', 'modules/1/lessons/1');
        $I->assertEquals(2, $module->lessons()->count());
    }
    
    public function failDeleteBlock(FunctionalTester $I){
        $instructor = Instructor::where('username', 'second_instructor')->first();
        $I->amLoggedAs($instructor);
        $I->seeRecord('blocks',['name'=>'Test Block']);
        $I->amOnAction('BlocksController@destroy',[ 'lesson_id'=>1, 'id'=>1 ]);
        $I->sendAjaxRequest('DELETE', '/lessons/blocks/1/1');
        $I->seeRecord('blocks',['name'=>'Test Block']);
    }
}