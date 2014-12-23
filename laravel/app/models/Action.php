<?php
use LaravelBook\Ardent\Ardent;

class Action extends Ardent{

    public $fillable = ['type', 'time_after_pageload', 'target_class', 'target_id', 'url', 'ip', 'user_agent', 'tracker_id'];
    
   

}