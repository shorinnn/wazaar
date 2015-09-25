    <?php
use \UnitTester;

class DiscussionCest{
    
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
    
    public function afailUserDoesntOwnLesson(UnitTester $I){
        DB::table('purchases')->delete();
        $title = 'Test';
        $student = Student::where('username','student')->first();
        $lesson =  Lesson::first();
        $discussion = new LessonDiscussion();
        $discussion->student_id = $student->id;
        $discussion->lesson_id = $lesson->id;
        $discussion->title = $title;
        $I->assertFalse( $student->purchased($lesson) );
        $I->assertFalse( $student->purchased($lesson->module->course) );
        $I->assertFalse( $discussion->save() );
    } 

    
    public function failUserDoesntExist(UnitTester $I){
        $title = 'Test';
        $discussion = new LessonDiscussion();
        $discussion->student_id = 99999;
        $discussion->lesson_id = Lesson::first()->id;
        $discussion->title = $title;
        $I->assertFalse( $discussion->save() );
    }
    
    public function failUserLessonDoesntExist(UnitTester $I){
        $title = 'Test';
        $discussion = new LessonDiscussion();
        $discussion->student_id = User::first()->id;
        $discussion->lesson_id = 99999;
        $discussion->title = $title;
        $I->assertFalse( $discussion->save() );
    }
    
    public function postUserOwnsLesson(UnitTester $I){
        DB::table('purchases')->delete();
        $lesson =  Lesson::first();
        $student = Student::where('username','student')->first();
        $purchase = Purchase::create( [ 'student_id' => $student->id, 'product_id' => $lesson->id, 'product_type' => 'Lesson' ] );
        $title = 'Test';
        $I->assertNotEquals(null, $purchase);
        $discussion = new LessonDiscussion();
        $discussion->student_id = $student->id;
        $discussion->lesson_id = $lesson->id;
        $discussion->course_id = $lesson->module->course->id;
        $discussion->title = $title;
        $I->assertTrue( $student->purchased($lesson) );
        $I->assertFalse( $student->purchased($lesson->module->course) );
        $I->assertTrue( $discussion->save() );
    }
    
    public function postUserOwnsCourse(UnitTester $I){
        $lesson =  Lesson::first();
        $student = Student::where('username','student')->first();
        $title = 'Test';
        $discussion = new LessonDiscussion();
        $discussion->student_id = $student->id;
        $discussion->lesson_id = $lesson->id;
        $discussion->course_id = $lesson->module->course->id;
        $discussion->title = $title;
        $I->assertFalse( $student->purchased($lesson) );
        $I->assertTrue( $student->purchased($lesson->module->course) );
        $I->assertTrue( $discussion->save() );
    }
    
    public function noVoteUserDoesntOwnLesson(UnitTester $I){ 
        DB::table('purchases')->delete();
        $lesson =  Lesson::first();
        $student = Student::where('username','student')->first();
        $purchase = Purchase::create( [ 'student_id' => $student->id, 'product_id' => $lesson->id, 'product_type' => 'Lesson' ] );
        $title = 'Test';
        $discussion = new LessonDiscussion();
        $discussion->student_id = $student->id;
        $discussion->lesson_id = $lesson->id;
        $discussion->course_id = $lesson->module->course->id;
        $discussion->title = $title;
        $I->assertTrue( $student->purchased($lesson) );
        $I->assertFalse( $student->purchased($lesson->module->course) );
        $I->assertNotEquals(false, $discussion->save() );
        
        $student = Student::where('username','superadmin')->first();
        $I->assertEquals(false, $discussion->vote( $student->id, 'up') );
        $discussion = LessonDiscussion::find($discussion->id);
        $I->assertEquals( 0, $discussion->upvotes );
    }
    
    public function voteUserOwnsLesson(UnitTester $I){
        DB::table('purchases')->delete();
        $lesson =  Lesson::first();
        $student = Student::where('username','student')->first();
        $purchase = Purchase::create( [ 'student_id' => $student->id, 'product_id' => $lesson->id, 'product_type' => 'Lesson' ] );
        $title = 'Test';
        $discussion = new LessonDiscussion();
        $discussion->student_id = $student->id;
        $discussion->lesson_id = $lesson->id;
        $discussion->course_id = $lesson->module->course->id;
        $discussion->title = $title;
        $I->assertTrue( $student->purchased($lesson) );
        $I->assertFalse( $student->purchased($lesson->module->course) );
        $I->assertNotEquals(false, $discussion->save() );
        
        $I->assertNotEquals(false, $discussion->vote( $student->id, 'up') );
        $discussion = LessonDiscussion::find($discussion->id);
        $I->assertEquals( 1, $discussion->upvotes );
    }
    

    
    public function voteOnlyOnce(UnitTester $I){
        DB::table('purchases')->delete();
        $lesson =  Lesson::first();
        $student = Student::where('username','student')->first();
        $purchase = Purchase::create( [ 'student_id' => $student->id, 'product_id' => $lesson->id, 'product_type' => 'Lesson' ] );
        $title = 'Test';
        $discussion = new LessonDiscussion();
        $discussion->student_id = $student->id;
        $discussion->lesson_id = $lesson->id;
        $discussion->course_id = $lesson->module->course->id;
        $discussion->title = $title;
        $I->assertTrue( $student->purchased($lesson) );
        $I->assertFalse( $student->purchased($lesson->module->course) );
        $I->assertNotEquals(false, $discussion->save() );
        
        $I->assertNotEquals(false, $discussion->vote( $student->id, 'up') );
        $discussion = LessonDiscussion::find($discussion->id);
        $I->assertEquals( 1, $discussion->upvotes );
        
        $I->assertNotEquals(false, $discussion->vote( $student->id, 'up') );
        $discussion = LessonDiscussion::find($discussion->id);
        $I->assertEquals( 1, $discussion->upvotes );
        
        $I->assertNotEquals(false, $discussion->vote( $student->id, 'down') );
        $discussion = LessonDiscussion::find($discussion->id);
        $I->assertEquals( -1, $discussion->upvotes );
        
        $I->assertNotEquals(false, $discussion->vote( $student->id, 'down') );
        $discussion = LessonDiscussion::find($discussion->id);
        $I->assertEquals( -1, $discussion->upvotes );
    }
    
 
}