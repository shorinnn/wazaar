<?php
use \Mockery;
use Goutte\Client;

class UserTest extends TestCase {

    public function setUp() {
        parent::setUp();
        $this->users = new UserRepository;
        $this->goutte = new Client();
        $this->setupDatabase();
    }

    public function setupDatabase() {
        Artisan::call('migrate:install');
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
    }
    
    public function test_assign_student_only(){
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 
            'password_confirmation' => 'pass', 'confirmation_code' => 'a'];
        $user = new User($data);
        $user->save();
        $this->users->attachRoles($user);
        $this->assertTrue($user->hasRole('Student'));
        $this->assertFalse($user->hasRole('Teacher'));
        $this->assertFalse($user->hasRole('Admin'));
        $this->assertFalse($user->hasRole('Affiliate'));
    }

    public function test_user_should_be_student_only(){
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 'password_confirmation' => 'pass'];
        $user = $this->users->signup($data);
        $this->assertTrue($user->save());
        $this->assertTrue($user->hasRole('Student'));
        $this->assertFalse($user->hasRole('Teacher'));
        $this->assertFalse($user->hasRole('Admin'));
        $this->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function test_user_should_be_student_and_teacher(){
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 
            'password_confirmation' => 'pass', 'teacher' => 1];
        $user = $this->users->signup($data);
        $this->assertTrue($user->save());
        $this->assertTrue($user->hasRole('Student'));
        $this->assertTrue($user->hasRole('Teacher'));
        $this->assertFalse($user->hasRole('Admin'));
        $this->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function test_facebook_login_should_be_student_only(){
        $data = ['id' => '123', 'email' => 'fbUser@mailinator.com', 'first_name' => 'First', 'last_name' => 'Last', 'link' => 'link'];
        $user = $this->users->signupWithFacebook($data);
        $this->assertTrue($user->save());
        $this->assertTrue($user->hasRole('Student'));
        $this->assertFalse($user->hasRole('Teacher'));
        $this->assertFalse($user->hasRole('Admin'));
        $this->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function test_google_login_should_be_student_only(){
        $data = ['id' => '123', 'email' => 'fbUser@mailinator.com', 'given_name' => 'First', 'family_name' => 'Last', 'link' => 'link'];
        $user = $this->users->signupWithGoogle($data);
        $this->assertTrue($user->save());
        $this->assertTrue($user->hasRole('Student'));
        $this->assertFalse($user->hasRole('Teacher'));
        $this->assertFalse($user->hasRole('Admin'));
        $this->assertFalse($user->hasRole('Affiliate'));
    }
    
    public function test_user_links_facebook(){
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 
            'password_confirmation' => 'pass', 'confirmation_code' => 'a'];
        $user = $this->users->signup($data);
        $this->assertTrue($user->id > 0);
        $this->users->linkFacebook($data, $user->id, 123, 'abc');
        $user = $this->users->find($user->id);
        $this->assertEquals('123', $user->facebook_login_id);
    }
    
    public function test_user_links_google_plus(){
        $data = ['username' => 'latest_user', 'email' => 'latest_user@mailinator.com', 'password' => 'pass', 
            'password_confirmation' => 'pass', 'confirmation_code' => 'a'];
        $user = $this->users->signup($data);
        $this->assertTrue($user->id > 0);
        $this->users->linkGooglePlus($data, $user->id, 123, 'abc');
        $user = $this->users->find($user->id);
        $this->assertEquals('123', $user->google_plus_login_id);
    }
}
