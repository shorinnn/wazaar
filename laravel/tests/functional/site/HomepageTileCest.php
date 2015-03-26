<?php 
use \FunctionalTester;

class HomepageCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function seeHomepageCourseTile(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->amOnPage('/');
        $I->see('course-tile-1');
    }
    
    public function nptSeeHomepageCourseTile(FunctionalTester $I){
        DB::table('frontpage_videos')->update( ['course_id' => 2] );
        $I->dontSeeAuthentication();
        $I->amOnPage('/');
        $I->dontSee('course-tile-1');
        $I->see('course-tile-2');
    }
    
    public function updateTiles(FunctionalTester $I){
        $admin = User::first();
        $I->amLoggedAs($admin);
        $I->amOnPage('/administration/frontpage-videos');
        $I->selectOption('select', 'Beauty App Development');
        $I->click('Update');
        $I->dontSeeRecord( 'frontpage_videos',['course_id' => 1] );
        
        $I->amOnPage('/administration/frontpage-videos');
        $I->selectOption('select', 'App Development');
        $I->click('Update');
        $I->seeRecord( 'frontpage_videos',['course_id' => 1] );
    }
    
    
}