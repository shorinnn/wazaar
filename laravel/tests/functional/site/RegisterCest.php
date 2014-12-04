<?php 
use \FunctionalTester;

class RegisterCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }
    
    public function registerAndLogsIn(FunctionalTester $I){
        $I->amOnPage('/register');
        $I->dontSeeAuthentication();
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('form', ['username' => 'new_student', 'email' => 'new_student@mailinator.com',
                                        'password' => 'pass', 'password_confirmation' => 'pass']);
        $I->seeAuthentication();
    }
}
