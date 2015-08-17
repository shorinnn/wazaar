<?php
use \UnitTester;

class PrivateMessageCest{
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
        DB::table('private_messages')->truncate();
        PrivateMessage::boot();
    }
    
    public function createAskTeacherMessage(UnitTester $I){
        User::boot();
        Student::boot();
        Instructor::boot();
        $student = Student::where('username','student')->first();
        $instructor = Instructor::where('username','instructor')->first();
        
        $paymentData['successData']['REF'] = '123';
        $paymentData['successData']['processor_fee'] = '123';
        $paymentData['successData']['tax'] = '123';
        $paymentData['successData']['balance_used'] = '0';
        $paymentData['successData']['balance_transaction_id'] = '0';
        $student->purchase( $instructor->courses()->first(), null, $paymentData);
        
        $I->assertTrue( $student->purchased( $instructor->courses()->first() ) );
        $message = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $instructor->id, 'content' => 'Question sir!']);
        $message->type = 'ask_teacher';
        $message->course_id = $instructor->courses()->first()->id;
        $I->assertTrue( $message->save() );
        
        $I->assertEquals( $student->id, $message->sender->id );
        $I->assertEquals( $instructor->id, $message->recipient->id );
        $I->assertEquals( $instructor->courses()->first()->id, $message->course->id );
        $I->assertEquals( 0, $message->replies->count() );
        
        
        $I->assertEquals( 1, $student->sentMessages->count() );
        $I->assertEquals( 0, $student->receivedMessages()->count() );
        $I->assertEquals( 0, $instructor->sentMessages->count() );
        $I->assertEquals( 1, $instructor->receivedMessages()->count() );
    }
    
    public function failAskTeacherMessageCourseDisabledIt(UnitTester $I){
        User::boot();
        Student::boot();
        Instructor::boot();
        $student = Student::where('username','student')->first();
        $instructor = Instructor::where('username','instructor')->first();
        $course = $instructor->courses()->first();
        $course->ask_teacher = 'disabled';
        $course->updateUniques();
        $paymentData['successData']['REF'] = '123';
        $paymentData['successData']['processor_fee'] = '123';
        $paymentData['successData']['tax'] = '123';
        $paymentData['successData']['balance_used'] = '0';
        $paymentData['successData']['balance_transaction_id'] = '0';
        $student->purchase( $course, null, $paymentData);
        
        $I->assertTrue( $student->purchased( $course ) );
        $message = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $instructor->id, 'content' => 'Question sir!']);
        $message->type = 'ask_teacher';
        $message->course_id = $course->id;
        $I->assertFalse( $message->save() );
    }
    
    public function replyToAskTeacherMessage(UnitTester $I){
        User::boot();
        Student::boot();
        Instructor::boot();
        $student = Student::where('username','student')->first();
        $instructor = Instructor::where('username','instructor')->first();
        
        $paymentData['successData']['REF'] = '123';
        $paymentData['successData']['processor_fee'] = '123';
        $paymentData['successData']['tax'] = '123';
        $paymentData['successData']['balance_used'] = '0';
        $paymentData['successData']['balance_transaction_id'] = '0';
        $student->purchase( $instructor->courses()->first(), null, $paymentData);
        
        $message = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $instructor->id, 'content' => 'Question sir!']);
        $message->type = 'ask_teacher';
        $message->course_id = $instructor->courses()->first()->id;
        $I->assertTrue( $message->save() );
        $I->assertEquals( $student->id, $message->sender->id );
        $I->assertEquals( $instructor->id, $message->recipient->id );
        $I->assertEquals( $instructor->courses()->first()->id, $message->course->id );
        $I->assertEquals( 0, $message->replies->count() );
        
        $reply = new PrivateMessage([ 'sender_id' => $instructor->id, 'recipient_id' => $student->id, 'content' => 'Reply sir!']);
        $reply->type = 'ask_teacher';
        $reply->course_id = $instructor->courses()->first()->id;
        $reply->thread_id = 1;
        $reply->reply_to = $message->id;
        $I->assertTrue( $reply->save() );
        
        $I->assertEquals( 1, $student->sentMessages->count() );
        $I->assertEquals( 1, $student->receivedMessages()->count() );
        $I->assertEquals( 1, $instructor->sentMessages->count() );
        $I->assertEquals( 1, $instructor->receivedMessages()->count() );
        $message = PrivateMessage::first();
        $I->assertEquals( 1, $message->replies->count() );
    }
    
    public function replyToAskTeacherMessageByAssigned(UnitTester $I){
        User::boot();
        Student::boot();
        Instructor::boot();
        $student = Student::where('username','student')->first();
        $instructor = Instructor::where('username','instructor')->first();
        $assigned = Instructor::where('username','second_instructor')->first();
        
        $paymentData['successData']['REF'] = '123';
        $paymentData['successData']['processor_fee'] = '123';
        $paymentData['successData']['tax'] = '123';
        $paymentData['successData']['balance_used'] = '0';
        $paymentData['successData']['balance_transaction_id'] = '0';
        $student->purchase( $instructor->courses()->first(), null, $paymentData);
        
        $course = $instructor->courses()->first();
        $course->assigned_instructor_id = $assigned->id;
        $I->assertTrue( $course->updateUniques() );
        
        $message = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $assigned->id, 'content' => 'Question sir!']);
        $message->type = 'ask_teacher';
        $message->course_id = $course->id;
        $I->assertTrue( $message->save() );
        $I->assertEquals( $student->id, $message->sender->id );
        $I->assertEquals( $assigned->id, $message->recipient->id );
        $I->assertEquals( 0, $message->replies->count() );
        
        $reply = new PrivateMessage([ 'sender_id' => $assigned->id, 'recipient_id' => $student->id, 'content' => 'Reply from assigned, sir!']);
        $reply->type = 'ask_teacher';
        $reply->course_id = $course->id;
        $reply->thread_id = 1;
        $reply->reply_to = $message->id;
        $I->assertTrue( $reply->save() );
        
        $I->assertEquals( 1, $student->sentMessages->count() );
        $I->assertEquals( 1, $student->receivedMessages()->count() );
        $I->assertEquals( 1, $assigned->sentMessages->count() );
        $I->assertEquals( 1, $assigned->receivedMessages()->count() );
        $message = PrivateMessage::first();
        $I->assertEquals( 1, $message->replies->count() );
    }
    
    public function failReplyToAskTeacherMessageByAssigned(UnitTester $I){
        User::boot();
        Student::boot();
        Instructor::boot();
        $student = Student::where('username','student')->first();
        $instructor = Instructor::where('username','instructor')->first();
        $assigned = Instructor::where('username','second_instructor')->first();
        $course = $instructor->courses()->first();
        
        $paymentData['successData']['REF'] = '123';
        $paymentData['successData']['processor_fee'] = '123';
        $paymentData['successData']['tax'] = '123';
        $paymentData['successData']['balance_used'] = '0';
        $paymentData['successData']['balance_transaction_id'] = '0';
        $student->purchase( $instructor->courses()->first(), null, $paymentData);
        
        $message = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $assigned->id, 'content' => 'Question sir!']);
        $message->type = 'ask_teacher';
        $message->course_id = $course->id;
        $I->assertFalse( $message->save() );
        $I->assertEquals( $student->id, $message->sender->id );
        $I->assertEquals( $assigned->id, $message->recipient->id );
        $I->assertEquals( 0, $message->replies->count() );
        
        $reply = new PrivateMessage([ 'sender_id' => $assigned->id, 'recipient_id' => $student->id, 'content' => 'Reply from assigned, sir!']);
        $reply->type = 'ask_teacher';
        $reply->course_id = $course->id;
        $reply->thread_id = 1;
        $reply->reply_to = $message->id;
        $I->assertFalse( $reply->save() );
        
        $I->assertEquals( 0, $student->sentMessages->count() );
        $I->assertEquals( 0, $student->receivedMessages()->count() );
        $I->assertEquals( 0, $assigned->sentMessages->count() );
        $I->assertEquals( 0, $assigned->receivedMessages()->count() );
    }
    
    public function failReplyToTeacherWrongSender(UnitTester $I){
        $student = Student::where('username','student')->first();
        $instructor = Instructor::where('username','instructor')->first();
        
        $paymentData['successData']['REF'] = '123';
        $paymentData['successData']['processor_fee'] = '123';
        $paymentData['successData']['tax'] = '123';
        $paymentData['successData']['balance_used'] = '0';
        $paymentData['successData']['balance_transaction_id'] = '0';
        $student->purchase( $instructor->courses()->first(), null, $paymentData);
        
        $message = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $instructor->id, 'content' => 'Question sir!']);
        $message->type = 'ask_teacher';
        $message->course_id = $instructor->courses()->first()->id;
        $I->assertTrue( $message->save() );
        
        $reply = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $student->id, 'content' => 'Reply sir!']);
        $reply->type = 'ask_teacher';
        $reply->course_id = $instructor->courses()->first()->id;
        $reply->thread_id = 1;
        $reply->reply_to = $message->id;
        $I->assertFalse( $reply->save() );
    }
    
    public function sendTeacherMassMessage(UnitTester $I){
        $instructor = Instructor::where('username','instructor')->first();
        $message = new PrivateMessage([ 'sender_id' => $instructor->id, 'content' => 'Mass Message sir!']);
        $message->type = 'mass_message';
        $message->course_id = $instructor->courses()->first()->id;
        $I->assertTrue( $message->save() );
    }
    
    public function sendTeacherMassMessageFromAssigned(UnitTester $I){
        $instructor = Instructor::where('username','instructor')->first();
        $assigned = Instructor::where('username','second_instructor')->first();
        $course = $instructor->courses()->first();
        $course->assigned_instructor_id = $assigned->id;
        $I->assertTrue( $course->updateUniques() );
        $message = new PrivateMessage([ 'sender_id' => $assigned->id, 'content' => 'Mass Message sir!']);
        $message->type = 'mass_message';
        $message->course_id = $course->id;
        $I->assertTrue( $message->save() );
    }
    
    public function failSendTeacherMassMessageFromAssigned(UnitTester $I){
        $instructor = Instructor::where('username','instructor')->first();
        $assigned = Instructor::where('username','second_instructor')->first();
        $course = $instructor->courses()->first();
        $message = new PrivateMessage([ 'sender_id' => $assigned->id, 'content' => 'Mass Message sir!']);
        $message->type = 'mass_message';
        $message->course_id = $course->id;
        $I->assertFalse( $message->save() );
    }
    
    public function failMassMessageWrongCourse(UnitTester $I){
        $instructor = Instructor::where('username','instructor')->first();
        $message = new PrivateMessage([ 'sender_id' => $instructor->id, 'content' => 'Mass Message sir!']);
        $message->type = 'mass_message';
        $message->course_id = 222;
        $I->assertFalse( $message->save() );
    }
    
    public function failReplyMassMessage(UnitTester $I){
        $instructor = Instructor::where('username','instructor')->first();
        $message = new PrivateMessage([ 'sender_id' => $instructor->id, 'content' => 'Mass Message sir!']);
        $message->type = 'mass_message';
        $message->course_id = $instructor->courses()->first()->id;
        $I->assertTrue( $message->save() );
        
        $student = Student::where('username','student')->first();
        $reply = new PrivateMessage([ 'sender_id' => $instructor->id, 'recipient_id' => $student->id, 'content' => 'Reply sir!']);
        $reply->type = 'mass_message';
        $reply->course_id = $instructor->courses()->first()->id;
        $reply->thread_id = 1;
        $reply->reply_to = $message->id;
        $I->assertFalse( $reply->save() );
    }
    
    public function messageOtherStudent(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student2 = Student::where('username', 'sorin')->first();
        $reply = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $student2->id, 'content' => 'Test']);
        $reply->type = 'student_conversation';
        $I->assertTrue( $reply->save() );
        
    }
    public function replyToMessageOtherStudent(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student2 = Student::where('username', 'sorin')->first();
        $reply = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $student2->id, 'content' => 'Test']);
        $reply->type = 'student_conversation';
        $I->assertTrue( $reply->save() );
        
        $reply = new PrivateMessage([ 'sender_id' => $student2->id, 'recipient_id' => $student->id, 'content' => 'Test Reply']);
        $I->assertTrue( $reply->save() );
    }
    
    public function countAllStudentMessages(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student2 = Student::where('username', 'sorin')->first();
        $student3 = Student::where('username', 'mac')->first();
        $reply = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $student2->id, 'content' => 'Test']);
        $reply->type = 'student_conversation';
        $I->assertTrue( $reply->save() );
        $reply = new PrivateMessage([ 'sender_id' => $student3->id, 'recipient_id' => $student2->id, 'content' => 'Test']);
        $reply->type = 'student_conversation';
        $I->assertTrue( $reply->save() );
        
        $I->assertEquals( 2, $student2->receivedMessages()->count() );
    }
    
    public function countAllUnreadStudentMessages(UnitTester $I){
        $student = Student::where('username','student')->first();
        $student2 = Student::where('username', 'sorin')->first();
        DB::table('purchases')->where('student_id', 3)->update(['student_id' => $student2->id]);
        $student3 = Student::where('username', 'mac')->first();
        $reply = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $student2->id, 'content' => 'Test']);
        $reply->type = 'student_conversation';
        $I->assertTrue( $reply->save() );
        $reply = new PrivateMessage([ 'sender_id' => $student3->id, 'recipient_id' => $student2->id, 'content' => 'Test']);
        $reply->type = 'student_conversation';
        $reply->status = 'read';
        $I->assertTrue( $reply->save() );
        
        $instructor = Instructor::where('username','instructor')->first();
        $message = new PrivateMessage([ 'sender_id' => $instructor->id, 'content' => 'Mass Message sir!']);
        $message->type = 'mass_message';
        $message->course_id = $student2->purchases->first()->product_id;
        $I->assertTrue( $message->save() );
        
        $instructor = Instructor::where('username','instructor')->first();
        $message = new PrivateMessage([ 'sender_id' => $instructor->id, 'content' => 'Mass Message sir, marked as read']);
        $message->type = 'mass_message';
        $message->course_id = $student2->purchases->first()->product_id;
        $I->assertTrue( $message->save() );
        
        $status = new PrivateMessagesMassStatus( [ 'private_message_id' => $message->id, 'recipient_id' => $student2->id, 'status' => 'read' ] );
        $I->assertTrue( $status->save() );
        
        $I->assertEquals( 2, $student2->receivedMessages()->unread( $student2->id )->count() );
        $I->assertEquals( 0, $student3->receivedMessages()->unread( $student3->id )->count() );
    }
    
    public function countAllTeacherMessages(UnitTester $I){
        $student = Student::where('username','student')->first();
        $instructor = Instructor::where('username','instructor')->first();
        
        $paymentData['successData']['REF'] = '123';
        $paymentData['successData']['processor_fee'] = '123';
        $paymentData['successData']['tax'] = '123';
        $paymentData['successData']['balance_used'] = '0';
        $paymentData['successData']['balance_transaction_id'] = '0';
        $student->purchase( $instructor->courses()->first(), null, $paymentData);
        
        $message = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $instructor->id, 'content' => 'Question sir!']);
        $message->type = 'ask_teacher';
        $message->course_id = $instructor->courses()->first()->id;
        $I->assertTrue( $message->save() );
        
        $reply = new PrivateMessage([ 'sender_id' => $instructor->id, 'recipient_id' => $student->id, 'content' => 'Reply sir!']);
        $reply->type = 'ask_teacher';
        $reply->course_id = $instructor->courses()->first()->id;
        $reply->thread_id = 1;
        $reply->reply_to = $message->id;
        $r2 = $reply->reply_to + 1;
        $I->assertTrue( $reply->save() );
        $reply = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $instructor->id, 'content' => 'Reply sir! 2']);
        $reply->type = 'ask_teacher';
        $reply->course_id = $instructor->courses()->first()->id;
        $reply->thread_id = 1;
        $reply->reply_to = $r2;
        $I->assertTrue( $reply->save() );
        
        $I->assertEquals( 2, $instructor->receivedMessages()->count() );
    }
    
    public function countAllUnreadTeacherMessages(UnitTester $I){
        $student = Student::where('username','student')->first();
        $instructor = Instructor::where('username','instructor')->first();
        
        $paymentData['successData']['REF'] = '123';
        $paymentData['successData']['processor_fee'] = '123';
        $paymentData['successData']['tax'] = '123';
        $paymentData['successData']['balance_used'] = '0';
        $paymentData['successData']['balance_transaction_id'] = '0';
        $student->purchase( $instructor->courses()->first(), null, $paymentData);
        
        $message = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $instructor->id, 'content' => 'Question sir!']);
        $message->type = 'ask_teacher';
        $message->course_id = $instructor->courses()->first()->id;
        $I->assertTrue( $message->save() );
        
        $reply = new PrivateMessage([ 'sender_id' => $instructor->id, 'recipient_id' => $student->id, 'content' => 'Reply sir!']);
        $reply->type = 'ask_teacher';
        $reply->course_id = $instructor->courses()->first()->id;
        $reply->thread_id = 1;
        $reply->reply_to = $message->id;
        $r2 = $message->id + 1;
        $I->assertTrue( $reply->save() );
        $reply = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $instructor->id, 'content' => 'Reply sir! 2']);
        $reply->type = 'ask_teacher';
        $reply->course_id = $instructor->courses()->first()->id;
        $reply->thread_id = 1;
        $reply->reply_to = $r2;
        $reply->status = 'read';
        $I->assertTrue( $reply->save() );
        
        $I->assertEquals( 1, $instructor->receivedMessages()->unread( $instructor->id )->count() );
    }
  
   
}
