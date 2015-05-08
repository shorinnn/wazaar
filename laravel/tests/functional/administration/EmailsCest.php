<?php 
use \FunctionalTester;

class EmailsCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }
    
    public function send3Emails(FunctionalTester $I){
        Config::set( 'mail.pretend', true );
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/email/publishers');
        $I->submitForm('#mail-form',[ 'date' => date('d-m-Y'), 'subject' => 'herro', 'content' => 'herro, content here'] );
        $I->see( trans('conversations/general.sent' ).' (3' );
    }
    
    public function send1Email(FunctionalTester $I){
        User::where('username', '!=', 'instructor')->update( ['created_at' => date('Y-m-d') ] );
        Config::set( 'mail.pretend', true );
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/email/publishers');
        $I->submitForm('#mail-form',[ 'date' => date( 'd-m-Y', strtotime('- 2 day') ), 'subject' => 'herro', 'content' => 'herro, content here'] );
        $I->see( trans('conversations/general.sent' ).' (1' );
    }
    
    public function send0Emails(FunctionalTester $I){
        User::whereNotNull('created_at')->update( ['created_at' => date('Y-m-d') ] );
        Config::set( 'mail.pretend', true );
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/email/publishers');
        $I->submitForm('#mail-form',[ 'date' => date( 'd-m-Y', strtotime('- 2 day') ), 'subject' => 'herro', 'content' => 'herro, content here'] );
        $I->see( trans('conversations/general.sent' ).' (0' );
    }
    
    public function failEmailNoSubject(FunctionalTester $I){
        Config::set( 'mail.pretend', true );
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/email/publishers');
        $I->submitForm('#mail-form',[ 'date' => date( 'd-m-Y', strtotime('- 2 day') ), 'subject' => '', 'content' => 'herro, content here'] );
        $I->dontSee( trans('conversations/general.sent' ).' (' );
        $I->see( trans('crud/errors.error_occurred' ) );
    }
    
    public function failEmailNoContent(FunctionalTester $I){
        Config::set( 'mail.pretend', true );
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/email/publishers');
        $I->submitForm('#mail-form',[ 'date' => date( 'd-m-Y', strtotime('- 2 day') ), 'subject' => 'Subject', 'content' => ''] );
        $I->dontSee( trans('conversations/general.sent' ).' (' );
        $I->see( trans('crud/errors.error_occurred' ) );
    }
    
    public function failEmailNoDate(FunctionalTester $I){
        Config::set( 'mail.pretend', true );
        $user = User::where('username', 'superadmin')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/administration/email/publishers');
        $I->submitForm('#mail-form',[ 'date' => '', 'subject' => 'Subject', 'content' => 'Content'] );
        $I->dontSee( trans('conversations/general.sent' ).' (' );
        $I->see( trans('crud/errors.error_occurred' ) );
    }
    
    
}