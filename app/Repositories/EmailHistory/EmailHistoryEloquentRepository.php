<?php namespace Delivered\Repositories\EmailHistory;

use Delivered\EmailHistory;
use Delivered\Repositories\CommonModelMethodsTrait;

class EmailHistoryEloquentRepository implements EmailHistoryInterface {

    use CommonModelMethodsTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new EmailHistory();
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