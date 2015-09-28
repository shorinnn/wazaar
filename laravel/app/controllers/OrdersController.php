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
		$sort_by = (isset($data['sort_by']))?$data['sort_by']:'created_at';
		$sort = (isset($data['sort']))?$data['sort']:'desc';
		$course_name = (isset($data['course_name']))?$data['course_name']:'';
		$course_categories = [];
		$course_category = '';
		$course_statuses = [];
		$course_status = '';

		if(Request::ajax()){
			$page = (isset($data['page']))?$data['page']:'';
			$start = (isset($data['start']))?$data['start']:0;
			$limit = (isset($data['limit']))?$data['limit']:15;
			
			$orders = Purchase::leftJoin('courses', 'courses.id', '=', 'purchases.product_id')
								->leftJoin('users as owner', 'owner.id', '=', 'courses.instructor_id')
								->leftJoin('users as buyer', 'buyer.id', '=', 'purchases.student_id')
								->select('purchases.*', 'courses.slug as course_alias', 'courses.name as course_name', 'owner.email as owner_email', 'buyer.email as buyer_email', DB::raw("CONCAT(buyer.last_name, ', ', buyer.first_name) as buyer_name"), DB::raw("CONCAT(owner.last_name, ', ', owner.first_name) as owner_name"))
								->where('purchases.product_type', '=', 'Course')
								->where(function ($query) use ($search){
									if($search){
										$query->orWhere('courses.slug', 'like', "%$search%")
												->orWhere('courses.name', 'like', "%$search%")
												->orWhere('owner.email', 'like', "%$search%")
												->orWhere(DB::raw("CONCAT(owner.last_name, ', ', owner.first_name)"), 'like', "%$search%")
												->orWhere('buyer.email', 'like', "%$search%")
												->orWhere(DB::raw("CONCAT(buyer.last_name, ', ', buyer.first_name)"), 'like', "%$search%");
									}
								})
								->orderBy($sort_by, $sort)->paginate($limit);
			// dd(DB::getQueryLog());
			$start = $start + $limit;

			return View::make('administration.orders.listing', compact('orders', 'start', 'limit', 'sort_by', 'sort', 'page', 'course_name'));
		}

		
		return View::make('administration.orders.index', compact('sort_by', 'sort', 'course_name', 'course_categories', 'course_category', 'course_statuses', 'course_status'));
	}

}
