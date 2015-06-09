<?php 
use \FunctionalTester;

class AssignedInstructorCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        $student = Student::where('username','student')->first();
        $lesson = Lesson::first();
        $data = [];
        $data['successData']['REF'] = '123';
        $data['successData']['processor_fee'] = '5';
        $data['successData']['tax'] = '10';
        $data['successData']['balance_used'] = '10';
        $data['successData']['balance_transaction_id'] = '0';
        $student->purchase( $lesson->module->course, null, $data );
    }

    public function seeAskTeacherMessage(FunctionalTester $I){
        $student = Student::where('username','student')->first();
        $instructor = Instructor::where('username','instructor')->first();
        $assigned = Instructor::where('username','second_instructor')->first();
        $course = $instructor->courses()->first();
        $course->assigned_instructor_id = $assigned->id;
        $I->assertTrue( $course->updateUniques() );
        
        $message = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $assigned->id, 'content' => 'Question sir!']);
        $message->type = 'ask_teacher';
        $message->course_id = $course->id;
        $I->assertTrue( $message->save() );
        
        $I->amLoggedAs($assigned);
        $I->amOnPage('/private-messages');
        
        $I->see("Question sir!");
        
    }
    
    public function notSeeAskTeacherMessageIfNotAssigned(FunctionalTester $I){
        $student = Student::where('username','student')->first();
        $instructor = Instructor::where('username','instructor')->first();
        $assigned = Instructor::where('username','second_instructor')->first();
        $course = $instructor->courses()->first();
        
        $message = new PrivateMessage([ 'sender_id' => $student->id, 'recipient_id' => $instructor->id, 'content' => 'Question sir!']);
        $message->type = 'ask_teacher';
        $message->course_id = $course->id;
        $I->assertTrue( $message->save() );
        
        $I->amLoggedAs($assigned);
        $I->amOnPage('/private-messages');
        
        $I->dontSee("Question sir!");
        
    }
}