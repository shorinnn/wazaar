@if(count($courses) >= 1)
	@foreach($courses as $i => $course)
	<tr>
		<td style="text-align:center;"><input type="checkbox" class="course_checkbox" name="cids[]" value="{{$course->id}}"></td>
		<td style="text-align:center;">{{$i+1}}</td>
		<td style="text-align:left !important;">{{$course->name}}</td>
		<td><input type="text" name="order[{{$course->id}}]" class="order-list-input" value="{{$course->order}}"></td>
	</tr>
	@endforeach
@else
	<tr>
		<td colspan="4" class="text-center" style="font-size: 14px; color: #7e8e9e;line-height: 20px;text-align: center;">
        {{ trans('administration.picks.no-course' )}}
        </td>
	</tr>
@endif