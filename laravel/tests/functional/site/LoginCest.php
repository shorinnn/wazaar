<?php 
use \FunctionalTester;

class LoginCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }
  
    public function unauthenticatedSeesEmailInput(FunctionalTester $I) {
        $I->amOnPage('/login');
        $I->seeNumberOfElements('input[name=email]', 1);
    }
    
    public function authenticationFails(FunctionalTester $I) {
        $I->amOnPage('/login');
        $I->submitForm('form', ['email' => 'wazaarStudent@mailinator.com', 'password' => 'bad_pass']);
        $I->dontSeeAuthentication();
    }
    
    public function userUnauthenticatesAndRedirected(FunctionalTester $I) {
        $I->amOnPage('/login');
        $I->submitForm('form', ['email' => 'wazaarStudent@mailinator.com', 'password' => 'pass']);
        $I->seeAuthentication();
    }

    public function authenticatedUserRedirectedToHomepage(FunctionalTester $I) {
        $user = User::find(1);
        Auth::login($user);
        $I->seeAuthentication();
        $I->amOnPage('/login');
        $I->dontSee("Username or Email");
        $I->seeCurrentUrlEquals('');
    }

}
