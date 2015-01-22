<?php
use LaravelBook\Ardent\Ardent;

class WishlistItem extends Ardent{
    public $fillable = ['course_id', 'student_id'];
    public static $rules = [
        'course_id' => 'required|exists:courses,id|unique_with:wishlist_items,student_id',
        'student_id' => 'required|exists:users,id'
     ];
    
    public static $relationsData = [
        'student' => [ self::BELONGS_TO, 'Student', 'table' => 'users', 'foreignKey' => 'ltc_affiliate_id' ],
      ];
        

}