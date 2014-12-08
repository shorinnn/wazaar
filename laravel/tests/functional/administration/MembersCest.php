<?php 
use \FunctionalTester;

class MembersTeacherCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function redirectIfUnauthenticated(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->amOnPage('/administration/members');
        $I->seeCurrentUrlEquals('');
    }
    
    public function failDeletingSelf(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $I->amOnPage('/administration/members');
        $I->seeCurrentUrlEquals('/administration/members');
        $I->click('#member-form-1 button');
        $I->see('Cannot delete');
    }
    
    public function redirectIfStudentOnly(FunctionalTester $I){
        $user = User::find(2);
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/members');
        $I->seeCurrentUrlEquals('');
    }
    
    public function redirectIfTeacherOnly(FunctionalTester $I){
        $user = User::find(3);
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/members');
        $I->seeCurrentUrlEquals('');
    }
    
    public function redirectIfAffiliateOnly(FunctionalTester $I){
        $user = User::find(4);
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
        $I->see('Registered:');
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
        $I->amOnPage('/administration/members/2/edit');
        $I->seeCurrentUrlEquals('/administration/members/2/edit');
        $I->seeInField('email', 'student@mailinator.com');
        $I->seeInField('first_name', 'Student');
        $I->submitForm('#edit-form', ['email' => 'studentUPDATED@mailinator.com']);
        $I->see('Updated');
    }
    
    public function failUpdatingDetails(FunctionalTester $I){
        $user = User::find(1);
        $I->amLoggedAs($user);
        $I->amOnPage('/administration/members/2/edit');
        $I->seeCurrentUrlEquals('/administration/members/2/edit');
        $I->seeInField('email', 'student@mailinator.com');
        $I->seeInField('first_name', 'Student');
        $I->submitForm('#edit-form', ['email' => 'studentUPDATED@mailinatorFAIL']);
        $I->dontSee('Updated');
    }
    
    
    
}