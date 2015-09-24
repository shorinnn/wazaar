<?php 
class Logger extends Eloquent {

    protected $table = 'logs';
    protected $fillable = ['object','key','details'];
}