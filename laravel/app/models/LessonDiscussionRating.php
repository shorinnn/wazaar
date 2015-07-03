<?php
use LaravelBook\Ardent\Ardent;

class LessonDiscussionRating extends Ardent {
	protected $fillable = ['student_id', 'lesson_discussion_id'];
        public static $rules = [];
        public static $relationsData = [];
}