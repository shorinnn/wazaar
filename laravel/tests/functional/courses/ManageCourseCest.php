<?php 
use \FunctionalTester;

class ManageCourseCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
         Course::boot();
    }
    
    public function seeModule(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->see('Module <span class="module-order">1</span>');
    }
    
    public function addModule(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->seeNumberOfElements('#modules-list > li', 3);
        $I->click('Add Module');
        $I->seeNumberOfElements('#modules-list > li', 4);
    }
    
    public function addModuleAsAssigned(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $second_instructor = Instructor::where('username', 'second_instructor')->first();
        $course->assigned_instructor_id = $second_instructor->id;
        $I->assertTrue( $course->updateUniques() );
        $I->amLoggedAs($second_instructor);
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->seeNumberOfElements('#modules-list > li', 3);
        $I->click('Add Module');
        $I->seeNumberOfElements('#modules-list > li', 4);
    }
    
    public function deleteModule(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->see('Module <span class="module-order">1</span>');
        $I->click('delete-module-1');
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->dontSee('Module <span class="module-order">1</span>');
    }
    public function deleteModuleAsAssigned(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $second_instructor = Instructor::where('username', 'second_instructor')->first();
        $course->assigned_instructor_id = $second_instructor->id;
        $I->assertTrue( $course->updateUniques() );
        $I->amLoggedAs($second_instructor);
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->see('Module <span class="module-order">1</span>');
        $I->click('delete-module-1');
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->dontSee('Module <span class="module-order">1</span>');
    }
    
    public function seeLesson(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->see('Lesson <span class="lesson-order">1</span>');
    }
    
    public function addLesson(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->seeNumberOfElements('#lessons-holder-1 > li', 2);
        $I->click('Add Lesson');
        $I->seeNumberOfElements('#lessons-holder-1 > li', 3);
    }
    public function addLessonAsAssigned(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
         $second_instructor = Instructor::where('username', 'second_instructor')->first();
        $course->assigned_instructor_id = $second_instructor->id;
        $I->assertTrue( $course->updateUniques() );
        $I->amLoggedAs($second_instructor);
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->seeNumberOfElements('#lessons-holder-1 > li', 2);
        $I->click('Add Lesson');
        $I->seeNumberOfElements('#lessons-holder-1 > li', 3);
    }
    
    public function deleteLesson(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->see('Lesson <span class="lesson-order">1</span>');
        $I->click('delete-lesson-1');
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->dontSee('Lesson <span class="lesson-order">2</span>');
    }
    
    public function deleteLessonAsAssigned(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
         $second_instructor = Instructor::where('username', 'second_instructor')->first();
        $course->assigned_instructor_id = $second_instructor->id;
        $I->assertTrue( $course->updateUniques() );
        $I->amLoggedAs($second_instructor);
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->see('Lesson <span class="lesson-order">1</span>');
        $I->click('delete-lesson-1');
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
        $I->dontSee('Lesson <span class="lesson-order">2</span>');
    }
    

    
    public function deleteBlock(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $I->amLoggedAs($instructor);
        $I->seeRecord('blocks',['name'=>'Test Block']);
        $total = Block::where('lesson_id', 10)->count();
        $I->amOnAction('BlocksController@destroy',[ 'lesson_id'=>10, 'id'=>1 ]);
        $I->sendAjaxRequest('DELETE', '/lessons/blocks/10/1');
        $I->assertEquals( $total-1,  Block::where('lesson_id', 10)->count() );
    }
    
    public function deleteBlockAsAssigned(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $second_instructor = Instructor::where('username', 'second_instructor')->first();
        $course->assigned_instructor_id = $second_instructor->id;
        $I->assertTrue( $course->updateUniques() );
        $I->amLoggedAs($second_instructor);
        $I->seeRecord('blocks',['name'=>'Test Block']);
        $total = Block::where('lesson_id', 10)->count();
        $I->amOnAction('BlocksController@destroy',[ 'lesson_id'=>10, 'id'=>1 ]);
        $I->sendAjaxRequest('DELETE', '/lessons/blocks/10/1');
        $I->assertEquals( $total-1,  Block::where('lesson_id', 10)->count() );
    }
    
    public function failViewingCurriculum(FunctionalTester $I){
        $course = Course::where('name', 'App Development')->first();
        $instructor = Instructor::where('username', 'second_instructor')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/'.$course->slug.'/curriculum');
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
    
    public function seeDashboard(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $second_instructor = Instructor::where('username', 'second_instructor')->first();
        $course = Course::where('name', 'App Development')->first();
        $I->amLoggedAs($instructor);
        $I->amOnPage('courses/'.$course->slug.'/dashboard');
        $I->seeCurrentUrlEquals('/courses/'.$course->slug.'/dashboard');
    }
    
    public function seeDashboardAsAssigned(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $second_instructor = Instructor::where('username', 'second_instructor')->first();
        $course = Course::where('name', 'App Development')->first();
        $course->assigned_instructor_id = $second_instructor->id;
        $I->assertTrue( $course->updateUniques() );
        $I->amLoggedAs($second_instructor);
        $I->amOnPage('courses/'.$course->slug.'/dashboard');
        $I->seeCurrentUrlEquals('/courses/'.$course->slug.'/dashboard');
    }
    
    public function failSeeDashboardAsNotAssigned(FunctionalTester $I){
        $instructor = Instructor::where('username', 'instructor')->first();
        $second_instructor = Instructor::where('username', 'second_instructor')->first();
        $course = Course::where('name', 'App Development')->first();
        $I->amLoggedAs($second_instructor);
        $I->amOnPage('courses/'.$course->slug.'/dashboard');
        $I->dontSeeCurrentUrlEquals('/courses/'.$course->slug.'/dashboard');
    }
    
    
}