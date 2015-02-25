<?php
use \UnitTester;

class StudentCest{
    
    public function _before() {
        $this->setupDatabase();
    }

    private function setupDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        Student::boot();
    }
    
    public function getLTCAffiliate(UnitTester $I){
        $student = Student::where('username','student')->first();
        $I->assertEquals(2, $student->ltcAffiliate->id);
    }
    
    public function get2Purchases(UnitTester $I){
        $student = Student::where('username','student')->first();
        $count = Purchase::where('student_id', $student->id)->count();
        $I->assertEquals($count, $student->purchases->count());
    }
    
    public function purchaseNewCourse(UnitTester $I){
        $student = Student::where('username','student')->first();
        $course = Course::find(1);
        $student->purchase($course);
        $student = Student::where('username','student')->first();
        $I->assertTrue( $student->purchased($course) );
    }
    
    public function purchaseIncrementStudentsCount(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $course = Course::find(1);
        $count = $course->student_count;
        $I->assertTrue( $student->purchase( $course ) );
        $student = Student::where('username','student')->first();
        $I->assertTrue( $student->purchased($course) );
        $count++;
        $course = Course::find(1);
        $I->assertEquals($course->student_count, $count );
    }
    
    public function denyDuplicatePurchases(UnitTester $I){
        $student = Student::where('username','student')->first();
        $course = Course::find(1);
        $student->purchase($course);
        $student = Student::where('username','student')->first();
        $I->assertTrue( $student->purchased($course) );
        $student = Student::where('username','student')->first();
        $I->assertFalse( $student->purchase($course) );
    }
    
    public function keepLTCAffiliate(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->ltc_affiliate_id = 5;
        $student->save();
        $I->assertEquals(5, $student->ltc_affiliate_id);
        $course = Course::find(1);
        $student->purchase($course);
        $student = Student::where('username','student')->first();
        $I->assertTrue( $student->purchased($course) );
        $I->assertEquals(5, $student->ltc_affiliate_id);
    }
    
    public function defaultAffiliateToWazaar(UnitTester $I){
        $student = Student::where('username','mac')->first();
        $student->ltc_affiliate_id = 5;
        $student->created_at = '2012-12-12 18:57:26';
        $student->save();
        $I->assertEquals(5, $student->ltc_affiliate_id);
        $I->assertEquals(0, $student->purchases->count());
        $course = Course::find(1);
        $student->purchase($course);
        $student = Student::where('username','mac')->first();
        $I->assertTrue( $student->purchased($course) );
        $I->assertEquals(2, $student->ltc_affiliate_id);
    }
    
    public function storeProductAffiliate(UnitTester $I){
        $student = Student::where('username','student')->first();
        $course = Course::find(1);
        Purchase::where('student_id', $student->id)->delete();
        $student->purchase($course, 5);
        $student = Student::where('username','student')->first();
        $I->assertTrue( $student->purchased($course) );
        $I->assertEquals(2, $student->ltc_affiliate_id);
        $I->assertEquals(5, $student->purchases->first()->product_affiliate_id);
    }
    
    public function saveReferralToDB(UnitTester $I){
        $student = Student::where('username','student')->first();
        $I->assertEquals(0, $student->courseReferrals()->count());
        $student->saveReferral(1,1);
        $I->assertEquals(1, $student->courseReferrals()->count());
    }
    
    public function deleteExpiredReferrals(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student->saveReferral(1,1);
        $student->saveReferral(1,2);
        $I->assertEquals(2, $student->courseReferrals()->count());
        $ref = CourseReferral::find($student->courseReferrals()->first()->id);
        $ref->expires = '2012-12-12 00:00:00';
        $I->assertTrue( $ref->updateUniques() );
        $I->assertEquals(2, $student->courseReferrals()->count());
        $student->restoreReferrals();
        $student = Student::where('username','student')->first();
        $I->assertEquals(1, $student->courseReferrals()->count());
        
    }
    
    public function getUnviewedLesson(UnitTester $I){
        $student = Student::where('username','student')->first();
        $lesson = Lesson::first();
        $I->assertFalse( $student->isLessonViewed($lesson) );
    }
    
    public function viewLesson(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $lesson = Lesson::first();
        $I->assertTrue( $student->purchase( $lesson->module->course ) );
        $I->assertFalse( $student->isLessonViewed($lesson) );
        $I->assertTrue( $student->viewLesson( $lesson ) );
        $student = Student::where('username','student')->first();
        $I->assertTrue( $student->isLessonViewed($lesson) );
    }
    
    public function increaseLessonViewCounterOnce(UnitTester $I){
        $student = Student::where('username','student')->first();
        Purchase::where('student_id', $student->id)->delete();
        $lesson = Lesson::first();
        $counter = ViewedLesson::where('lesson_id', $lesson->id)->where('student_id', $student->id)->count();
        $I->assertEquals(0, $counter);
        $I->assertTrue( $student->purchase( $lesson->module->course ) );
        $I->assertFalse( $student->isLessonViewed($lesson) );
        $I->assertTrue( $student->viewLesson( $lesson ) );
        $student = Student::where('username','student')->first();
        $I->assertTrue( $student->isLessonViewed($lesson) );
        $counter = ViewedLesson::where('lesson_id', $lesson->id)->where('student_id', $student->id)->count();
        $I->assertEquals(1, $counter);
        $I->assertTrue( $student->viewLesson( $lesson ) );
        $counter = ViewedLesson::where('lesson_id', $lesson->id)->where('student_id', $student->id)->count();
        $I->assertEquals(1, $counter);
    }
    
}
