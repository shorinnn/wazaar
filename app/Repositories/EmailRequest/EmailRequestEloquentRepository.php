<?php namespace Delivered\Repositories\EmailRequest;

use Delivered\EmailRequest;
use Delivered\Repositories\CommonModelMethodsTrait;

class EmailRequestEloquentRepository implements EmailRequestInterface {

    use CommonModelMethodsTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new EmailRequest();
    }

    public function validationRules($id = 0)
    {
        return [

        ];
    }

    public function validationMessages()
    {
        // TODO: Implement validationMessages() method.
    }
}