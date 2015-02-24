<?php 
use \FunctionalTester;

class AffiliateAgenciesCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }
    
    public function notSeeDeleteIfHasAffiliates(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/affiliate-agencies');
        $I->seeRecord('affiliate_agencies', ['id' => '1'] );
        $I->dontSee('delete-agency-1');
        $I->seeRecord('affiliate_agencies', ['id' => '2'] );
        $I->see('delete-agency-2');
    }
    
    public function deleteAgency(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/affiliate-agencies');
        $I->click('delete-agency-2');
        $I->dontSeeRecord('affiliate_agencies', ['id' => 2] );
    }

    public function redirectIfUnauthenticated(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->amOnPage('/administration/affiliate-agencies');
        $I->seeCurrentUrlEquals('');
    }
        
    public function redirectIfNotSuperadmin(FunctionalTester $I){
        $user = User::where('username', 'student')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/affiliate-agencies');
        $I->seeCurrentUrlEquals('');
    }
    
    public function viewAsAdmin(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/affiliate-agencies');
        $I->seeCurrentUrlEquals('/administration/affiliate-agencies');
    }
    
    public function createAgency(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/affiliate-agencies');
        $I->submitForm('#add-agency-form',[ 'name' => 'brand new agency' ]);
        $I->seeRecord('affiliate_agencies', ['name' => 'brand new agency'] );
    }
    
    public function updateAgencyName(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/affiliate-agencies');
        $I->sendAjaxRequest('PUT', action('AffiliateAgenciesController@update', 1), 
                                   ['name' => 'name', 'value' => 'Edited now!!!', '_method' => 'PUT', '_token' => csrf_token()] );
        $I->seeRecord('affiliate_agencies', [ 'name' => 'Edited now!!!' ] );
    }
    
    public function getAffiliates(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/affiliate-agencies');
        $I->click('1 Affiliate');
        $I->see('affiliate@mailinator.com');
    }
    
}