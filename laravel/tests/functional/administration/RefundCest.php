<?php 
use \FunctionalTester;

class RefundCest{
    
    public function _before(FunctionalTester $I){
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        $I->haveEnabledFilters();
        User::boot();
    }
    
    public function refund(FunctionalTester $I){
        $admin = User::first();
        $I->amLoggedAs($admin);
        $I->seeAuthentication();
        $I->amOnPage('/administration/members/9');
        $I->seeCurrentUrlEquals('/administration/members/9');
        $I->seeNumberOfElements('.refund-purchase-3', 0);
        $I->seeNumberOfElements('.refund-purchase-4', 1);
        $I->dontSee('refunded-4');
        
        $I->seeRecord('purchases',['id' => 4]);
        $I->dontSeeRecord('purchase_refunds',['purchase_id' => 4]);
        
        $I->click('Refund');
        $I->seeNumberOfElements('.refund-purchase-3', 0);
        $I->seeNumberOfElements('.refund-purchase-4', 0);
        $I->see('refunded-4');
        $I->dontSeeRecord('purchases',['id' => 4]);
        $I->seeRecord('purchase_refunds',['purchase_id' => 4]);
    }
    
    public function failRefund(FunctionalTester $I){
        $admin = User::first();
        $I->amLoggedAs($admin);
        $I->seeAuthentication();
        $I->amOnPage('/administration/members/9');
        $I->seeCurrentUrlEquals('/administration/members/9');
        $I->seeNumberOfElements('.refund-purchase-3', 0);
        $I->seeNumberOfElements('.refund-purchase-4', 1);
        $I->dontSee('refunded-4');
        
        $I->seeRecord('purchases',['id' => 4]);
        $I->dontSeeRecord('purchase_refunds',['purchase_id' => 4]);
        
        $I->submitForm('#refund-form-4', [ '_token' => csrf_token(), 'purchase' => 3 ]);
        $I->seeNumberOfElements('.refund-purchase-3', 0);
        $I->seeNumberOfElements('.refund-purchase-4', 1);
        
        $I->dontSee('refunded-3');
        $I->seeRecord('purchases',['id' => 3]);
        $I->dontSeeRecord('purchase_refunds',['purchase_id' => 3]);
    }
    
    public function refundViaAjax(FunctionalTester $I){
        $admin = User::first();
        $I->amLoggedAs($admin);
        $I->seeAuthentication();
        $I->seeRecord('purchases',['id' => 4]);
        $I->dontSeeRecord('purchase_refunds',['purchase_id' => 4]);
        $I->sendAjaxPostRequest('/administration/members/refund', [ '_token' => csrf_token(), 'purchase' => 4 ] );
        $I->dontSeeRecord('purchases',['id' => 4]);
        $I->seeRecord('purchase_refunds',['purchase_id' => 4]);  
    }
    
    public function failRefundViaAjax(FunctionalTester $I){
        $admin = User::first();
        $I->amLoggedAs($admin);
        $I->seeAuthentication();
        $I->seeRecord('purchases',['id' => 3]);
        $I->dontSeeRecord('purchase_refunds',['purchase_id' => 3]);
        $I->sendAjaxPostRequest('/administration/members/refund', [ '_token' => csrf_token(), 'purchase' => 4 ] );
        $I->seeRecord('purchases',['id' => 3]);
        $I->dontSeeRecord('purchase_refunds',['purchase_id' => 3]);  
    }
}
