<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th><a href="#" class="sorter" data-sort-by="payment_ref" data-sort="{{$sort}}">transaction id <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="course_name" data-sort="{{$sort}}">course name <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="owner_name" data-sort="{{$sort}}">course owner <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="owner_email" data-sort="{{$sort}}">course owner email <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="original_price" data-sort="{{$sort}}">original price <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="purchase_price" data-sort="{{$sort}}">discounted price <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="site_earnings" data-sort="{{$sort}}">wazaar cut <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="instructor_earnings" data-sort="{{$sort}}">instructor cut <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="affiliate_earnings" data-sort="{{$sort}}">affiliate cut <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="ltc_affiliate_earnings" data-sort="{{$sort}}">ltc cut <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="second_tier_affiliate_earnings" data-sort="{{$sort}}">2 tier affiliate cut <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="second_tier_instructor_earnings" data-sort="{{$sort}}">2 tier publisher cut <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="buyer_name" data-sort="{{$sort}}">purchaser name <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="buyer_email" data-sort="{{$sort}}">purchaser email <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="created_at" data-sort="{{$sort}}">order date <i class="fa"></i></a></th>
			</tr>
		</thead>
		<tbody>
			{{View::make('administration.orders.order_items', compact('orders'))}}
		</tbody>
	</table>
</div>
<div class="container no-padding">
{{ $orders->appends(Input::only('start','limit', 'sort', 'sort_by', 'search'))->links() }}
</div>
<script>
addSorterIndicator();
</script>
