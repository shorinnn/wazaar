<?php namespace Delivered;

use Illuminate\Database\Eloquent\Model;

class EmailRequest extends Model {

	protected $table = 'email_requests';
    protected $fillable = ['clientId', 'userId', 'requestType', 'templateId', 'variables'];

    const TYPE_IMMEDIATE = 'immediate';
    const TYPE_SEQUENCE = 'sequence';

    public function getBodyVariablesAttribute()
    {
        return json_decode($this->attributes['bodyVariables'],true);
    }

    public function user()
    {
        return $this->belongsTo('Delivered\ClientUser','userId');
    }
}
