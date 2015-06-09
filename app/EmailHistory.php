<?php namespace Delivered;

use Illuminate\Database\Eloquent\Model;

class EmailHistory extends Model {

	protected $table = 'email_history';
    protected $fillable = ['emailRequestId','mandrillReferenceId','mandrillStatus','mandrillRejectReason'];

}
