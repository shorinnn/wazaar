<div class="table-wrapper table-responsive">
	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th>{{ trans('administration.orders.order-id' )}}</th>
				<th>{{ trans('administration.orders.transaction-id' )}}</th>
				<th>{{ trans('administration.orders.course-name' )}}</th>
				<th>{{ trans('administration.orders.site-income' )}}</th>
				<th>{{ trans('administration.orders.transaction-date' )}}</th>
				<!-- <th><a href="#" class="sorter" data-sort-by="owner_name" data-sort="{{-- $sort --}}">{{ trans('administration.orders.course-owner' )}} <i class="fa"></i></a></th> -->
				<!-- <th><a href="#" class="sorter" data-sort-by="owner_email" data-sort="{{-- $sort --}}">{{ trans('administration.orders.course-owner-email' )}} <i class="fa"></i></a></th> -->
				<!-- <th><a href="#" class="sorter" data-sort-by="original_price" data-sort="{{-- $sort --}}">{{ trans('administration.orders.original-price' )}} <i class="fa"></i></a></th> -->
				<!-- <th><a href="#" class="sorter" data-sort-by="purchase_price" data-sort="{{-- $sort --}}">{{ trans('administration.orders.discounted-price' )}} <i class="fa"></i></a></th> -->
				<!-- <th><a href="#" class="sorter" data-sort-by="tax" data-sort="{{-- $sort --}}">{{ trans('administration.orders.tax' )}} <i class="fa"></i></a></th> -->
				<!-- <th><a href="#" class="sorter" data-sort-by="instructor_earnings" data-sort="{{-- $sort --}}">{{ trans('administration.orders.instructor-income' )}} <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="affiliate_earnings" data-sort="{{-- $sort --}}">{{ trans('administration.orders.affiliate-income' )}} <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="ltc_affiliate_earnings" data-sort="{{-- $sort --}}">{{ trans('administration.orders.ltc-income' )}} <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="second_tier_affiliate_earnings" data-sort="{{-- $sort --}}">{{ trans('administration.orders.2-tier-affiliate-income' )}} <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="second_tier_instructor_earnings" data-sort="{{-- $sort --}}">{{ trans('administration.orders.2-tier-instructor-income' )}} <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="buyer_name" data-sort="{{-- $sort --}}">{{ trans('administration.orders.buyer-name' )}} <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="buyer_email" data-sort="{{-- $sort --}}">{{ trans('administration.orders.buyer-email' )}} <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="created_at" data-sort="{{-- $sort --}}">{{ trans('administration.orders.transaction-date' )}} <i class="fa"></i></a></th> -->
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			{{View::make('administration.orders.order_items', compact('orders'))}}
		</tbody>
	</table>
</div>
<div class="no-padding">
{{ $orders->appends(Input::only('start','limit', 'sort_data', 'sort_list', 'course_name', 'course_category', 'filter', 'email', 'sale_amount_low', 'sale_amount_high', 'product_price_low', 'product_price_high', 'purchase_date_low', 'purchase_date_high', 'transaction_id'))->links() }}
</div>
<!--
<script>
addSorterIndicator();
</script>
-->