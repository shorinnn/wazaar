<?php 
use \FunctionalTester;

class ActionTrackerCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function trackClick(FunctionalTester $I){
        // functional tests dont run JS, maybe write acceptance tests for this
//        $I->amOnPage('/');
//        $I->assertEquals(0, Action::count());
//        $I->click('Temporary Login');
//        $I->seeCurrentUrlEquals('/login');
//        $I->assertEquals(1, Action::count());
    }
    
    
    
    
    
    
}