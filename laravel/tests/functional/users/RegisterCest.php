<?php 
use \FunctionalTester;

class RegisterCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        User::boot();
    }
    
    public function failRegistration(FunctionalTester $I){
        $I->amOnPage('/register');
        $I->dontSeeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('form', ['username' => '', 'email' => '',
                                        'password' => '', 'password_confirmation' => '']);
        $I->dontSeeAuthentication();
    }
    
    public function registerAndLogIn(FunctionalTester $I){
        $I->amOnPage('/register');
        $I->dontSeeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('form', ['username' => 'new_student', 'email' => 'new_student@mailinator.com',
                                        'password' => 'passpass', 'password_confirmation' => 'passpass']);
        $I->seeAuthentication();
    }
    
    public function registerAsInstructor(FunctionalTester $I){
        $I->amOnPage('/register/instructor');
        $I->setCookie('register_instructor',1);
        $I->dontSeeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('form', ['username' => 'new_student', 'email' => 'new_student@mailinator.com',
                                        'password' => 'passpass', 'password_confirmation' => 'passpass']);
        $I->seeAuthentication();
        $I->assertTrue(Auth::user()->hasRole('Instructor'));
        $I->assertTrue(Auth::user()->hasRole('Student'));
    }
    public function registerAsInstructorWithSecondTier(FunctionalTester $I){
        $I->amOnPage('/register/instructor');
        $I->setCookie('register_instructor',1);
        $I->setCookie('stpi',2);
        $I->amOnPage('/register/instructor');
        $I->amOnPage('/register/instructor');
        $I->dontSeeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('form', ['username' => 'new_student', 'email' => 'new_student@mailinator.com',
                                        'password' => 'passpass', 'password_confirmation' => 'passpass']);
        $I->seeAuthentication();
        $I->assertTrue(Auth::user()->hasRole('Instructor'));
        $I->assertTrue(Auth::user()->hasRole('Student'));
        $I->assertEquals( 2, Auth::user()->second_tier_instructor_id );
        $secondtier = SecondTierInstructor::find(2);
        $I->assertEquals( 1, $secondtier->instructors->count() );
    }
    
    public function registerAsAffiliate(FunctionalTester $I){
        $I->amOnPage('/register/affiliate');
        $I->setCookie('register_affiliate',1);
        $I->dontSeeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('form', ['username' => 'new_student', 'email' => 'new_student@mailinator.com',
                                        'password' => 'passpass', 'password_confirmation' => 'passpass']);
        $I->seeAuthentication();
        $I->assertTrue(Auth::user()->hasRole('Affiliate'));
        $I->assertTrue(Auth::user()->hasRole('Student'));
    }
    
    public function redirectToHomeIfAuthenticated(FunctionalTester $I){
        $user = User::find(1);
        Auth::login($user);
        $I->seeAuthentication();
        $I->amOnPage('/register');
        $I->seeCurrentUrlEquals('');
    }
    
    public function defaultWazaarAsLtcAffiliate(FunctionalTester $I){
        $I->amOnPage('/register');
        $I->dontSeeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('form', ['username' => 'new_student', 'email' => 'new_student@mailinator.com',
                                        'password' => 'passpass', 'password_confirmation' => 'passpass']);
        $I->seeAuthentication();
        $I->seeRecord('users', array('email' => 'new_student@mailinator.com', 'ltc_affiliate_id' => '2'));
    }
    
    public function referUserByAffiliate5(FunctionalTester $I){
        $I->amOnPage('/?aid=5');
        $I->setCookie('ltc',5);
        $I->amOnPage('/register');
        $I->dontSeeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('form', ['username' => 'new_student', 'email' => 'new_student@mailinator.com',
                                        'password' => 'passpass', 'password_confirmation' => 'passpass']);
        $I->seeAuthentication();
        $I->seeRecord('users', array('email' => 'new_student@mailinator.com', 'ltc_affiliate_id' => '5'));
    }
    
    public function overrideUserReferral(FunctionalTester $I){
        $I->amOnPage('/?aid=5');
        $I->setCookie('ltc',5);
        $I->amOnPage('/?aid=2');
        $I->setCookie('ltc',2);
        $I->amOnPage('/register');
        $I->dontSeeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('form', ['username' => 'new_student', 'email' => 'new_student@mailinator.com',
                                        'password' => 'passpass', 'password_confirmation' => 'passpass']);
        $I->seeAuthentication();
        $I->seeRecord('users', array('email' => 'new_student@mailinator.com', 'ltc_affiliate_id' => '2'));
    }
    
    
    
    
    
}
