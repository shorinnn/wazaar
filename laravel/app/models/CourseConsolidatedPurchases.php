<?php 
class CourseConsolidatedPurchases extends Eloquent {

    protected $table = 'courses_consolidated_purchases';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function course()
    {
        return $this->belongsTo('Course','course_id');
    }
}