<?php 
use \FunctionalTester;

class ForgotPasswordCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        $this->users = new UserRepository();
    }

    public function seeEmailInput(FunctionalTester $I) {
        $I->amOnPage('/forgot-password');
        $I->seeNumberOfElements('input[name=email]', 1);
    }

    public function getErrorsIfFieldsNotFilled(FunctionalTester $I) {
        $I->amOnPage('/forgot-password');
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('#forgot-form', ['email' => '']);
        $I->see('User not found');
    }

    public function succedeIfUserExists(FunctionalTester $I) {
        Config::set('queue.default','sync');
        
        $I->amOnPage('/forgot-password');
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('#forgot-form', ['email' => 'student@mailinator.com']);
        $I->see('The information regarding');
    }
    
    public function redirectToHomeIfAuthenticatedVisits(FunctionalTester $I){
        $user = $this->users->find(1);
        Auth::login($user);
        $I->seeAuthentication();
        $I->amOnPage('/forgot-password');
        $I->seeCurrentUrlEquals('');
    }
    
    public function redirectToHomeIfAuthenticatedSubmits(FunctionalTester $I){
        $I->amOnPage('/forgot-password');
        $user = $this->users->find(1);
        Auth::login($user);
        $I->seeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('#forgot-form', ['email' => 'student@mailinator.com']);
        $I->seeCurrentUrlEquals('');
    }
}
