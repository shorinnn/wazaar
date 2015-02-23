<?php 
use \FunctionalTester;

class MembersCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        User::boot();
    }
    
    public function failDeletingSelf(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $I->amOnPage('/administration/members');
        $I->seeCurrentUrlEquals('/administration/members');
        $I->click('#member-form-1 button');
        $I->see('Cannot delete');
    }

    public function redirectIfUnauthenticated(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->amOnPage('/administration/members');
        $I->seeCurrentUrlEquals('');
    }
        
    public function redirectIfStudentOnly(FunctionalTester $I){
        $user = User::where('username', 'student')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/members');
        $I->seeCurrentUrlEquals('');
    }
    
    public function redirectIfInstructorOnly(FunctionalTester $I){
        $user = User::where('username', 'instructor')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/members');
        $I->seeCurrentUrlEquals('');
    }
    
    public function redirectIfAffiliateOnly(FunctionalTester $I){
        $user = User::where('username', 'affiliate')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/members');
        $I->seeCurrentUrlEquals('');
    }
    
    public function loginIfAdmin(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/members');
        $I->seeCurrentUrlEquals('/administration/members');
        $I->see('View');
    }
    
    
    
    public function deleteOtherMember(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $I->amOnPage('/administration/members');
        $I->seeCurrentUrlEquals('/administration/members');
        $I->click('#member-form-2 button');
        $I->see('deleted');
    }
    
    public function viewUser(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $I->amOnPage('/administration/members');
        $I->seeCurrentUrlEquals('/administration/members');
        $I->click('View');
        $I->see('Registered');
    }
    
    public function editUser(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $I->amOnPage('/administration/members');
        $I->seeCurrentUrlEquals('/administration/members');
        $I->click('Edit');
        $I->see('Update');
    }
    
    public function viewUserFromEdit(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $I->amOnPage('/administration/members/1/edit');
        $I->seeCurrentUrlEquals('/administration/members/1/edit');
        $I->click('View');
        $I->see('Registered');
    }
    
    public function editUserFromView(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $I->amOnPage('/administration/members/1');
        $I->seeCurrentUrlEquals('/administration/members/1');
        $I->click('Edit');
        $I->see('Update');
    }
    
    public function updateUserDetails(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $student = User::where('username','student')->first();
        $I->amOnPage("/administration/members/$student->id/edit");
        $I->seeCurrentUrlEquals("/administration/members/$student->id/edit");
        $I->seeInField('email', 'student@mailinator.com');
        $I->submitForm('#edit-form', ['email' => 'studentUPDATED@mailinator.com']);
        $I->see('Updated');
    }
    
    public function failUpdatingDetails(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $student = User::where('username','student')->first();
        $I->amOnPage("/administration/members/$student->id/edit");
        $I->seeCurrentUrlEquals("/administration/members/$student->id/edit");
        $I->seeInField('email', 'student@mailinator.com');
        $I->submitForm('#edit-form', ['email' => 'studentUPDATED@mailinatorFAIL']);
        $I->dontSee('Updated');
    }
    
    public function seeOrderDetails(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $student = User::where('username','sorin')->first();
        $I->amOnPage("/administration/members/$student->id");
        $I->see('orders-table');
        $I->see('¥ 50');
    }
    
    public function notSeeAffiliateDetails(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $student = User::where('username','sorin')->first();
        $I->amOnPage("/administration/members/$student->id");
        $I->see('orders-table');
        $I->dontSee('Affiliate Rank');
    }
    
    public function seeAffiliateDetails(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $student = User::where('username','affiliate')->first();
        $I->amOnPage("/administration/members/$student->id");
        $I->see('orders-table');
        $I->see('Affiliate Rank');
    }
    
    public function notSeeInstructorDetails(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $student = User::where('username','sorin')->first();
        $I->amOnPage("/administration/members/$student->id");
        $I->see('orders-table');
        $I->dontSee('Teacher Stats');
    }
    
    public function seeInstructorDetails(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $student = User::where('username','instructor')->first();
        $I->amOnPage("/administration/members/$student->id");
        $I->see('orders-table');
        $I->see('Teacher Stats');
    }
    
    
    
}