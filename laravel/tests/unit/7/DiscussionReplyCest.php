<?php
use \UnitTester;

class DiscussionReplyCest{
    public $discussion;
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
    
    private function _createDiscussion(){
        $lesson =  Lesson::first();
        $student = Student::where('username','student')->first();
        $title = 'Test';
        $discussion = new LessonDiscussion();
        $discussion->student_id = $student->id;
        $discussion->lesson_id = $lesson->id;
        $discussion->course_id = $lesson->module->course->id;
        $discussion->title = $title;
        $discussion->save();
        $this->discussion = $discussion;
    }
    
    public function afailStudentDoesntOwnLesson(UnitTester $I){
        DB::table('purchases')->delete();
        $student = Student::where('username','student')->first();
        $lesson =  Lesson::first();
        $I->assertFalse( $student->purchased($lesson) );
        $I->assertFalse( $student->purchased($lesson->module->course) );
        $this->_createDiscussion();
        
        $reply = new LessonDiscussionReply([
            'lesson_discussion_id' => $this->discussion->id,
            'student_id' => $student->id,
            'content' => 'content!'
        ]);
        $I->assertFalse( $reply->save() );
    }

    
    public function failStudentDoesntExist(UnitTester $I){
        $this->_createDiscussion();
        $reply = new LessonDiscussionReply([
            'lesson_discussion_id' => $this->discussion->id,
            'student_id' => 99999,
            'content' => 'content!'
        ]);
        $I->assertFalse( $reply->save() );
    }
    
    public function failDiscussionDoesntExist(UnitTester $I){
        $reply = new LessonDiscussionReply([
            'lesson_discussion_id' => 99999,
            'student_id' => Student::where('username','student')->first()->id,
            'content' => 'content!'
        ]);
        $I->assertFalse( $reply->save() );
    }
    
    
    
    public function passStudentOwnsLesson(UnitTester $I){###
        DB::table('purchases')->delete();
        $lesson =  Lesson::first();
        $student = Student::where('username','student')->first();
        $purchase = Purchase::create( [ 'student_id' => $student->id, 'product_id' => $lesson->id, 'product_type' => 'Lesson' ] );
        
        $I->assertTrue( $student->purchased($lesson) );
        $I->assertFalse( $student->purchased($lesson->module->course) );
        $this->_createDiscussion();
        
        $reply = new LessonDiscussionReply([
            'lesson_discussion_id' => $this->discussion->id,
            'student_id' => Student::where('username','student')->first()->id,
            'content' => 'content!'
        ]);
        $I->assertTrue( $reply->save() );
    }
    
    public function passStudentOwnsCourse(UnitTester $I){###
        $lesson =  Lesson::first();
        $student = Student::where('username','student')->first();
        $this->_createDiscussion();
        $I->assertFalse( $student->purchased($lesson) );
        $I->assertTrue( $student->purchased($lesson->module->course) );
        
        $reply = new LessonDiscussionReply([
            'lesson_discussion_id' => $this->discussion->id,
            'student_id' => Student::where('username','student')->first()->id,
            'content' => 'content!'
        ]);
        $I->assertTrue( $reply->save() );
    }
    
        
    public function noVoteUserDoesntOwnLesson(UnitTester $I){###
        DB::table('purchases')->delete();
        $lesson =  Lesson::first();
        $student = Student::where('username','student')->first();
        $purchase = Purchase::create( [ 'student_id' => $student->id, 'product_id' => $lesson->id, 'product_type' => 'Lesson' ] );
        $title = 'Test';
        $this->_createDiscussion();
        $reply = new LessonDiscussionReply([
            'lesson_discussion_id' => $this->discussion->id,
            'student_id' => $student->id,
            'content' => 'content!'
        ]);
        $I->assertTrue( $reply->save() );
        
        $student = Student::where('username','superadmin')->first();
        $I->assertEquals(false, $reply->vote( $student->id, 'up') );
        $reply = LessonDiscussionReply::find( $reply->id );
        $I->assertEquals( 0, $reply->upvotes );
    }
    
    public function voteUserOwnsLesson(UnitTester $I){###
        DB::table('purchases')->delete();
        $lesson =  Lesson::first();
        $student = Student::where('username','student')->first();
        $purchase = Purchase::create( [ 'student_id' => $student->id, 'product_id' => $lesson->id, 'product_type' => 'Lesson' ] );
        $title = 'Test';
        $this->_createDiscussion();
        $reply = new LessonDiscussionReply([
            'lesson_discussion_id' => $this->discussion->id,
            'student_id' => $student->id,
            'content' => 'content!'
        ]);
        $I->assertTrue( $reply->save() );
        
        
        $I->assertNotEquals(false, $reply->vote( $student->id, 'up') );
        $reply = LessonDiscussionReply::find( $reply->id );
        $I->assertEquals( 1, $reply->upvotes );
    }
    

    
    public function voteOnlyOnce(UnitTester $I){###
        DB::table('purchases')->delete();
        $lesson =  Lesson::first();
        $student = Student::where('username','student')->first();
        $purchase = Purchase::create( [ 'student_id' => $student->id, 'product_id' => $lesson->id, 'product_type' => 'Lesson' ] );
        $title = 'Test';
        $this->_createDiscussion();
        $reply = new LessonDiscussionReply([
            'lesson_discussion_id' => $this->discussion->id,
            'student_id' => $student->id,
            'content' => 'content!'
        ]);
        $I->assertTrue( $reply->save() );
        
        
        $I->assertNotEquals(false, $reply->vote( $student->id, 'up') );
        $reply = LessonDiscussionReply::find( $reply->id );
        $I->assertEquals( 1, $reply->upvotes );
        
        $I->assertNotEquals(false, $reply->vote( $student->id, 'up') );
        $reply = LessonDiscussionReply::find( $reply->id );
        $I->assertEquals( 1, $reply->upvotes );
        
        $I->assertNotEquals(false, $reply->vote( $student->id, 'down') );
        $reply = LessonDiscussionReply::find( $reply->id );
        $I->assertEquals( -1, $reply->upvotes );
        
        $I->assertNotEquals(false, $reply->vote( $student->id, 'down') );
        $reply = LessonDiscussionReply::find( $reply->id );
        $I->assertEquals( -1, $reply->upvotes );
    }
}