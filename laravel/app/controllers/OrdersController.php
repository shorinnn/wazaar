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
		$transaction_id = (isset($data['transaction_id']))?$data['transaction_id']:'';
		$total = (isset($data['total']))?$data['total']:'';
		$download = (isset($data['download']))?$data['download']:'';

		if(Request::ajax() || !empty($download)){
			if($total){
				$totals = Purchase::select(
										DB::raw("count(*) as sales_count"),
										DB::raw("sum(purchases.original_price) as original_price_total"),
										DB::raw("sum(purchases.purchase_price) as sales_total"),
										DB::raw("sum(purchases.tax) as tax"),
										DB::raw("sum(purchases.site_earnings) as site_earnings"),
										DB::raw("sum(purchases.instructor_earnings) as instructor_earnings"),
										DB::raw("sum(purchases.second_tier_instructor_earnings) as second_tier_instructor_earnings_total"),
										DB::raw("sum(purchases.affiliate_earnings) as affiliate_earnings"),
										DB::raw("sum(purchases.second_tier_affiliate_earnings) as second_tier_affiliate_earnings"),
										DB::raw("sum(purchases.ltc_affiliate_earnings) as ltc_affiliate_earnings")
									)
									->leftJoin('courses', 'courses.id', '=', 'purchases.product_id')
									->leftJoin('users as owner', 'owner.id', '=', 'courses.instructor_id')
									->leftJoin('users as buyer', 'buyer.id', '=', 'purchases.student_id')
									->where('purchases.product_type', '=', 'Course')
									->where(function ($query) use ($course_name, $course_category, $filter, $email, $sale_amount_low, $sale_amount_high, $product_price_low, $product_price_high, $purchase_date_low, $purchase_date_high, $transaction_id){

										if($course_name){
											$query->where('courses.name', 'like', "%$course_name%");
											$query->orWhere('courses.slug', 'like', "%$course_name%");
										}

										if($course_category){
											$query->where('courses.course_category_id', '=', $course_category);
										}

										if($transaction_id){
											$query->where('purchases.payment_ref', 'like', "%$transaction_id%");
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
											$query->where('buyer.email', 'like', "%$email%");
											$query->orWhere('owner.email', 'like', "%$email%");
										}

										if($sale_amount_low && $sale_amount_high){
											$query->whereBetween('purchases.purchase_price', array($sale_amount_low, $sale_amount_high));
										} else if($sale_amount_low && empty($sale_amount_high)){
											$query->where('purchases.purchase_price', '>=', $sale_amount_low);
										} else if($sale_amount_high && empty($sale_amount_low)){
											$query->where('purchases.purchase_price', '<=', $sale_amount_high);
										}

										if($product_price_low && $product_price_high){
											$query->whereBetween('purchases.original_price', array($product_price_low, $product_price_high));
										} else if($product_price_low && empty($product_price_high)){
											$query->where('purchases.original_price', '>=', $product_price_low);
										} else if($product_price_high && empty($product_price_low)){
											$query->where('purchases.original_price', '<=', $product_price_high);
										}

										if($purchase_date_low && $purchase_date_high){
											$purchase_date_low = \Carbon\Carbon::parse($purchase_date_low);
											$purchase_date_low = $purchase_date_low->startOfDay();
											$purchase_date_high = \Carbon\Carbon::parse($purchase_date_high);
											$purchase_date_high = $purchase_date_high->endOfDay();
											$query->whereBetween('purchases.created_at', array($purchase_date_low, $purchase_date_high));
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
									->get();
				// dd(DB::getQueryLog());
				$stats = $totals;
		        return View::make('instructors.analytics.tableCourseStats',compact('stats'))->render();
				return View::make('administration.orders.totals_table', compact('totals'));
			} else if($download){
				$orders = Purchase::leftJoin('courses', 'courses.id', '=', 'purchases.product_id')
									->leftJoin('users as owner', 'owner.id', '=', 'courses.instructor_id')
									->leftJoin('users as buyer', 'buyer.id', '=', 'purchases.student_id')
									->select('purchases.*', 'courses.slug as course_alias', 'courses.name as course_name', 'owner.email as owner_email', 'buyer.email as buyer_email', DB::raw("CONCAT(buyer.last_name, ', ', buyer.first_name) as buyer_name"), DB::raw("CONCAT(owner.last_name, ', ', owner.first_name) as owner_name"))
									->where('purchases.product_type', '=', 'Course')
									->where(function ($query) use ($course_name, $course_category, $filter, $email, $sale_amount_low, $sale_amount_high, $product_price_low, $product_price_high, $purchase_date_low, $purchase_date_high, $transaction_id){

										if($course_name){
											$query->where('courses.name', 'like', "%$course_name%");
											$query->orWhere('courses.slug', 'like', "%$course_name%");
										}

										if($course_category){
											$query->where('courses.course_category_id', '=', $course_category);
										}

										if($transaction_id){
											$query->where('purchases.payment_ref', 'like', "%$transaction_id%");
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
											$query->where('buyer.email', 'like', "%$email%");
											$query->orWhere('owner.email', 'like', "%$email%");
										}

										if($sale_amount_low && $sale_amount_high){
											$query->whereBetween('purchases.purchase_price', array($sale_amount_low, $sale_amount_high));
										} else if($sale_amount_low && empty($sale_amount_high)){
											$query->where('purchases.purchase_price', '>=', $sale_amount_low);
										} else if($sale_amount_high && empty($sale_amount_low)){
											$query->where('purchases.purchase_price', '<=', $sale_amount_high);
										}

										if($product_price_low && $product_price_high){
											$query->whereBetween('purchases.original_price', array($product_price_low, $product_price_high));
										} else if($product_price_low && empty($product_price_high)){
											$query->where('purchases.original_price', '>=', $product_price_low);
										} else if($product_price_high && empty($product_price_low)){
											$query->where('purchases.original_price', '<=', $product_price_high);
										}

										if($purchase_date_low && $purchase_date_high){
											$purchase_date_low = \Carbon\Carbon::parse($purchase_date_low);
											$purchase_date_low = $purchase_date_low->startOfDay();
											$purchase_date_high = \Carbon\Carbon::parse($purchase_date_high);
											$purchase_date_high = $purchase_date_high->endOfDay();
											$query->whereBetween('purchases.created_at', array($purchase_date_low, $purchase_date_high));
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
									->orderBy($sort_by, $sort)->get();
	            header('Content-Type: text/csv; charset=UTF-8');
	            $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
	            $csv->setEncodingFrom('iso-8859-15');
	            
	            $csv_headers = [
	            	trans('administration.orders.transaction-id' ) ,
	            	trans('administration.orders.course-name' ) ,
	            	trans('administration.orders.course-owner' ) ,
	            	trans('administration.orders.course-owner-email' ) ,
	            	trans('administration.orders.original-price' ) ,
	            	trans('administration.orders.discounted-price' ) ,
	            	trans('administration.orders.tax' ) ,
	            	trans('administration.orders.site-income' ) ,
	            	trans('administration.orders.instructor-income' ) ,
	            	trans('administration.orders.affiliate-income' ) ,
	            	trans('administration.orders.ltc-income' ) ,
	            	trans('administration.orders.2-tier-affiliate-income' ) ,
	            	trans('administration.orders.2-tier-instructor-income' ) ,
	            	trans('administration.orders.buyer-name' ) ,
	            	trans('administration.orders.buyer-email' ) ,
	            	trans('administration.orders.transaction-date' )
	            ];
	            $csv->insertOne($csv_headers);
	            
				foreach($orders as $i => $order){
					$row_data = array();
					$row_data[] = $order->payment_ref;
					$row_data[] = $order->course_name;
					$row_data[] = $order->owner_name;
					$row_data[] = $order->owner_email;
					$row_data[] = number_format($order->original_price);
					$row_data[] = number_format($order->purchase_price);
					$row_data[] = number_format($order->tax);
					$row_data[] = number_format($order->site_earnings);
					$row_data[] = number_format($order->instructor_earnings);
					$row_data[] = number_format($order->affiliate_earnings);
					$row_data[] = number_format($order->ltc_affiliate_earnings);
					$row_data[] = number_format($order->second_tier_affiliate_earnings);
					$row_data[] = number_format($order->second_tier_instructor_earnings);
					$row_data[] = $order->buyer_name;
					$row_data[] = $order->buyer_email;
					$row_data[] = $order->created_at->format('M d, Y h:i A \\(l\\)');
                    $csv->insertOne( $row_data );
				}

	            $csv->output('orders.csv');
	            exit();
			} else {
				$page = (isset($data['page']))?$data['page']:'';
				$start = (isset($data['start']))?$data['start']:0;
				$limit = (isset($data['limit']))?$data['limit']:15;
				
				$orders = Purchase::leftJoin('courses', 'courses.id', '=', 'purchases.product_id')
									->leftJoin('users as owner', 'owner.id', '=', 'courses.instructor_id')
									->leftJoin('users as buyer', 'buyer.id', '=', 'purchases.student_id')
									->select('purchases.*', 'courses.slug as course_alias', 'courses.name as course_name', 'owner.email as owner_email', 'buyer.email as buyer_email', DB::raw("CONCAT(buyer.last_name, ', ', buyer.first_name) as buyer_name"), DB::raw("CONCAT(owner.last_name, ', ', owner.first_name) as owner_name"))
									->where('purchases.product_type', '=', 'Course')
									->where(function ($query) use ($course_name, $course_category, $filter, $email, $sale_amount_low, $sale_amount_high, $product_price_low, $product_price_high, $purchase_date_low, $purchase_date_high, $transaction_id){

										if($course_name){
											$query->where('courses.name', 'like', "%$course_name%");
											$query->orWhere('courses.slug', 'like', "%$course_name%");
										}

										if($course_category){
											$query->where('courses.course_category_id', '=', $course_category);
										}

										if($transaction_id){
											$query->where('purchases.payment_ref', 'like', "%$transaction_id%");
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
											$query->where('buyer.email', 'like', "%$email%");
											$query->orWhere('owner.email', 'like', "%$email%");
										}

										if($sale_amount_low && $sale_amount_high){
											$query->whereBetween('purchases.purchase_price', array($sale_amount_low, $sale_amount_high));
										} else if($sale_amount_low && empty($sale_amount_high)){
											$query->where('purchases.purchase_price', '>=', $sale_amount_low);
										} else if($sale_amount_high && empty($sale_amount_low)){
											$query->where('purchases.purchase_price', '<=', $sale_amount_high);
										}

										if($product_price_low && $product_price_high){
											$query->whereBetween('purchases.original_price', array($product_price_low, $product_price_high));
										} else if($product_price_low && empty($product_price_high)){
											$query->where('purchases.original_price', '>=', $product_price_low);
										} else if($product_price_high && empty($product_price_low)){
											$query->where('purchases.original_price', '<=', $product_price_high);
										}

										if($purchase_date_low && $purchase_date_high){
											$purchase_date_low = \Carbon\Carbon::parse($purchase_date_low);
											$purchase_date_low = $purchase_date_low->startOfDay();
											$purchase_date_high = \Carbon\Carbon::parse($purchase_date_high);
											$purchase_date_high = $purchase_date_high->endOfDay();
											$query->whereBetween('purchases.created_at', array($purchase_date_low, $purchase_date_high));
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

				return View::make('administration.orders.listing', compact('orders', 'start', 'limit', 'page', 'sort_by', 'sort', 'course_name', 'course_categories', 'course_category', 'filters', 'filter', 'email', 'sale_amount_low', 'sale_amount_high', 'product_price_low', 'product_price_high', 'purchase_date_low', 'purchase_date_high', 'transaction_id'));
			}
		}

		return View::make('administration.orders.index', compact('sort_by', 'sort', 'course_name', 'course_categories', 'course_category', 'filters', 'filter', 'email', 'sale_amount_low', 'sale_amount_high', 'product_price_low', 'product_price_high', 'purchase_date_low', 'purchase_date_high', 'transaction_id'));
	}

}
