<?php
use \UnitTester;

class CourseSubcategoryCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        CourseSubcategory::boot();
    }
    
    public function createSubcategory(UnitTester $I){
        $subcategory = new CourseSubcategory;
        $subcategory->name = 'Test';
        $subcategory->course_category_id = CourseCategory::first()->id;
        $I->assertTrue( $subcategory->save() );
    }
    
    public function failSubcategoryInvalidCategoryId(UnitTester $I){
        $subcategory = new CourseSubcategory;
        $subcategory->name = 'Test';
        $subcategory->course_category_id = 0;
        $I->assertFalse( $subcategory->save() );
    }
    
    public function deleteSubcategory(UnitTester $I){
        $subcategory = CourseSubcategory::first();
        $I->assertTrue( $subcategory->save() );
    }
    
    
        
}