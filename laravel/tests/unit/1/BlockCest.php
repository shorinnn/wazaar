<?php
use \UnitTester;

class BlockCest{
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
        Block::boot();
    }
    
    public function addBlockToLesson(UnitTester $I){
        $lesson = Lesson::find(1);
        $block = new Block();
        $block->type = 'text';
        $block->lesson_id = $lesson->id;
        $I->assertTrue( $block->save() );
    }
    
    public function getLessonDetails(UnitTester $I){
        $lesson = Lesson::find(1);
        $block = new Block();
        $block->type = 'text';
        $block->lesson_id = $lesson->id;
        $I->assertTrue( $block->save() );
        $I->assertEquals(1, $block->lesson->id);
        $I->assertEquals('instructor', $block->lesson->module->course->instructor->username);
    }
    
        
}