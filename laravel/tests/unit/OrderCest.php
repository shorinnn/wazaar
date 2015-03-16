<?php
use \UnitTester;

class OrderCest{
    
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
    
    public function doStuff(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::first();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['balance_used'] = '100';
        $data['successData']['balance_transaction_id'] = '111';
        $I->assertNotEquals( false, $student->purchase($course, null, $data) );
    }
}