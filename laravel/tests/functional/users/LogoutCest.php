<?php 
use \FunctionalTester;

class LogoutCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }
  
    public function redirectToHomeIfUnauthenticated(FunctionalTester $I) {
        $I->dontSeeAuthentication();
        $I->amOnPage('/logout');
        $I->dontSeeAuthentication();
        $I->seeCurrentUrlEquals('');
    }
    
    public function logOutAndGoToHome(FunctionalTester $I){
        $user = User::find(1);
        Auth::login($user);
        $I->seeAuthentication();
        $I->amOnPage('/logout');
        $I->dontSeeAuthentication();
        $I->seeCurrentUrlEquals('');
    }
    
   

}
