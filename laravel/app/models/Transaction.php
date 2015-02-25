<?php
use LaravelBook\Ardent\Ardent;

class Transaction extends Ardent {
	protected $fillable = [];
        public static $rules = [];
        public static $relationsData = [
            'user' => [self::BELONGS_TO, 'User']
        ];
}