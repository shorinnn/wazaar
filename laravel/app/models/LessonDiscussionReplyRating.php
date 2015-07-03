<?php
use LaravelBook\Ardent\Ardent;

class LessonDiscussionReplyRating extends Ardent {
	protected $fillable = ['student_id', 'lesson_discussion_reply_id'];
        public static $rules = [];
        public static $relationsData = [];
}