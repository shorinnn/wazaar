<?php
use \UnitTester;

class LessonCest{
    public function _before() {
        $this->setupDatabase();
    }
    public function __destruct()
    {
        \DB::disconnect();
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
        if( !Config::get('custom.short_desc_max_chars') ){
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
    
    public function setPriceZero(UnitTester $I){
        $module = Module::find(1);
        $lesson = new Lesson();
        $lesson->name = 'Test Lesson';
        $lesson->module_id = $module->id;
        $lesson->price = 0;
        $I->assertTrue( $lesson->save() );
    }
    
    public function setPrice500(UnitTester $I){
        $module = Module::find(1);
        $lesson = new Lesson();
        $lesson->name = 'Test Lesson';
        $lesson->module_id = $module->id;
        $lesson->price = 500;
        $I->assertTrue( $lesson->save() );
    }
     
    public function failSetPriceLessThan500(UnitTester $I){
        $module = Module::find(1);
        $lesson = new Lesson();
        $lesson->name = 'Test Lesson';
        $lesson->module_id = $module->id;
        $lesson->price = 499;
        $I->assertFalse( $lesson->save() );
    }
     
        
}