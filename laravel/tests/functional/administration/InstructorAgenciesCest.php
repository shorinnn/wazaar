<?php 
use \FunctionalTester;

class InstructorAgenciesCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        $this->agency = InstructorAgency::first();
    }
    
    
    public function deleteAgency(FunctionalTester $I){
        DB::table('users')->update( ['instructor_agency_id' => 0 ] );
        $user = User::where('username', 'superadmin')->first();
        $I->seeRecord('users', ['id' => $this->agency->id] );
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/instructor-agencies');
        $I->click('delete-agency-'. $this->agency->id);
        $I->dontSeeRecord('users', ['id' => $this->agency->id] );
    }

    public function redirectIfUnauthenticated(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->amOnPage('/administration/instructor-agencies');
        $I->seeCurrentUrlEquals('');
    }
        
    public function redirectIfNotSuperadmin(FunctionalTester $I){
        $user = User::where('username', 'student')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/instructor-agencies');
        $I->seeCurrentUrlEquals('');
    }
    
    public function viewAsAdmin(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/instructor-agencies');
        $I->seeCurrentUrlEquals('/administration/instructor-agencies');
    }
    
    public function createAgency(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/instructor-agencies');
        $I->submitForm('#add-agency-form',[ 'username' => 'brandnewagency', 'email' => 'brand@new.com', 
            'password' => 'pass', 'password_confirmation' => 'pass' ]);
        $I->seeRecord('users', ['email' => 'brand@new.com'] );
    }
    
    public function updateAgencyName(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/instructor-agencies');
        $I->sendAjaxRequest('PUT', action('InstructorAgenciesController@update', $this->agency->id), 
                                   ['name' => 'username', 'value' => 'Editednow', '_method' => 'PUT', '_token' => csrf_token()] );
        $I->seeRecord('users', [ 'username' => 'Editednow' ] );
    }
    
    public function getAffiliates(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/instructor-agencies');
        $I->click('1 Instructor');
        $I->see('instructor@mailinator.com');
    }
    
}