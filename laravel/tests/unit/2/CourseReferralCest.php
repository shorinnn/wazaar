<?php
use \UnitTester;

class CourseReferralCest{
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
        CourseReferral::boot();
    }
    
    public function createReferral(UnitTester $I){
        $recommendation = new CourseReferral( ['course_id' => 1, 'student_id' => 1, 'affiliate_id' => 1] );
        $recommendation->expires = date('Y-m-d H:i:s', strtotime('+30 day') );
        $I->assertTrue( $recommendation->save() );
    }
    
    public function failReferralIfNoExpiry(UnitTester $I){
        $recommendation = new CourseReferral( ['course_id' => 1, 'student_id' => 1, 'affiliate_id' => 1] );
        $I->assertFalse( $recommendation->save() );
    }
    
    public function failReferralInvalidIDs(UnitTester $I){
        $recommendation = new CourseReferral( ['course_id' => 999, 'student_id' => 999, 'affiliate_id' => 999] );
        $I->assertFalse( $recommendation->save() );
    }
    
    public function failSameReferralTwice(UnitTester $I){
        $recommendation = new CourseReferral( ['course_id' => 1, 'student_id' => 1, 'affiliate_id' => 1] );
        $recommendation->expires = date('Y-m-d H:i:s', strtotime('+30 day') );
        $I->assertTrue( $recommendation->save() );
        $recommendation = new CourseReferral( ['course_id' => 1, 'student_id' => 1, 'affiliate_id' => 1] );
        $recommendation->expires = date('Y-m-d H:i:s', strtotime('+30 day') );
        $I->assertFalse( $recommendation->save() );
    }
    
}
