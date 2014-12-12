<?php 
use \FunctionalTester;

class RegisterCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
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
                                        'password' => 'pass', 'password_confirmation' => 'pass']);
        $I->seeAuthentication();
    }
    
    public function registerAsInstructor(FunctionalTester $I){
        $I->amOnPage('/register/instructor');
        $I->dontSeeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('form', ['username' => 'new_student', 'email' => 'new_student@mailinator.com',
                                        'password' => 'pass', 'password_confirmation' => 'pass']);
        $I->seeAuthentication();
        $I->assertTrue(Auth::user()->hasRole('Instructor'));
        $I->assertTrue(Auth::user()->hasRole('Student'));
    }
    
    public function redirectToHomeIfAuthenticated(FunctionalTester $I){
        $user = User::find(1);
        Auth::login($user);
        $I->seeAuthentication();
        $I->amOnPage('/register');
        $I->seeCurrentUrlEquals('');
    }
    
    public function defaultWazaarAsLtcAffiliator(FunctionalTester $I){
        $I->amOnPage('/register');
        $I->dontSeeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('form', ['username' => 'new_student', 'email' => 'new_student@mailinator.com',
                                        'password' => 'pass', 'password_confirmation' => 'pass']);
        $I->seeAuthentication();
        $I->seeRecord('users', array('email' => 'new_student@mailinator.com', 'ltc_affiliator_id' => '2'));
    }
    
    public function referUserByAffiliate5(FunctionalTester $I){
        $I->amOnPage('/?aid=5');
        $I->setCookie('ltc',5);
        $I->amOnPage('/register');
        $I->dontSeeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('form', ['username' => 'new_student', 'email' => 'new_student@mailinator.com',
                                        'password' => 'pass', 'password_confirmation' => 'pass']);
        $I->seeAuthentication();
        $I->seeRecord('users', array('email' => 'new_student@mailinator.com', 'ltc_affiliator_id' => '5'));
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
                                        'password' => 'pass', 'password_confirmation' => 'pass']);
        $I->seeAuthentication();
        $I->seeRecord('users', array('email' => 'new_student@mailinator.com', 'ltc_affiliator_id' => '2'));
    }
    
    
    
    
    
}
