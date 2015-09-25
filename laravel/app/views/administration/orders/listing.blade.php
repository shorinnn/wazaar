<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<td><a href="#" class="sorter" data-sort-by="payment_ref" data-sort="{{$sort}}">transaction id <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="" data-sort="{{$sort}}">course name <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="" data-sort="{{$sort}}">course owner <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="" data-sort="{{$sort}}">course owner email <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="original_price" data-sort="{{$sort}}">original price <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="purchase_price" data-sort="{{$sort}}">discounted price <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="site_earnings" data-sort="{{$sort}}">wazaar cut <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="instructor_earnings" data-sort="{{$sort}}">instructor cut <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="affiliate_earnings" data-sort="{{$sort}}">affiliate cut <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="ltc_affiliate_earnings" data-sort="{{$sort}}">ltc cut <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="second_tier_affiliate_earnings" data-sort="{{$sort}}">2 tier affiliate cut <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="second_tier_instructor_earnings" data-sort="{{$sort}}">2 tier publisher cut <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="" data-sort="{{$sort}}">purchaser name <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="" data-sort="{{$sort}}">purchaser email <i class="fa"></i></a></td>
			<td><a href="#" class="sorter" data-sort-by="created_at" data-sort="asc">order date <i class="fa"></i></a></td>
		</tr>
	</thead>
	<tbody>
		{{View::make('administration.orders.order_items', compact('orders'))}}
	</tbody>
</table>
<div class="container no-padding">
{{ $orders->appends(Input::only('start','limit', 'sort', 'sort_by'))->links() }}
</div>
@if($page >= 2)
<script>
triggerSorter();
addSorterIndicator();
</script>
@endif