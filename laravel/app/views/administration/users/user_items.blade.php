@if(count($users) >= 1)
	@foreach($users as $i => $user)
	<tr>
		<td>{{$i}}</td>
		<td>{{$user->name}}</td>
		<td>{{$user->email}}</td>
		<td>{{$user->created_at->format('M d, Y h:i A \\(l\\)')}}</td>
		<td>{{$user->status}}</td>
		<td>¥ {{number_format($user->purchase_total)}}</td>
		<td>{{$user->role_name}}</td>
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