<?php
use \UnitTester;

class ModuleCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        Module::boot();
    }
    
    public function addModuleToCourse(UnitTester $I){
        $course = Course::find(1);
        $module = new Module();
        $module->name = 'Test Module';
        $module->course_id = $course->id;
        $I->assertTrue( $module->save() );
    }
    
    public function getCourseDetails(UnitTester $I){
        $course = Course::find(1);
        $module = new Module();
        $module->name = 'Test Module';
        $module->course_id = $course->id;
        $module->save();
        $I->assertEquals(1, $module->course->id);
        $I->assertEquals('instructor', $module->course->instructor->username);
    }
    
    public function failAddingSameSlugToCourse(UnitTester $I){
        $course = Course::find(1);
        $module = new Module();
        $module->name = 'Test Module';
        $module->course_id = $course->id;
        $I->assertTrue( $module->save() );
        
        $course = Course::find(1);
        $module = new Module();
        $module->name = 'Test Module';
        $module->course_id = $course->id;
        $I->assertFalse( $module->save() );
    }
    
    public function addSameSlugToNewCourse(UnitTester $I){
        $course = Course::find(1);
        $module = new Module();
        $module->name = 'Test Module';
        $module->course_id = $course->id;
        $I->assertTrue( $module->save() );
        
        $course = Course::find(2);
        $module = new Module();
        $module->name = 'Test Module';
        $module->course_id = $course->id;
        $I->assertTrue( $module->save() );
    }
    
        
}