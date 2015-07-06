<?php
use LaravelBook\Ardent\Ardent;

class LessonDiscussionReplyRating extends Ardent {
	protected $fillable = ['student_id', 'lesson_discussion_reply_id'];
        public static $rules = [
            'student_id' => 'required|numeric|exists:users,id',
            'lesson_discussion_reply_id' => 'required|numeric|exists:lesson_discussion_replies,id',
        ];
        public static $relationsData = [];
}