<?php 
use \FunctionalTester;

class CategoriesCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }
    
    public function failDeletingCategoryIfCourses(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/coursecategories');
        $I->seeRecord('course_categories', ['id' => '1'] );
        $I->click('delete-category-1');
        $I->seeRecord('course_categories', ['id' => '1'] );
    }
    
    public function deleteCategory(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/coursecategories');
        $I->submitForm('#add-category-form',[ 'name' => 'brand new category' ]);
        $I->seeRecord('course_categories', ['name' => 'brand new category'] );
        $I->amOnPage('/administration/coursecategories');
        $cat = CourseCategory::where('name','brand new category')->first();
        $I->click('delete-category-'.$cat->id);
        $I->dontSeeRecord('course_categories', ['name' => 'brand new category'] );
    }

    public function redirectIfUnauthenticated(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->amOnPage('/administration/coursecategories');
        $I->seeCurrentUrlEquals('');
    }
        
    public function redirectIfNotSuperadmin(FunctionalTester $I){
        $user = User::where('username', 'student')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/coursecategories');
        $I->seeCurrentUrlEquals('');
    }
    
    public function viewAsAdmin(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/coursecategories');
        $I->seeCurrentUrlEquals('/administration/coursecategories');
    }
    
    public function createCategory(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/coursecategories');
        $I->submitForm('#add-category-form',[ 'name' => 'brand new category' ]);
        $I->seeRecord('course_categories', ['name' => 'brand new category'] );
    }
    
    
    
    public function updateCategoryName(FunctionalTester $I){
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/coursecategories');
        $I->sendAjaxRequest('PUT', action('CoursesCategoriesController@update', 1), 
                                   ['name' => 'name', 'value' => 'Edited now!!!', '_method' => 'PUT', '_token' => csrf_token()] );
        $I->seeRecord('course_categories', [ 'name' => 'Edited now!!!' ] );
    }
    
    public function getSubcategory(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->sendAjaxGetRequest('/coursecategories/subcategories', ['id' => 1]);
        $I->see('[{"id":"1",');
    }
    
}