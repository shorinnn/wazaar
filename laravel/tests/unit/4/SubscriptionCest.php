<?php
use \UnitTester;

class SubscriptionCest{
    
    public function _before() {
        $this->setupDatabase();
    }
    public function __destruct()
    {
        \DB::disconnect();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
    }
    
    public function subscribeToCourse(UnitTester $I){
        $course = Course::first();
        $course->payment_type = 'subscription';
        $course->updateUniques();
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        
        $I->assertFalse( $student->purchased($course) );
        $I->assertTrue( $student->purchase($course) );
        $purchase = Purchase::where('student_id', $student->id)->first();
        $expires = date('Y-m-d H:i:s', strtotime( date('Y-m-d 00:00:00')." +1 month") );
        $I->assertGreaterThan( $expires, $purchase->subscription_end );
        
        $I->assertNotNull($purchase->subscription_start);
        $I->assertNotNull($purchase->subscription_end);
    }
    
    public function failSubscribeNotSubscribable(UnitTester $I){
        $course = Course::first();
        $I->assertEquals( 'one_time', $course->payment_type );
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        
        $I->assertFalse( $student->purchased($course) );
        $I->assertTrue( $student->purchase($course) );
        $purchase = Purchase::where('student_id', $student->id)->first();
        $I->assertNull($purchase->subscription_start);
        $I->assertNull($purchase->subscription_end);
    }
    
    public function failSubscribeAlreadySubscribed(UnitTester $I){
        $course = Course::first();
        $course->payment_type = 'subscription';
        $course->updateUniques();
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        
        $I->assertFalse( $student->purchased($course) );
        $I->assertTrue( $student->purchase($course) );
        sleep( 2 );
        $I->assertTrue( $student->purchase($course) );
    }
    
    public function listAvailableModules(UnitTester $I){
        $course = Course::first();
        $course->payment_type = 'subscription';
        $course->updateUniques();
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        
        $I->assertFalse( $student->purchased($course) );
        $I->assertTrue( $student->purchase($course) );
        $modules = $course->modules->count();
        $I->assertEquals( 3, $student->subscriptionModules($course)->count() );
        foreach($course->modules as $module){
            $module->created_at = date('2012-01-01 12:12:12');
            $module->updateUniques();
        }
        $I->assertEquals( 0, $student->subscriptionModules($course)->count() );
    }
    
    public function viewLesson(UnitTester $I){
        $course = Course::first();
        $course->payment_type = 'subscription';
        $course->updateUniques();
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        
        $I->assertFalse( $student->purchased($course) );
        $I->assertTrue( $student->purchase($course) );
        $I->assertTrue( $student->isLessonSubscribedTo( $course->modules()->first()->lessons()->first() ) );
    }
    
    public function failViewingLesson(UnitTester $I){
        $course = Course::first();
        $course->payment_type = 'subscription';
        $course->updateUniques();
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        
        $I->assertFalse( $student->purchased($course) );
        $I->assertTrue( $student->purchase($course) );
        
        foreach($course->modules as $module){
            $module->created_at = date('2012-01-01 12:12:12');
            $module->updateUniques();
        }
        
        $I->assertFalse( $student->isLessonSubscribedTo( $course->modules()->first()->lessons()->first() ) );
    }
}
