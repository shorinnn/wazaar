<?php
use \UnitTester;

class CourseAssignedInstructorCest{
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
        Testimonial::boot();
    }
    
    public function addContent(UnitTester $I){
        $I->assertTrue( false );
    }

    
        
}