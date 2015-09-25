@if(count($orders) >= 1)
	@foreach($orders as $i => $order)
	<?php
		$user = User::where('id', '=', $order->student_id)->first();
		$course = Course::where('id', '=', $order->product_id)->first();
	?>
	<tr>
		<td>{{$order->payment_ref}}</td>
		<td>{{$course->name}}</td>
		<td>{{$course->instructor->last_name.', '.$course->instructor->first_name}}</td>
		<td>{{$course->instructor->email}}</td>
		<td>{{$order->original_price}}</td>
		<td>{{$order->purchase_price}}</td>
		<td>{{$order->site_earnings}}</td>
		<td>{{$order->instructor_earnings}}</td>
		<td>{{$order->affiliate_earnings}}</td>
		<td>{{$order->ltc_affiliate_earnings}}</td>
		<td>{{$order->second_tier_affiliate_earnings}}</td>
		<td>{{$order->second_tier_instructor_earnings}}</td>
		<td>{{$user->last_name.', '.$user->first_name}}</td>
		<td>{{$user->email}}</td>
		<td>{{$order->created_at->format('l jS \\of F Y h:i:s A')}}</td>
	</tr>
	@endforeach
@else
	<tr>
		<td colspan="4" class="text-center">no order found</td>
	</tr>
@endif