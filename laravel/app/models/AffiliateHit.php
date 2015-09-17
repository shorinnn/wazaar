<?php 
class AffiliateHit extends Eloquent {

    protected $table = 'affiliate_hits';
    protected $fillable = ['affiliate_id','course_id','user_id','referrer','ip_address','user_agent','device','browser','operating_system', 'created_at'];
}