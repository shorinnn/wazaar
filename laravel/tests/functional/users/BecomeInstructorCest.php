<?php 
use \FunctionalTester;

class BecomeInstructorCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }
    
    public function seeAuthLinks(FunctionalTester $I){
        $I->amOnPage('/instructors/become-instructor');
        $I->see('Register');
        $I->see('Login');
    }
    
    public function seeInstructorRegisterURL(FunctionalTester $I){
        $I->amOnPage('/instructors/become-instructor');
        $I->see('new-user');
        $I->see('Register');
        $I->click('[href="'.action('InstructorsController@start','new-user').'"]');
        $I->seeCurrentUrlEquals('/register/instructor');
    }
 
    public function becomeInstructor(FunctionalTester $I){
        $user =  User::where('username','student')->first();
        Auth::login($user);
        $I->assertEquals(1, $user->roles()->count());
        $I->seeAuthentication();
        $I->amOnPage('/instructors/become-instructor');
        $I->see('Get Started');  
        // disable filters because codeception doesn't load the new role after submission
        $I->haveDisabledFilters();
        $I->click('Get Started');
        $user = User::where('username','student')->first();
//        $user = $I->refreshAuthenticatedUser( $user );
        Auth::login($user);
        $I->assertTrue( Auth::user()->hasRole('Instructor') );
        $I->seeCurrentUrlEquals('/instructors');
        // enable filters again
        $I->haveEnabledFilters();
        $I->see('Congratulations');
        $I->amOnPage('/instructors');
        $I->seeCurrentUrlEquals('/instructors');
    }
    
    public function becomeInstructorWithSecondTier(FunctionalTester $I){
        $user =  User::where('username','student')->first();
        Auth::login($user);
        $I->assertEquals(1, $user->roles()->count());
        $I->seeAuthentication();
        $I->setCookie('stpi',2);
        $I->amOnPage('/instructors/become-instructor');
        $I->amOnPage('/instructors/become-instructor');
        $I->see('Get Started');  
        // disable filters because codeception doesn't load the new role after submission
        $I->haveDisabledFilters();
        $I->click('Get Started');
        $user = User::where('username','student')->first();
//        $user = $I->refreshAuthenticatedUser( $user );
        Auth::login($user);
        $I->assertTrue( Auth::user()->hasRole('Instructor') );
        $I->seeCurrentUrlEquals('/instructors');
        // enable filters again
        $I->haveEnabledFilters();
        $I->see('Congratulations');
        $I->amOnPage('/instructors');
        $I->seeCurrentUrlEquals('/instructors');
        $I->assertEquals( 2, Auth::user()->second_tier_instructor_id );
        $secondtier = SecondTierInstructor::find(2);
        $I->assertEquals( 1, $secondtier->instructors->count() );
    }
    
    public function failBecomingInstructorAgain(FunctionalTester $I){
        $user =  User::where('username','student')->first();
        Auth::login($user);
        $I->assertEquals(1, $user->roles()->count());
        $I->seeAuthentication();
        $I->amOnPage('/instructors/become-instructor');
        $I->see('Get Started');  
        // disable filters because codeception doesn't load the new role after submission
        $I->haveDisabledFilters();
        $I->click('Get Started');
        $user = User::where('username','student')->first();
//        $user = $I->refreshAuthenticatedUser( $user );
        Auth::login($user);
        $I->assertTrue( Auth::user()->hasRole('Instructor') );
        $I->seeCurrentUrlEquals('/instructors');
        // enable filters again
        $I->haveEnabledFilters();
        $I->see('Congratulations');
        $I->amOnPage('/instructors');
        $I->seeCurrentUrlEquals('/instructors');     
        $I->amOnPage('/instructors/become-instructor');
        $I->seeCurrentUrlEquals('');     
        $I->dontSee('Get Started');  
    }
    
    
}