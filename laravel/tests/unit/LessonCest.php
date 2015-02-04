<?php
use \UnitTester;

class LessonCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        Lesson::boot();
    }
    
    public function addLessonToModule(UnitTester $I){
        $module = Module::find(1);
        $lesson = new Lesson();
        $lesson->name = 'Test Lesson';
        $lesson->module_id = $module->id;
        $I->assertTrue( $lesson->save() );
    }
    
    public function geModuleDetails(UnitTester $I){
        $module = Module::find(1);
        $lesson = new Lesson();
        $lesson->name = 'Test Lesson';
        $lesson->module_id = $module->id;
        $I->assertTrue( $lesson->save() );
        $I->assertEquals(1, $lesson->module->id);
        $I->assertEquals('instructor', $lesson->module->course->instructor->username);
    }
    
    public function failAddingSameSlugToModule(UnitTester $I){
        $module = Module::find(1);
        $lesson = new Lesson();
        $lesson->name = 'Test Lesson';
        $lesson->module_id = $module->id;
        $I->assertTrue( $lesson->save() );
        
        $module = Module::find(1);
        $lesson = new Lesson();
        $lesson->name = 'Test Lesson';
        $lesson->module_id = $module->id;
        $I->assertFalse( $lesson->save() );
    }
    
    public function addSameSlugToNewModule(UnitTester $I){
        $module = Module::find(1);
        $lesson = new Lesson();
        $lesson->name = 'Test Lesson';
        $lesson->module_id = $module->id;
        $I->assertTrue( $lesson->save() );
        
        $module = Module::find(2);
        $lesson = new Lesson();
        $lesson->name = 'Test Lesson';
        $lesson->module_id = $module->id;
        $I->assertTrue( $lesson->save() );
    }
     
        
}