@if(count($users) >= 1)
	<?php
		$page = $page - 1;
	?>
	@foreach($users as $i => $user)
	<?php
	// print_r($user);
	$pager = ($limit * $page) + $i + 1;
	?>
	<tr>
		<td>{{$pager}}</td>
		<td>{{$user->id.' '.$user->name}}</td>
		<td>{{$user->email}}</td>
		<td>{{\Carbon\Carbon::parse($user->created_at)->format('M d, Y h:i A \\(l\\)')}}</td>
		<td>{{$user->status}}</td>
		<td>¥ 
			@if($sort_by == 'purchase_total')
				{{number_format($user->purchase_total)}}
			@else
				{{Purchase::where('student_id', $user->id)->sum('purchase_price')}}
			@endif
		</td>
		<td>
		{{$user->role_name}}
		</td>
		<td>
			<button type="button" class="btn btn-danger btn-sm">{{ trans('administration.users.refund' )}}</button>
		</td>
		<td>
			<button type="button" class="btn btn-danger btn-sm">{{ trans('administration.users.refund' )}}</button>
		</td>
	</tr>
	@endforeach
@else
	<tr>
		<td colspan="16" class="text-center">no user found</td>
	</tr>
@endif