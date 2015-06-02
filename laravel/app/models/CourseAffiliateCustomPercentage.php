<?php
use LaravelBook\Ardent\Ardent;

class CourseAffiliateCustomPercentage extends CocoriumArdent {
	protected $fillable = [];
        public static $rules = [
            'percentage' => 'numeric|between:0,68',
            'course_id' => 'required|exists:courses,id|unique_with:course_affiliate_custom_percentages,affiliate_id',
        ];
        public static $relationsData = [
            'course' => [ self::BELONGS_TO, 'Course' ],
            'affiliate' => [ self::BELONGS_TO, 'ProductAffiliate' ]
        ];
}