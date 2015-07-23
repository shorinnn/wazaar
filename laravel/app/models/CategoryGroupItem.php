<?php
use LaravelBook\Ardent\Ardent;

class CategoryGroupItem extends CocoriumArdent {
	protected $fillable = ['course_category_id', 'category_group_id'];
        public static $rules = [
            'course_category_id' => 'unique_with:category_group_items,category_group_id',
            'category_group_id' => 'unique_with:category_group_items,course_category_id'
        ];
        public static $relationsData = [];
}