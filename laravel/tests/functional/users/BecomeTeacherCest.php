<?php 
use \FunctionalTester;

class BecomeTeacherCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        $this->users = new UserRepository();    
    }

    

    public function failBecomingTeacherUnauthenticated(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->amOnPage('/become-teacher');
        $I->seeCurrentUrlEquals('/login');
    }
    
    public function becomeTeacher(FunctionalTester $I){
        $user = $this->users->find(2);
        Auth::login($user);
        $I->seeAuthentication();
        $I->amOnPage('/become-teacher');
        $I->see('congrats');
        $user = $this->users->find(2);
        $I->assertEquals(2, $user->roles()->count());
    }
    
    public function failBecomingTeacherAgain(FunctionalTester $I){
        $user = $this->users->find(2);
        Auth::login($user);
        $I->seeAuthentication();
        $I->assertEquals(1, $user->roles()->count());
        $I->amOnPage('/become-teacher');
        $I->see('congrats');
        $user = $I->refreshAuthenticatedUser($user);
        $I->assertEquals(2, $user->roles()->count());
        $user = $I->refreshAuthenticatedUser($user);
        $I->assertTrue($user->hasRole('Teacher'));
        
        $I->amOnPage('/become-teacher');
        $user = $I->refreshAuthenticatedUser($user);
        $I->amOnPage('/become-teacher');
        $user = $I->refreshAuthenticatedUser($user);
        $I->assertEquals(2, $user->roles()->count());
        $I->see('Cannot');        
    }
    
    
}