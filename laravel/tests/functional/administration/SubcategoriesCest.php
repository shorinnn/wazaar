<?php 
use \FunctionalTester;

class SubcategoriesCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }
    
    public function failDeletingSubcategoryIfHasCourses(FunctionalTester $I){
        CourseCategory::boot();
        CourseSubcategory::boot();
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/coursecategories');
        $I->seeRecord( 'course_subcategories', ['id' => '1'] );
        $I->click('delete-subcategory-1');
        $I->seeRecord( 'course_subcategories', ['id' => '1'] );
    }
    
    public function deleteSubcategory(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/coursecategories');
        $I->submitForm('#add-subcat-1',[ 'name' => 'brand new subcategory' ]);
        $I->seeRecord('course_subcategories', ['name' => 'brand new subcategory'] );
        $I->amOnPage('/administration/coursecategories');
        $subcat = CourseSubcategory::where('name','brand new subcategory')->first();
        $I->click('delete-subcategory-'.$subcat->id);
        $I->dontSeeRecord('course_subcategories', ['name' => 'brand new subcategory'] );
    }

    public function redirectIfUnauthenticated(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->amOnPage('/administration/coursesubcategories');
        $I->seeCurrentUrlEquals('');
    }
        
    public function redirectIfNotSuperadmin(FunctionalTester $I){
        $user = User::where('username', 'student')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/coursesubcategories');
        $I->seeCurrentUrlEquals('');
    }
    
    public function createSubcategory(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/coursecategories');
        $I->submitForm('#add-subcat-1',[ 'name' => 'brand new subcategory' ]);
        $I->seeRecord('course_subcategories', ['name' => 'brand new subcategory'] );
    }
    
    public function updateCategoryName(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/coursesubcategories');
        $I->sendAjaxRequest('PUT', action('CoursesSubcategoriesController@update', 1), 
                                   ['name' => 'name', 'value' => 'Edited now!!!', '_method' => 'PUT', '_token' => csrf_token()] );
        $I->seeRecord('course_subcategories', [ 'name' => 'Edited now!!!' ] );
    }
    
}