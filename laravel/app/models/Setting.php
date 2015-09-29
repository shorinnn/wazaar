<?php
use LaravelBook\Ardent\Ardent;

class Setting extends Ardent {
	protected $fillable = ['name'];
        public static $rules = [
            'name' => 'required|unique:settings'
        ];
        public static $relationsData = [];
}