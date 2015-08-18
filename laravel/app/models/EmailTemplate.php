<?php
use LaravelBook\Ardent\Ardent;

class EmailTemplate extends Ardent {
	protected $fillable = [ 'tag', 'content' ];
        public static $rules = [];
        public static $relationsData = [];
}