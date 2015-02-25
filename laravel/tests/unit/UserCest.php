<?php
use \UnitTester;

class UserCest{
    public function _before() {
        $this->users = new UserRepository;
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        User::boot();
    }
    
    public function assignStudentOnly(UnitTester $I){
        User::unguard();
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 
            'password_confirmation' => 'pass', 'confirmation_code' => 'a'];
        $user = new User($data);
        $I->assertTrue( $user->save() );
        $this->users->attachRoles($user);
        $user = User::find( $user->id );
        $I->assertTrue($user->hasRole('Student'));
        $I->assertFalse($user->hasRole('Instructor'));
        $I->assertFalse($user->hasRole('Admin'));
        $I->assertFalse($user->hasRole('Affiliate'));
    }

    public function makeUserStudentOnly(UnitTester $I){
        User::unguard();
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 'password_confirmation' => 'pass'];
        $user = $this->users->signup($data);
        $I->assertTrue($user->save());
        $user = User::find( $user->id );
        $I->assertTrue($user->hasRole('Student'));
        $I->assertFalse($user->hasRole('Instructor'));
        $I->assertFalse($user->hasRole('Admin'));
        $I->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function makeUserStudentAndInstructor(UnitTester $I){
        User::unguard();
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 
            'password_confirmation' => 'pass'];
        $user = $this->users->signup( $data, null, [ 'instructor' => 1 ] );
        $I->assertTrue($user->save());
        $user = User::find( $user->id );
        $I->assertTrue($user->hasRole('Student'));
        $I->assertTrue($user->hasRole('Instructor'));
        $I->assertFalse($user->hasRole('Admin'));
        $I->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function loginWithFacebookAndBeStudentOnly(UnitTester $I){
        User::unguard();
        $data = ['id' => '123', 'email' => 'fbUser@mailinator.com', 'first_name' => 'First', 'last_name' => 'Last', 'link' => 'link'];
        $user = $this->users->signupWithFacebook($data);
        $I->assertTrue($user->save());
        $user = User::find( $user->id );
        $I->assertTrue($user->hasRole('Student'));
        $I->assertFalse($user->hasRole('Instructor'));
        $I->assertFalse($user->hasRole('Admin'));
        $I->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function loginWithGoogleAndBeStudentOnly(UnitTester $I){
        User::unguard();
        $data = ['id' => '123', 'email' => 'fbUser@mailinator.com', 'given_name' => 'First', 'family_name' => 'Last', 'link' => 'link'];
        $user = $this->users->signupWithGoogle($data);
        $I->assertTrue($user->save());
        $user = User::find( $user->id );
        $I->assertTrue($user->hasRole('Student'));
        $I->assertFalse($user->hasRole('Instructor'));
        $I->assertFalse($user->hasRole('Admin'));
        $I->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function linkFacebookAccount(UnitTester $I){
        User::unguard();
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 
            'password_confirmation' => 'pass', 'confirmation_code' => 'a'];
        $user = $this->users->signup($data);
        $I->assertTrue($user->id > 0);
        $this->users->linkFacebook($data, $user->id, 123, 'abc');
        $user = $this->users->find($user->id);
        $I->assertEquals('123', $user->facebook_login_id);
    }
    
    public function linkGooglePlusAccount(UnitTester $I){
        User::unguard();
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 
            'password_confirmation' => 'pass', 'confirmation_code' => 'a'];
        $user = $this->users->signup($data);
        $I->assertTrue($user->id > 0);
        $this->users->linkGooglePlus($data, $user->id, 123, 'abc');
        $user = $this->users->find($user->id);
        $I->assertEquals('123', $user->google_plus_login_id);
    }
    
    public function makeStudentInstructor(UnitTester $I){
        $student = User::where('username','student')->first();
        $I->assertTrue($student->id > 0);
        $this->users->become('Instructor', $student);
        $student = User::where('username','student')->first();
        $I->assertTrue($student->hasRole('Instructor'));
    }
    
    public function makeStudentInstructorOnlyOnce(UnitTester $I){
        $student = User::where('username','student')->first();
        $I->assertTrue($student->id > 0);
        $this->users->become('Instructor', $student);
        $student = User::where('username','student')->first();
        $this->users->become('Instructor', $student);
        $student = User::where('username','student')->first();
        $I->assertEquals(2, $student->roles()->count());
    }
    
    public function makeStudentAffiliate(UnitTester $I){
        $student = User::where('username','student')->first();
        $I->assertTrue($student->id > 0);
        $this->users->become('Affiliate', $student);
        $student = User::where('username','student')->first();
        $I->assertTrue($student->hasRole('Affiliate'));
        $I->assertEquals($student->affiliate_id, $student->id);
    }
    
    public function makeStudentAffiliateOnlyOnce(UnitTester $I){
        $student = User::where('username','student')->first();
        $I->assertTrue($student->id > 0);
        $this->users->become('Affiliate', $student);
        $student = User::where('username','student')->first();
        $this->users->become('Affiliate', $student);
        $student = User::where('username','student')->first();
        $I->assertEquals(2, $student->roles()->count());
    }
    
    public function failBecomingAdmin(UnitTester $I){
        $student = User::where('username','student')->first();
        $I->assertTrue($student->id > 0);
        $this->users->become('Admin', $student);
        $I->assertFalse($student->hasRole('Admin'));
    }
    
    public function failBecomingInvalidRole(UnitTester $I){
        $student = User::where('username','student')->first();
        $I->assertTrue($student->id > 0);
        $this->users->become('Wahalla', $student);
        $I->assertFalse($student->hasRole('Wahala'));
    }
    
    public function changeAffiliateID(UnitTester $I){
        $student = User::where('username','affiliate')->first();
        $I->assertTrue($student->id > 0);
        $student->affiliate_id = 'Updated5';
        $student->save();
        $student = User::where('username','affiliate')->first();
        $I->assertEquals('Updated5', $student->affiliate_id);
    }
    
    public function failReusingAffiliateID(UnitTester $I){
        $student = User::where('username','affiliate')->first();
        $I->assertTrue($student->id > 0);
        $student->affiliate_id = '2';
        $I->assertFalse( $student->save() );
        $student = User::where('username','affiliate')->first();
        $I->assertNotEquals('2', $student->affiliate_id);
    }
    
    public function registerUserAffilitedByNooneDefaultsToWazaar(UnitTester $I){
        User::unguard();
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 'password_confirmation' => 'pass'];
        $user = $this->users->signup($data);
        $I->assertEquals($user->ltc_affiliate_id, 2);
    }
    
    public function registerUserAffilitedByAffiliate5(UnitTester $I){
        User::unguard();
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 'password_confirmation' => 'pass'];
        $affiliate = User::where('username', 'affiliate')->first();
        $user = $this->users->signup($data, $affiliate->affiliate_id);
        $I->assertEquals($user->ltc_affiliate_id, $affiliate->affiliate_id);
    }
    
    
}
