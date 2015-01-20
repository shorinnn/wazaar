<?php
use \UnitTester;

class CourseCategoryCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
    }
    
    public function createCategory(UnitTester $I){
        $category = new CourseCategory;
        $category->name = 'Test';
        $I->assertTrue( $category->save() );
    }
    
    public function deleteCategoryAndSubcategory(UnitTester $I){
        $category = CourseCategory::first();
        $I->assertGreaterThan(0, $category->courseSubcategories->count());        
        $subcategory = CourseSubcategory::where('course_category_id', $category->id)->first();
        // move courses
        foreach($category->courses()->get() as $course){
            $course->course_category_id = 5;
            $course->updateUniques();
        }        
        $category = CourseCategory::first();
        $I->assertEquals( 0, $category->courses()->count() );
        foreach($category->courseSubcategories as $subcat){
            foreach($subcat->courses()->get() as $course){
                $course->course_subcategory_id = 5;
                $course->updateUniques();
            }
        }
        $subcategory = CourseSubcategory::where('course_category_id', $category->id)->first();
        $I->assertGreaterThan(0, $subcategory->id);
        $I->assertTrue(  $category->delete() );
        $I->assertEquals( 0, CourseCategory::where('id', $category->id)->count() );
        $subcategory = CourseSubcategory::where('course_category_id', $category->id)->count();
        $I->assertEquals(0, $subcategory);
    }
    
    
        
}