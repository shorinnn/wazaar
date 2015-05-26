<?php namespace Delivered\Http\Controllers;

/**
 * @package
 * @category
 * @subpackage
 *
 * @SWG\Resource(
 *   apiVersion="1.0.0",
 *   swaggerVersion="1.2",
 *   basePath="http://delivered.cocorium.com/api",
 *   resourcePath="/templates",
 *   description="Client Email templates",
 *   produces="['application/json']"
 * )
 */

use Delivered\Helpers\ResponseHelper;
use Delivered\Http\Requests;
use Delivered\Http\Controllers\Controller;

use Delivered\Repositories\Template\TemplateInterface;
use Illuminate\Contracts\Validation\Factory as Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class TemplateController extends Controller
{

    protected $template;
    protected $request;
    protected $response;

    public function __construct(TemplateInterface $templateInterface, Request $request, ResponseHelper $responseHelper)
    {
        $this->middleware('client.session');
        $this->template = $templateInterface;
        $this->request  = $request;
        $this->response = $responseHelper;
    }
    /**
     * @SWG\Api(
     *   path="/templates",
     *   @SWG\Operation(
     *     method="GET",
     *     summary="Find all templates for a client",
     *     notes="Client will be determined from the token and API Key provided",
     *     type="Templates",
     *     authorizations={},
     *   )
     * )
     */

    public function index()
    {
        $clients = $this->template->getAllByClient(\Session::get('clientId'));

        return $this->response->success($clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Validation $validation)
    {
        $clientId  = \Session::get('clientId');
        $validator = $validation->make($this->request->all(), $this->template->validationRules(),
            $this->template->validationMessages());

        if ($validator->fails()) {
            return $this->response->error($validator->getMessageBag()->all());
        }

        $template = $this->template->create([
            'clientId'     => $clientId,
            'templateName' => $this->request->get('templateName'),
            'slug'         => Str::slug($this->request->get('templateName')),
            'subject'      => $this->request->get('subject'),
            'fromAddress'  => $this->request->get('fromAddress'),
            'fromName'     => $this->request->get('fromName'),
            'body'         => $this->request->get('body')
        ]);

        if ($template) {
            return $this->response->success($template);
        }

        return $this->response->error(['Unknown Error. Cannot add a template for now. Please try again in a few moments']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id, Validation $validation)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, Validation $validation)
    {
        $validator = $validation->make($this->request->all(), $this->template->validationRules(),
            $this->template->validationMessages());

        if ($validator->fails()) {
            return $this->response->error($validator->getMessageBag()->all());
        }

        $template = $this->template->find($id);
        $clientId = \Session::get('clientId');

        if ($template) {
            if ($template->clientId == $clientId) {
                $template->update([
                    'templateName' => $this->request->get('templateName'),
                    'slug'         => Str::slug($this->request->get('templateName')),
                    'subject'      => $this->request->get('subject'),
                    'fromAddress'  => $this->request->get('fromAddress'),
                    'fromName'     => $this->request->get('fromName'),
                    'body'         => $this->request->get('body')
                ]);

                return $this->response->success($template);
            } else {
                return $this->response->error(['Permission Denied']);
            }
        }

        return $this->response->error(['Unknown Error. Cannot add a template for now. Please try again in a few moments']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($id) {
            $template = $this->template->find($id);
            $clientId = \Session::get('clientId');
            if ($template) {
                if ($template->clientId !== $clientId) {
                    return $this->response->error(['Permission Denied']);
                } else {
                    $result = $template->delete($id);

                    return $this->response->success($result);
                }
            } else {
                return $this->response->error(['Template was not found']);
            }
        }

        return $this->response->error(['Unknown Error. Cannot add a template for now. Please try again in a few moments']);
    }

}
