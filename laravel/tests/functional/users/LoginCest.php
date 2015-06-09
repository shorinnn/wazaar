<?php 
use \FunctionalTester;

class LoginCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }
  
    public function seeEmailInputIfUnauthenticated(FunctionalTester $I) {
        $I->amOnPage('/login');
        $I->seeNumberOfElements('input[name=email]', 1);
    }
    
    public function failAuthentication(FunctionalTester $I) {
        $I->amOnPage('/login');
        $I->submitForm('form', ['email' => 'student@mailinator.com', 'password' => 'bad_pass']);
        $I->dontSeeAuthentication();
    }
    
    public function authenticateAndRedirectToHome(FunctionalTester $I) {
        $I->amOnPage('/login');
        $I->submitForm('form', ['email' => 'student@mailinator.com', 'password' => 'pass']);
        $I->seeAuthentication();
        $I->seeCurrentUrlEquals('');
    }

    public function redirectToHomeIfAuthenticated(FunctionalTester $I) {
        $user = User::find(1);
        Auth::login($user);
        $I->seeAuthentication();
        $I->amOnPage('/login');
        $I->dontSee("Username or Email");
        $I->seeCurrentUrlEquals('');
    }

}
