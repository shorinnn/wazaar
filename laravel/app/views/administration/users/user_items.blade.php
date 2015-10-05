@if(count($users) >= 1)
	<?php
		$page = $page - 1;
	?>
	@foreach($users as $i => $user)
	<?php
	$pager = ($limit * $page) + $i + 1;
	?>
	<tr>
		<td>{{$pager}}</td>
		<td>{{$user->name}}</td>
		<td>{{$user->email}}</td>
		<td>{{$user->created_at->format('M d, Y h:i A \\(l\\)')}}</td>
		<td>{{$user->status}}</td>
		<td>¥ {{number_format($user->purchase_total)}}</td>
		<td>
        @foreach($user->roles as $role)
            <span class="label label-info">{{$role->name}}</span>
        @endforeach

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