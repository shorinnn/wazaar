<?php 
use \FunctionalTester;

class ForgotPasswordCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        $this->users = new UserRepository();
    }

    public function pageHasEmailInput(FunctionalTester $I) {
        $I->amOnPage('/forgot-password');
        $I->seeNumberOfElements('input[name=email]', 1);
    }

    public function submitNoUserHasErrors(FunctionalTester $I) {
        $I->amOnPage('/forgot-password');
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('#forgot-form', ['email' => '']);
        $I->see('User not found');
    }

    public function submitUserSuccessfully(FunctionalTester $I) {
        $user = $this->users->find(2);
        $oldSocial = $user->social_confirmation;
        $I->amOnPage('/forgot-password');
        $I->seeNumberOfElements('input[name=email]', 1);
        $I->submitForm('#forgot-form', ['email' => 'wazaarStudent@mailinator.com']);
        $I->see('The information regarding');
    }
}
