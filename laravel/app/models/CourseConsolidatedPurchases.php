<?php 
class CourseConsolidatedPurchases extends Eloquent {

    protected $table = 'courses_consolidated_purchases';
    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo('Course','course_id');
    }
}