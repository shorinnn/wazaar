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
    }
    
    public function assignStudentOnly(UnitTester $I){
        User::unguard();
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 
            'password_confirmation' => 'pass', 'confirmation_code' => 'a'];
        $user = new User($data);
        $user->save();
        $this->users->attachRoles($user);
        $I->assertTrue($user->hasRole('Student'));
        $I->assertFalse($user->hasRole('Teacher'));
        $I->assertFalse($user->hasRole('Admin'));
        $I->assertFalse($user->hasRole('Affiliate'));
    }

    public function makeUserStudentOnly(UnitTester $I){
        User::unguard();
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 'password_confirmation' => 'pass'];
        $user = $this->users->signup($data);
        $I->assertTrue($user->save());
        $I->assertTrue($user->hasRole('Student'));
        $I->assertFalse($user->hasRole('Teacher'));
        $I->assertFalse($user->hasRole('Admin'));
        $I->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function makeUserStudentAndTeacher(UnitTester $I){
        User::unguard();
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 
            'password_confirmation' => 'pass', 'teacher' => 1];
        $user = $this->users->signup($data);
        $I->assertTrue($user->save());
        $I->assertTrue($user->hasRole('Student'));
        $I->assertTrue($user->hasRole('Teacher'));
        $I->assertFalse($user->hasRole('Admin'));
        $I->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function loginWithFacebookAndBeStudentOnly(UnitTester $I){
        User::unguard();
        $data = ['id' => '123', 'email' => 'fbUser@mailinator.com', 'first_name' => 'First', 'last_name' => 'Last', 'link' => 'link'];
        $user = $this->users->signupWithFacebook($data);
        $I->assertTrue($user->save());
        $I->assertTrue($user->hasRole('Student'));
        $I->assertFalse($user->hasRole('Teacher'));
        $I->assertFalse($user->hasRole('Admin'));
        $I->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function loginWithGoogleAndBeStudentOnly(UnitTester $I){
        User::unguard();
        $data = ['id' => '123', 'email' => 'fbUser@mailinator.com', 'given_name' => 'First', 'family_name' => 'Last', 'link' => 'link'];
        $user = $this->users->signupWithGoogle($data);
        $I->assertTrue($user->save());
        $I->assertTrue($user->hasRole('Student'));
        $I->assertFalse($user->hasRole('Teacher'));
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
    
    public function makeStudentTeacher(UnitTester $I){
        $student = User::where('username','student')->first();
        $I->assertTrue($student->id > 0);
        $this->users->become('Teacher', $student);
        $student = User::where('username','student')->first();
        $I->assertTrue($student->hasRole('Teacher'));
    }
    
    public function makeStudentTeacherOnlyOnce(UnitTester $I){
        $student = User::where('username','student')->first();
        $I->assertTrue($student->id > 0);
        $this->users->become('Teacher', $student);
        $student = User::where('username','student')->first();
        $this->users->become('Teacher', $student);
        $student = User::where('username','student')->first();
        $I->assertEquals(2, $student->roles()->count());
    }
    
    public function makeStudentAffiliate(UnitTester $I){
        $student = User::where('username','student')->first();
        $I->assertTrue($student->id > 0);
        $this->users->become('Affiliate', $student);
        $student = User::where('username','student')->first();
        $I->assertTrue($student->hasRole('Affiliate'));
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
    
    
    
}
