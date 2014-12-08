<?php
use \UnitTester;
use \Codeception\Util\Stub;
class UserCest{
    public function _before() {
        $this->users = new UserRepository;
        $this->setupDatabase();
    }
    

    public function setupDatabase() {
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

    public function UserShouldBeStudentOnly(UnitTester $I){
        User::unguard();
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 'password_confirmation' => 'pass'];
        $user = $this->users->signup($data);
        $I->assertTrue($user->save());
        $I->assertTrue($user->hasRole('Student'));
        $I->assertFalse($user->hasRole('Teacher'));
        $I->assertFalse($user->hasRole('Admin'));
        $I->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function test_user_should_be_student_and_teacher(UnitTester $I){
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
    
    public function test_facebook_login_should_be_student_only(UnitTester $I){
        User::unguard();
        $data = ['id' => '123', 'email' => 'fbUser@mailinator.com', 'first_name' => 'First', 'last_name' => 'Last', 'link' => 'link'];
        $user = $this->users->signupWithFacebook($data);
        $I->assertTrue($user->save());
        $I->assertTrue($user->hasRole('Student'));
        $I->assertFalse($user->hasRole('Teacher'));
        $I->assertFalse($user->hasRole('Admin'));
        $I->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function test_google_login_should_be_student_only(UnitTester $I){
        User::unguard();
        $data = ['id' => '123', 'email' => 'fbUser@mailinator.com', 'given_name' => 'First', 'family_name' => 'Last', 'link' => 'link'];
        $user = $this->users->signupWithGoogle($data);
        $I->assertTrue($user->save());
        $I->assertTrue($user->hasRole('Student'));
        $I->assertFalse($user->hasRole('Teacher'));
        $I->assertFalse($user->hasRole('Admin'));
        $I->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function test_user_links_facebook(UnitTester $I){
        User::unguard();
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 
            'password_confirmation' => 'pass', 'confirmation_code' => 'a'];
        $user = $this->users->signup($data);
        $I->assertTrue($user->id > 0);
        $this->users->linkFacebook($data, $user->id, 123, 'abc');
        $user = $this->users->find($user->id);
        $I->assertEquals('123', $user->facebook_login_id);
    }
    
    public function test_user_links_google_plus(UnitTester $I){
        User::unguard();
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 
            'password_confirmation' => 'pass', 'confirmation_code' => 'a'];
        $user = $this->users->signup($data);
        $I->assertTrue($user->id > 0);
        $this->users->linkGooglePlus($data, $user->id, 123, 'abc');
        $user = $this->users->find($user->id);
        $I->assertEquals('123', $user->google_plus_login_id);
    }
}
