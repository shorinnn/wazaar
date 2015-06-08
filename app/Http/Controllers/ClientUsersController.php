<?php namespace Delivered\Http\Controllers;

use Carbon\Carbon;
use Delivered\Helpers\ResponseHelper;
use Delivered\Http\Requests;
use Delivered\Http\Controllers\Controller;

use Delivered\Repositories\ClientUser\ClientUserInterface;
use Illuminate\Contracts\Validation\Factory as Validation;
use Illuminate\Http\Request;

class ClientUsersController extends Controller {

    protected $clientUser;
    protected $response;

    public function __construct(ClientUserInterface $clientUserInterface, ResponseHelper $responseHelper)
    {
        $this->middleware('client.session');
        $this->clientUser = $clientUserInterface;
        $this->response = $responseHelper;
    }

    public function index()
    {
        return $this->response->success($this->clientUser->getByClient(\Session::get('clientId')));
    }
    
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Validation $validation, Request $request)
	{
        $userValidator = $validation->make($request->all(), $this->clientUser->validationRules(), $this->clientUser->validationMessages());

        $clientId = \Session::get('clientId');
        if ($userValidator->fails()) {
            return $this->response->error($userValidator->getMessageBag()->all());
        }

        $clientId = \Session::get('clientId');

        $user = $this->clientUser->create([
            'clientId'  => $clientId,
            'firstName' => $request->get('firstName'),
            'lastName'  => $request->get('lastName'),
            'email'     => $request->get('email')
        ]);

        return $this->response->success($user);
	}

    public function addBatch(Request $request, Validation $validation)
    {
        if ($request->has('users')) {
            $clientId = \Session::get('clientId');
            $users = json_decode($request->get('users'),true);
            $success = true;
            $filteredUsers = [];
            $errors = [];

            foreach($users as $user){
                $validator = $validation->make($user,$this->clientUser->validationRules(),$this->clientUser->validationMessages());

                if ($validator->fails()){
                    $success = false;
                    $errors[] = ['user' => $user, 'messages' => $validator->errors()->all()];
                }
                else{
                    $user['clientId'] = $clientId;
                    $user['created_at'] = Carbon::now();
                    $user['updated_at'] = Carbon::now();
                    $filteredUsers[] = $user;
                }
            }

            $addedUsers = [];
            if (count($filteredUsers) > 0 AND $success){
                $addedUsers = $this->clientUser->insert($filteredUsers);
            }

            if ($success){
                return $this->response->success($addedUsers);
            }
            else{
                return $this->response->error($errors);
            }
        }

        return $this->response->error(['Parameter "users" not found in this request']);
    }
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Validation $validation, Request $request)
	{
        $userValidator = $validation->make($request->all(), $this->clientUser->validationRules($id), $this->clientUser->validationMessages());

        $clientId = \Session::get('clientId');
        if ($userValidator->fails()) {
            return $this->response->error($userValidator->getMessageBag()->all());
        }

        $clientId = \Session::get('clientId');

        $user = $this->clientUser->find($id);

        if (!$user){
            return $this->response->error(['User not found']);
        }

        if ($user->clientId !== $clientId){
            return $this->response->error(['Permission Error: Invalid user']);
        }

        $user->firstName = $request->get('firstName');
        $user->lastName = $request->get('lastName');
        $user->email = $request->get('email');
        $user->save();

        return $this->response->success($user);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $clientId = \Session::get('clientId');

        $user = $this->clientUser->find($id);

        if (!$user){
            return $this->response->error(['User not found']);
        }

        if ($user->clientId !== $clientId){
            return $this->response->error(['Permission Error: Invalid user']);
        }

        $this->clientUser->delete($id);

        return $this->response->success(['User Deleted']);
	}

}
