<?php

class OrdersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('administration.orders.index');
	}

	public function loadOrders()
	{	
		$data = Request::all();
		$start = (isset($data['start']))?$data['start']:0;
		$limit = (isset($data['limit']))?$data['limit']:50;
		$order_by = (isset($data['order_by']))?$data['order_by']:'created_at';
		$order = (isset($data['order']))?$data['order']:'desc';
		
		$orders = Purchase::orderBy($order_by, $order)->paginate($limit);

		$start = $start + $limit;

		return View::make('administration.orders.listing', compact('orders', 'start', 'limit'));
	}

}
