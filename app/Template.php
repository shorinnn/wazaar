<?php namespace Delivered;

use Illuminate\Database\Eloquent\Model;

class Template extends Model {

	protected $table = 'email_templates';
    protected $fillable = ['clientId','templateName','slug','subject','fromAddress','fromName','body'];

}
