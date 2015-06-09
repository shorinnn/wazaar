<?php namespace Delivered\Repositories\ClientUser;

use Delivered\ClientUser;
use Delivered\Repositories\CommonModelMethodsTrait;

class ClientUserEloquentRepository implements ClientUserInterface
{

    use CommonModelMethodsTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new ClientUser();
    }

    public function getByClient($clientId)
    {
        return $this->model->where('clientId', $clientId)->get();
    }

    public function validationRules($id = 0)
    {
        $rules = [
            'firstName' => 'required',
            'lastName'  => 'required',
            'email'     => 'required|email|unique:client_users,email'
        ];

        if ($id > 0){
            $rules['email'] = "required|email|unique:client_users,email,$id";
        }

        return $rules;
    }

    public function insert($batch)
    {
        return $this->model->insert($batch);
    }

    public function validationMessages()
    {
        return [
            'firstName.required' => 'User first name cannot be empty',
            'lastName.required'  => 'User last name cannot be empty',
            'email.required'     => 'User Email cannot be empty',
            'email.email'        => 'User Email is not valid'
        ];
    }
}