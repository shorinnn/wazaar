<?php namespace Delivered\Http\Controllers;

use Delivered\Http\Requests;
use Delivered\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delivered\Repositories\Client\ClientInterface;


class ClientController extends Controller {

    protected $client;

    public function __construct(ClientInterface $clientInterface)
    {
        $this->client = $clientInterface;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->client->all();
	}

    public function store()
    {

    }



}
