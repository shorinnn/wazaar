<?php 
use \FunctionalTester;

class ConversationsCest{
    public $lesson;
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
        $this->lesson = Course::find(5)->modules()->first()->lessons()->first();
        $student = Student::where('username','student')->first();
        $student->purchase( $this->lesson->module->course );
    }
    
    public function redirectIfNotLoggedIn(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $I->amOnPage( "classroom/".$this->lesson->module->course->slug.'/'.$this->lesson->slug );
        $I->seeCurrentUrlEquals('/login');
    }

    public function postComment(FunctionalTester $I){
        $user = Student::where('username','student')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->assertTrue( $user->purchased ($this->lesson->module->course) );
        $I->amOnPage( "classroom/".$this->lesson->module->course->slug.'/'.$this->lesson->slug );
        $I->submitForm('#add-comment-form',['content' => 'test text']);
        $I->seeRecord('conversations',[ 'poster_id' => $user->id, 'content' => 'test text', 'lesson_id' => $this->lesson->id ]);
    }   
    
        
    public function postAjaxComment(FunctionalTester $I){
        $user = Student::where('username','student')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->assertTrue( $user->purchased ($this->lesson->module->course) );
        $I->amOnPage( "classroom/".$this->lesson->module->course->slug.'/'.$this->lesson->slug );
        $I->sendAjaxPostRequest( action('ConversationsController@store'), [
            '_token' => csrf_token(),
            'lesson' => $this->lesson->id,
            'reply_to' => '0',
            'content' => 'test text'
        ]);
        $I->seeRecord('conversations',[ 'poster_id' => $user->id, 'content' => 'test text', 'lesson_id' => $this->lesson->id ]);
    }  
    
    public function postReply(FunctionalTester $I){
        $user = Student::where('username','student')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->assertTrue( $user->purchased ($this->lesson->module->course) );
        
        $I->amOnPage( "/classroom/".$this->lesson->module->course->slug.'/'.$this->lesson->slug );
        $I->submitForm('#add-comment-form',['content' => 'test text']);
        $I->seeRecord('conversations',[ 'poster_id' => $user->id, 'content' => 'test text', 'lesson_id' => $this->lesson->id]);
        
        $I->amOnPage( "/classroom/".$this->lesson->module->course->slug.'/'.$this->lesson->slug );
        $I->submitForm('#add-comment-form',['content' => 'the reply', 'reply_to' => Conversation::get()->last()->id ]);
        $I->seeRecord('conversations',[ 'poster_id' => $user->id, 'content' => 'the reply', 'lesson_id' => $this->lesson->id ]);
    }   
    
    public function replyToReply(FunctionalTester $I){
        $user = Student::where('username','student')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->assertTrue( $user->purchased ($this->lesson->module->course) );
        
        $I->amOnPage( "/classroom/".$this->lesson->module->course->slug.'/'.$this->lesson->slug );
        $I->submitForm('#add-comment-form',['content' => 'test text']);
        $I->seeRecord('conversations',[ 'poster_id' => $user->id, 'content' => 'test text', 'lesson_id' => $this->lesson->id]);
        
        $original_comment = Conversation::get()->last()->id ;
        $I->amOnPage( "/classroom/".$this->lesson->module->course->slug.'/'.$this->lesson->slug );
        $I->submitForm('#add-comment-form',['content' => 'the reply', 'reply_to' => $original_comment]);
        $I->seeRecord('conversations',[ 'poster_id' => $user->id, 'content' => 'the reply', 'lesson_id' => $this->lesson->id ]);
        
        $reply_id = Conversation::get()->last()->id;
        $I->amOnPage( "/classroom/".$this->lesson->module->course->slug.'/'.$this->lesson->slug );
        $I->submitForm('#add-comment-form',['content' => 'reply to reply', 'reply_to' => $reply_id ]);
        $I->seeRecord('conversations',[ 'poster_id' => $user->id, 'content' => 'reply to reply', 
            'original_reply_to' => $reply_id, 'reply_to' => $original_comment, 'lesson_id' => $this->lesson->id ]);
    }

    
    public function failPostCommentNoPurchase(FunctionalTester $I){
        $user = Student::where('username','mac')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->assertFalse( $user->purchased ($this->lesson->module->course) );
        $I->sendAjaxPostRequest( action('ConversationsController@store'), [
            '_token' => csrf_token(),
            'lesson' => $this->lesson->id,
            'reply_to' => '0',
            'content' => 'test text'
        ]);
        $I->dontSeeRecord('conversations',[ 'poster_id' => $user->id, 'content' => 'test text', 'lesson_id' => $this->lesson->id ]);
    }  
    
        
    public function failAjaxtReplyNoPurchase(FunctionalTester $I){
        $user = Student::where('username','student')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->assertTrue( $user->purchased ($this->lesson->module->course) );
        
        $I->amOnPage( "/classroom/".$this->lesson->module->course->slug.'/'.$this->lesson->slug );
        $I->submitForm('#add-comment-form',['content' => 'test text']);
        $I->seeRecord('conversations',[ 'poster_id' => $user->id, 'content' => 'test text', 'lesson_id' => $this->lesson->id]);
        $original_comment = Conversation::get()->last()->id ;
        
        $user = Student::where('username','mac')->first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->assertFalse( $user->purchased ($this->lesson->module->course) );
        $I->sendAjaxPostRequest( action('ConversationsController@store'), [
            '_token' => csrf_token(),
            'lesson' => $this->lesson->id,
            'reply_to' => $original_comment,
            'content' => 'reply text'
        ]);
        $I->dontSeeRecord('conversations',[ 'poster_id' => $user->id, 'content' => 'reply text', 'lesson_id' => $this->lesson->id ]);        
    }
}