<?php
use \UnitTester;

class InstructorAgencyCest{
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
        InstructorAgency::boot();
    }
  
    public function createAgency(UnitTester $I){
        $a = new InstructorAgency( [ 'username' => 'BrandNewInstructorAgency1', 'email'=>'Brandagency@mailinator.com','password' => 'pass', 
            'confirmation_code' =>  md5(uniqid(mt_rand(), true)), 'confirmed' => 1, 'ltc_affiliate_id' => 2 ] );
        $a->password = 'pass';
        $a->password_confirmation = 'pass';
        $a->agency_balance = 200;
        $I->assertTrue( $a->save() );
    }
    
    public function failReusingName(UnitTester $I){
        $a = new InstructorAgency( [ 'username' => 'BrandNewInstructorAgency1', 'email'=>'Brandagency@mailinator.com','password' => 'pass', 
            'confirmation_code' =>  md5(uniqid(mt_rand(), true)), 'confirmed' => 1, 'ltc_affiliate_id' => 2 ] );
        $a->password = 'pass';
        $a->password_confirmation = 'pass';
        $a->agency_balance = 200;
        $I->assertTrue( $a->save() );
        $a = new InstructorAgency( [ 'username' => 'BrandNewInstructorAgency1', 'email'=>'Brandagency@mailinator.com','password' => 'pass', 
            'confirmation_code' =>  md5(uniqid(mt_rand(), true)), 'confirmed' => 1, 'ltc_affiliate_id' => 2 ] );
        $a->password = 'pass';
        $a->password_confirmation = 'pass';
        $a->agency_balance = 200;
        $I->assertFalse( $a->save() );
    }
    
    public function getInstructors(UnitTester $I){
        $agency = InstructorAgency::where('username','InstructorAgency1')->first();
        $count = User::where( 'instructor_agency_id', $agency->id )->count();
        $I->assertEquals( $count, $agency->instructors->count() );
    }
    
    public function getAgencyFromInstructor(UnitTester $I){
        $agency = InstructorAgency::where('username','InstructorAgency1')->first();
        $instructor = Instructor::where('username', 'instructor')->first();
        $instructor->instructor_agency_id = $agency->id;
        $instructor->updateUniques();
        $I->assertEquals($agency->id, $instructor->agency->id);
    }
    
}
