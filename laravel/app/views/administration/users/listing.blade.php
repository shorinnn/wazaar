<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th><a href="#" class="sorter" data-sort-by="name" data-sort="{{$sort}}">{{ trans('administration.users.label.name' )}} <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="email" data-sort="{{$sort}}">{{ trans('administration.users.label.email' )}} <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="users.created_at" data-sort="{{$sort}}">{{ trans('administration.users.label.join-date' )}} <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="status" data-sort="{{$sort}}">{{ trans('administration.users.label.status' )}} <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="purchase_total" data-sort="{{$sort}}">{{ trans('administration.users.label.total-purchased' )}} <i class="fa"></i></a></th>
				<th><a href="#" class="sorter" data-sort-by="role_name" data-sort="{{$sort}}">{{ trans('administration.users.label.roles' )}} <i class="fa"></i></a></th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			{{View::make('administration.users.user_items', compact('users', 'start', 'limit', 'page'))}}
		</tbody>
	</table>
</div>
<div class="container no-padding">
	{{ $users->appends(Input::only('start', 'limit', 'sort_by', 'sort', 'name', 'email', 'join_date_low', 'join_date_high', 'total_purchased_low', 'total_purchased_high', 'role'))->links() }}
</div>
<script>
	addSorterIndicator();
</script>
