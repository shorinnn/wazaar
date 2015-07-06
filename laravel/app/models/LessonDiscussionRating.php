<?php
use LaravelBook\Ardent\Ardent;

class LessonDiscussionRating extends Ardent {
	protected $fillable = ['student_id', 'lesson_discussion_id'];
        public static $rules = [
            'student_id' => 'required|numeric|exists:users,id',
            'lesson_discussion_id' => 'required|numeric|exists:lesson_discussions,id',
        ];
        public static $relationsData = [];
}