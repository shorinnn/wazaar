<?php

class FollowRelationship extends CocoriumArdent{
    public $fillable = ['instructor_id', 'student_id'];
    
     public static $rules = [
        'instructor_id' => 'required|exists:users,id|unique_with:follow_relationships,student_id',
        'student_id' => 'required|exists:users,id'
     ];
}