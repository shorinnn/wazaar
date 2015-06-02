<?php namespace Delivered\Http\Controllers;

use Delivered\Helpers\ResponseHelper;
use Delivered\Http\Requests;
use Delivered\Http\Controllers\Controller;

use Delivered\Repositories\EmailRequest\EmailRequestInterface;
use Delivered\Repositories\Template\TemplateInterface;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as Validation;
use Illuminate\Support\Str;

class EmailRequestsController extends Controller
{

    protected $emailRequest;
    protected $response;

    public function __construct(EmailRequestInterface $emailRequestInterface, ResponseHelper $responseHelper)
    {
        $this->middleware('client.session');
        $this->emailRequest = $emailRequestInterface;
        $this->response     = $responseHelper;
    }

    public function create(Request $request, TemplateInterface $templateInterface, Validation $validation)
    {
        if (!$request->has('requestType')) {
            return $this->response->error(['requestType must be provided']);
        }

        $clientId = \Session::get('clientId');
        //if templateId wasn't provided, template must be available
        if (!$request->has('templateId')) {
            if (!$request->has('template')) {
                return $this->response->error(['A template must be provided']);
            }

            $newTemplateArr = json_decode($request->get('template'), true);

            if (is_array($newTemplateArr)) {
                $templateValidator = $validation->make($newTemplateArr, $templateInterface->validationRules(),
                    $templateInterface->validationMessages());

                if ($templateValidator->fails()) {
                    return $this->response->error($templateValidator->getMessageBag()->all());
                }

                $template = $templateInterface->create([
                    'clientId'     => $clientId,
                    'templateName' => $newTemplateArr['templateName'],
                    'slug'         => Str::slug($newTemplateArr['templateName']),
                    'subject'      => $newTemplateArr['subject'],
                    'fromAddress'  => $newTemplateArr['fromAddress'],
                    'fromName'     => $newTemplateArr['fromName'],
                    'body'         => $newTemplateArr['body']
                ]);
            } else {
                return $this->response->error(['Template provided is not a valid data']);
            }
        } else {
            $template = $templateInterface->find($request->get('templateId'));

            if (!$template) {
                return $this->response->error(['Template provided does not exist']);
            }

            if ($template->clientId !== $clientId) {
                return $this->response->error(['Permission Error: Invalid Template ID']);
            }
        }

        $emailRequest = [
            'clientId'       => $clientId,
            'externalUserId' => $request->get('externalUserId'),
            'requestType'    => $request->get('requestType'),
            'templateId'     => $template->id,
            'variables'      => $request->get('variables')
        ];

        $request = $this->emailRequest->create($emailRequest);

        $emailRequest['id'] = $request->id;

        return $this->response->success($emailRequest);
    }


}
