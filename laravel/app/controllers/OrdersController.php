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

		$course_categories = [''=>'Select Category'];
		$course_categories_lists = CourseCategory::lists('name', 'id');
		foreach($course_categories_lists as $key => $val){
			$course_categories = array_add($course_categories, $key, $val);
		}
		$course_category = (isset($data['course_category']))?$data['course_category']:'';

		$filters = ['all'=>'All', 'paid'=>'Paid', 'free'=>'Free'];
		$filter = (isset($data['filter']))?$data['filter']:'paid';

		$email = (isset($data['email']))?$data['email']:'';
		$sale_amount_low = (isset($data['sale_amount_low']))?$data['sale_amount_low']:'';
		$sale_amount_high = (isset($data['sale_amount_high']))?$data['sale_amount_high']:'';
		$product_price_low = (isset($data['product_price_low']))?$data['product_price_low']:'';
		$product_price_high = (isset($data['product_price_high']))?$data['product_price_high']:'';
		$purchase_date_low = (isset($data['purchase_date_low']))?$data['purchase_date_low']:'';
		$purchase_date_high = (isset($data['purchase_date_high']))?$data['purchase_date_high']:'';
		$course_id = (isset($data['course_id']))?$data['course_id']:'';

		if(Request::ajax()){
			$page = (isset($data['page']))?$data['page']:'';
			$start = (isset($data['start']))?$data['start']:0;
			$limit = (isset($data['limit']))?$data['limit']:15;
			
			$orders = Purchase::leftJoin('courses', 'courses.id', '=', 'purchases.product_id')
								->leftJoin('users as owner', 'owner.id', '=', 'courses.instructor_id')
								->leftJoin('users as buyer', 'buyer.id', '=', 'purchases.student_id')
								->select('purchases.*', 'courses.slug as course_alias', 'courses.name as course_name', 'owner.email as owner_email', 'buyer.email as buyer_email', DB::raw("CONCAT(buyer.last_name, ', ', buyer.first_name) as buyer_name"), DB::raw("CONCAT(owner.last_name, ', ', owner.first_name) as owner_name"))
								->where('purchases.product_type', '=', 'Course')
								->where(function ($query) use ($course_name, $course_category, $filter, $email, $sale_amount_low, $sale_amount_high, $product_price_low, $product_price_high, $purchase_date_low, $purchase_date_high, $course_id){
									// if($search){
									// 	$query->orWhere('courses.slug', 'like', "%$search%")
									// 			->orWhere('courses.name', 'like', "%$search%")
									// 			->orWhere('owner.email', 'like', "%$search%")
									// 			->orWhere(DB::raw("CONCAT(owner.last_name, ', ', owner.first_name)"), 'like', "%$search%")
									// 			->orWhere('buyer.email', 'like', "%$search%")
									// 			->orWhere(DB::raw("CONCAT(buyer.last_name, ', ', buyer.first_name)"), 'like', "%$search%");
									// }

									if($course_name){
										$query->where('courses.name', 'like', "%$search%");
									}

									if($course_category){
										$query->where('courses.course_category_id', '=', $course_category);
									}

									if($filter){
										switch($filter){
											case 'all':
											default;
											break;

											case 'free':
												$query->where('purchases.purchase_price', '<=', 0);
											break;

											case 'paid':
												$query->where('purchases.purchase_price', '>', 0);
											break;
										}
									}

									if($email){
										$query->orWhere('buyer.email', 'like', "%$email%");
									}

									if($sale_amount_low && $sale_amount_high){
										$query->orWhere(function ($query2) use ($sale_amount_low, $sale_amount_high) {
											$query2->whereBetween('purchases.purchase_price', array($sale_amount_low, $sale_amount_high));
										});
									} else if($sale_amount_low && empty($sale_amount_high)){
										$query->where('purchases.purchase_price', '>=', $sale_amount_low);
									} else if($sale_amount_high && empty($sale_amount_low)){
										$query->where('purchases.purchase_price', '<=', $sale_amount_high);
									}

									if($product_price_low && $product_price_high){
										$query->orWhere(function ($query3) use ($product_price_low, $product_price_high) {
											$query3->whereBetween('purchases.original_price', array($product_price_low, $product_price_high));
										});
									} else if($product_price_low && empty($product_price_high)){
										$query->where('purchases.original_price', '>=', $product_price_low);
									} else if($product_price_high && empty($product_price_low)){
										$query->where('purchases.original_price', '<=', $product_price_high);
									}

									if($purchase_date_low && $purchase_date_high){
										$query->orWhere(function ($query3) use ($purchase_date_low, $purchase_date_high) {
											$purchase_date_low = \Carbon\Carbon::parse($purchase_date_low);
											$purchase_date_low = $purchase_date_low->startOfDay();
											$purchase_date_high = \Carbon\Carbon::parse($purchase_date_high);
											$purchase_date_high = $purchase_date_high->endOfDay();
											$query3->whereBetween('purchases.created_at', array($purchase_date_low, $purchase_date_high));
										});
									} else if($purchase_date_low && empty($purchase_date_high)){
										$purchase_date_low = \Carbon\Carbon::parse($purchase_date_low);
										$purchase_date_low = $purchase_date_low->startOfDay();
										$query->where('purchases.created_at', '>=', $purchase_date_low);
									} else if($purchase_date_high && empty($purchase_date_low)){
										$purchase_date_high = \Carbon\Carbon::parse($purchase_date_high);
										$purchase_date_high = $purchase_date_high->endOfDay();
										$query->where('purchases.created_at', '<=', $purchase_date_high);
									}
								})
								->orderBy($sort_by, $sort)->paginate($limit);
			// dd(DB::getQueryLog());
			$start = $start + $limit;

			return View::make('administration.orders.listing', compact('orders', 'start', 'limit', 'page', 'sort_by', 'sort', 'course_name', 'course_categories', 'course_category', 'filters', 'filter', 'email', 'sale_amount_low', 'sale_amount_high', 'product_price_low', 'product_price_high', 'purchase_date_low', 'purchase_date_high', 'course_id'));
		}

		return View::make('administration.orders.index', compact('sort_by', 'sort', 'course_name', 'course_categories', 'course_category', 'filters', 'filter', 'email', 'sale_amount_low', 'sale_amount_high', 'product_price_low', 'product_price_high', 'purchase_date_low', 'purchase_date_high', 'course_id'));
	}

}
