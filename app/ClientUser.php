<?php namespace Delivered;

use Illuminate\Database\Eloquent\Model;

class ClientUser extends Model {

	protected $table = 'client_users';
    protected $fillable = ['clientId', 'firstName', 'lastName', 'email'];
}
