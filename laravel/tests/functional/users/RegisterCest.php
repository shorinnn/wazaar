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
    
    public function registerAsTeacher(FunctionalTester $I){
        $I->amOnPage('/register/teacher');
        $I->dontSeeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('form', ['username' => 'new_student', 'email' => 'new_student@mailinator.com',
                                        'password' => 'pass', 'password_confirmation' => 'pass']);
        $I->seeAuthentication();
        $I->assertTrue(Auth::user()->hasRole('Teacher'));
        $I->assertTrue(Auth::user()->hasRole('Student'));
    }
    
    public function redirectToHomeIfAuthenticated(FunctionalTester $I){
        $user = User::find(1);
        Auth::login($user);
        $I->seeAuthentication();
        $I->amOnPage('/register');
        $I->seeCurrentUrlEquals('');
    }
    
    
}
