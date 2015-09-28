@if(count($orders) >= 1)
	@foreach($orders as $i => $order)
	<?php
		$user = User::where('id', '=', $order->student_id)->first();
		$course = Course::where('id', '=', $order->product_id)->first();
	?>
	<tr>
		<td>{{$order->payment_ref}}</td>
		<td>{{$order->course_name}}</td>
		<td>{{$order->owner_name}}</td>
		<td>{{$order->owner_email}}</td>
		<td>¥ {{number_format($order->original_price, '2', '.', ',')}}</td>
		<td>¥ {{number_format($order->purchase_price, '2', '.', ',')}}</td>
		<td>¥ {{number_format($order->site_earnings, '2', '.', ',')}}</td>
		<td>¥ {{number_format($order->instructor_earnings, '2', '.', ',')}}</td>
		<td>¥ {{number_format($order->affiliate_earnings, '2', '.', ',')}}</td>
		<td>¥ {{number_format($order->ltc_affiliate_earnings, '2', '.', ',')}}</td>
		<td>¥ {{number_format($order->second_tier_affiliate_earnings, '2', '.', ',')}}</td>
		<td>¥ {{number_format($order->second_tier_instructor_earnings, '2', '.', ',')}}</td>
		<td>{{$order->buyer_name}}</td>
		<td>{{$order->buyer_email}}</td>
		<td>{{$order->created_at->format('M d, Y h:i A \\(l\\)')}}</td>
	</tr>
	@endforeach
@else
	<tr>
		<td colspan="4" class="text-center">no order found</td>
	</tr>
@endif