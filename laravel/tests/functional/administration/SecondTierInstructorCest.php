<?php 
use \FunctionalTester;

class SecondTierInstructorCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }
    
    
    public function updateInstructor(FunctionalTester $I){
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        
       $instructor = User::where('username', 'STInstructor1')->first();
       $I->assertEquals('yes', $instructor->is_second_tier_instructor );
       $I->assertEquals('no', $instructor->sti_approved );
       $user = User::where('username', 'superadmin')->first();
       $I->amLoggedAs($user);
       $I->seeAuthentication();
       $I->amOnPage('/administration/second-tier-publishers');

       $I->sendAjaxRequest('PUT', '/administration/second-tier-publishers/'.$instructor->id, 
                                ['_token' => csrf_token(), 'name' => 'sti_approved', 'value' => 'yes']);
       
       $instructor = User::where('username', 'STInstructor1')->first();
       $I->assertEquals('yes', $instructor->is_second_tier_instructor );
       $I->assertEquals('yes', $instructor->sti_approved );
    }

    
    
}