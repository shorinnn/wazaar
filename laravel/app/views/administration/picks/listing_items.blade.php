@if(count($courses) >= 1)
	@foreach($courses as $i => $course)
	<tr>
		<td>{{$i+1}}</td>
		<td>{{$course->name}}</td>
		<td><input type="text" name="order[]" class="order-list-input" value="{{$course->order}}"></td>
	</tr>
	@endforeach
@else
	<tr>
		<td colspan="3" class="text-center">No Courses Picked Yet</td>
	</tr>
@endif