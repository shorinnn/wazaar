<?php
use \UnitTester;

class AffiliateAgencyCest{
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        AffiliateAgency::boot();
    }
  
    public function createAgency(UnitTester $I){
        $a = new AffiliateAgency( ['name' => 'New Agency'] );
        $I->assertTrue( $a->save() );
    }
    
    public function failReusingName(UnitTester $I){
        $a = new AffiliateAgency( ['name' => 'New Agency'] );
        $I->assertTrue( $a->save() );
        $a = new AffiliateAgency( ['name' => 'New Agency'] );
        $I->assertFalse( $a->save() );
    }
    
    public function getAffiliates(UnitTester $I){
        $count = User::where('affiliate_agency_id', 1)->count();
        $agency = AffiliateAgency::find(1);
        $I->assertEquals( $count, $agency->productAffiliates->count() );
        $I->assertEquals( $count, $agency->ltcAffiliates->count() );
    }
    
    public function getAgencyFromAffiliate(UnitTester $I){
        $affiliate = ProductAffiliate::where('affiliate_agency_id', 1)->first();
        $agency = AffiliateAgency::find(1);
        $I->assertEquals($agency->id, $affiliate->affiliateAgency->id);
    }
    
}
