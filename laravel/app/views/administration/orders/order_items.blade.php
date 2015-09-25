@if(count($orders) >= 1)
	@foreach($orders as $i => $order)
	<tr>
		<td>{{$order->payment_ref}}</td>
		<td>{{$order->created_at->format('l jS \\of F Y h:i:s A')}}</td>
		<td>{{$order->student_id}}</td>
	</tr>
	@endforeach
@else
	<tr>
		<td colspan="4" class="text-center">no order found</td>
	</tr>
@endif