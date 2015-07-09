<?php
use LaravelBook\Ardent\Ardent;

class CategoryGroup extends Ardent {
	protected $fillable = ['name','order'];
        public static $rules = [];
        public static $relationsData = [];
}