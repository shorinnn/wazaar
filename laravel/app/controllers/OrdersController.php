<?php

class OrdersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$data = Request::all();
		if(Request::ajax()){
			$page = (isset($data['page']))?$data['page']:'';
			$start = (isset($data['start']))?$data['start']:0;
			$limit = (isset($data['limit']))?$data['limit']:15;
			$sort_by = (isset($data['sort_by']))?$data['sort_by']:'created_at';
			$sort = (isset($data['sort']))?$data['sort']:'desc';
			
			$orders = Purchase::where('product_type', '=', 'Course')->orderBy($sort_by, $sort)->paginate($limit);
			// dd(DB::getQueryLog());
			$start = $start + $limit;

			return View::make('administration.orders.listing', compact('orders', 'start', 'limit', 'sort_by', 'sort', 'page'));
		}

		$sort_by = (isset($data['sort_by']))?$data['sort_by']:'created_at';
		$sort = (isset($data['sort']))?$data['sort']:'desc';
		return View::make('administration.orders.index', compact('sort_by', 'sort'));
	}

}
