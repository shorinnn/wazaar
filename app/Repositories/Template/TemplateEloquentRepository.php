<?php namespace Delivered\Repositories\Template;

use Delivered\Repositories\CommonModelMethodsTrait;
use Delivered\Template;

class TemplateEloquentRepository implements TemplateInterface
{

    use CommonModelMethodsTrait;
    protected $model;

    public function __construct()
    {
        $this->model = new Template();
    }

    public function validationRules($id = 0)
    {
        return
            [
                'templateName' => 'required',
                'subject'      => 'required',
                'fromName'     => 'required',
                'fromAddress'  => 'required|email',
                'body'         => 'required'
            ];

    }

    public function validationMessages()
    {
        return
            [
                'templateName.required' => trans('template.validation.templateName.required'),
                'subject.required'      => trans('template.validation.subject.required'),
                'fromName.required'     => trans('template.validation.fromName.required'),
                'fromAddress.required'  => trans('template.validation.fromAddress.required'),
                'fromAddress.email'     => trans('template.validation.fromAddress.email'),
                'body.required'         => trans('template.validation.body.required')
            ];
    }

    public function getAllByClient($clientId)
    {
        return $this->model->where('clientId',$clientId)->get();
    }

}