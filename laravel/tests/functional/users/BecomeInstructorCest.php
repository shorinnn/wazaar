<?php 
use \FunctionalTester;

class BecomeInstructorCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        $this->users = new UserRepository();    
    }

    

    public function failBecomingInstructorUnauthenticated(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->amOnPage('/become-instructor');
        $I->seeCurrentUrlEquals('/login');
    }
    
    public function becomeInstructor(FunctionalTester $I){
        $user =  User::where('username','student')->first();
        Auth::login($user);
        $I->assertEquals(1, $user->roles()->count());
        $I->seeAuthentication();
        $I->amOnPage('/become-instructor');
        $I->see('congrats');
        $user = User::where('username','student')->first();
        $I->assertEquals(2, $user->roles()->count());
    }
    
    public function failBecomingInstructorAgain(FunctionalTester $I){
        $user =  User::where('username','student')->first();
        Auth::login($user);
        $I->seeAuthentication();
        $I->assertEquals(1, $user->roles()->count());
        $I->amOnPage('/become-instructor');
        $I->see('congrats');
        $user = $I->refreshAuthenticatedUser($user);
        $I->assertEquals(2, $user->roles()->count());
        $user = $I->refreshAuthenticatedUser($user);
        $I->assertTrue($user->hasRole('Instructor'));
        
        $I->amOnPage('/become-instructor');
        $user = $I->refreshAuthenticatedUser($user);
        $I->amOnPage('/become-instructor');
        $user = $I->refreshAuthenticatedUser($user);
        $I->assertEquals(2, $user->roles()->count());
        $I->see('Cannot');        
    }
    
    
}