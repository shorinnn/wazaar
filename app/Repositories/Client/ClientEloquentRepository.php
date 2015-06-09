<?php namespace Delivered\Repositories\Client;

use Delivered\Client;
use Delivered\Repositories\CommonModelMethodsTrait;

class ClientEloquentRepository implements ClientInterface {

    use CommonModelMethodsTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Client();
    }

    public function getByAPIKey($apiKey)
    {
        return $this->model->where('apiKey',$apiKey)->first();
    }


    public function validationRules($id = 0)
    {
        // TODO: Implement validationRules() method.
    }

    public function validationMessages()
    {
        // TODO: Implement validationMessages() method.
    }


}