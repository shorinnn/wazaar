@if(count($orders) >= 1)
	@foreach($orders as $i => $order)
	<tr>
		<td>{{$order->id}}</td>
		<td>{{$order->payment_ref}}</td>
		<td>{{$order->course_name}}</td>
		<!-- <td>{{$order->owner_name}}</td> -->
		<!-- <td>{{$order->owner_email}}</td> -->
		<!-- <td>¥ {{number_format($order->original_price)}}</td> -->
		<!-- <td>¥ {{number_format($order->purchase_price)}}</td> -->
		<!-- <td>¥ {{number_format($order->tax)}}</td> -->
		<td>¥ {{number_format($order->site_earnings)}}</td>
		<!-- <td>¥ {{number_format($order->instructor_earnings)}}</td>
		<td>¥ {{number_format($order->affiliate_earnings)}}</td>
		<td>¥ {{number_format($order->ltc_affiliate_earnings)}}</td>
		<td>¥ {{number_format($order->second_tier_affiliate_earnings)}}</td>
		<td>¥ {{number_format($order->second_tier_instructor_earnings)}}</td>
		<td>{{$order->buyer_name}}</td>
		<td>{{$order->buyer_email}}</td>
		<td>{{$order->created_at->format('M d, Y h:i A \\(l\\)')}}</td> -->
		<td>
			<a href="#" class="btn btn-default btn-block">View More</a>
			<!-- @if(!empty($order->payment_ref))
				<button type="button" class="btn btn-danger btn-sm">{{ trans('administration.orders.refund' )}}</button>
			@else
				<button type="button" class="btn btn-danger btn-sm" disabled="disabled">{{ trans('administration.orders.refund' )}}</button>
			@endif -->
		</td>
	</tr>
	@endforeach
@else
	<tr>
		<td colspan="16" class="text-center">no order found</td>
	</tr>
@endif