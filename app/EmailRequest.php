<?php namespace Delivered;

use Illuminate\Database\Eloquent\Model;

class EmailRequest extends Model {

	protected $table = 'email_requests';
    protected $fillable = ['clientId', 'externalUserId', 'requestType', 'templateId', 'variables'];

    public function getVariablesAttribute()
    {
        return json_decode($this->getAttribute('variables'), true);
    }
}
