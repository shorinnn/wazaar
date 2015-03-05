<?php
use \UnitTester;

class ConversationCest{
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
        Conversation::boot();
    }
    
    public function addCommentToLesson(UnitTester $I){
        $student = Student::where('username', 'student')->first();
        $lesson = Course::find(5)->modules()->first()->lessons()->first();
        $I->assertEquals(0, $lesson->comments->count());
        $conv = new Conversation(['poster_id' => $student->id, 'lesson_id' => $lesson->id, 'content' => 'content' ]);
        $conv->save();
        $lesson = Course::find(5)->modules()->first()->lessons()->first();
        $I->assertEquals(1, $lesson->comments->count());
    }
    
    public function addReplyToComment(UnitTester $I){
        $student = Student::where('username', 'student')->first();
        $lesson = Course::find(5)->modules()->first()->lessons()->first();
        $I->assertEquals(0, $lesson->comments->count());
        $conv = new Conversation(['poster_id' => $student->id, 'lesson_id' => $lesson->id, 'content' => 'content' ]);
        $conv->save();
        $reply = new Conversation(['poster_id' => $student->id, 'lesson_id' => $lesson->id, 'content' => 'tis reply', 'reply_to' => $conv->id ]);
        $reply->save();
        $lesson = Course::find(5)->modules()->first()->lessons()->first();
        $I->assertEquals( 2, $lesson->comments->count() );
        $I->assertEquals( 1, Conversation::find($conv->id)->replies()->count() );
    }
    
    public function addReplyToReply(UnitTester $I){
        $student = Student::where('username', 'student')->first();
        $lesson = Course::find(5)->modules()->first()->lessons()->first();
        $I->assertEquals(0, $lesson->comments->count());
        $conv = new Conversation(['poster_id' => $student->id, 'lesson_id' => $lesson->id, 'content' => 'content' ]);
        $conv->save();
        $reply = new Conversation(['poster_id' => $student->id, 'lesson_id' => $lesson->id, 'content' => 'tis reply', 'reply_to' => $conv->id ]);
        $reply->save();
        $another_reply = new Conversation(['poster_id' => $student->id, 'lesson_id' => $lesson->id, 'content' => 'tis reply', 'reply_to' => $conv->id,
            'original_reply_to' => $reply->id ]);
        $another_reply->save();
        $lesson = Course::find(5)->modules()->first()->lessons()->first();
        $I->assertEquals( 3, $lesson->comments->count() );
        $I->assertEquals( 2, Conversation::find($conv->id)->replies()->count() );
        $I->assertEquals( 1, Conversation::find($another_reply->id)->original()->count() );
        $I->assertEquals( 0, Conversation::find($reply->id)->original()->count() );
    }
    
        
}