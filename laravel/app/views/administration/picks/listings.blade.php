{{ Form::open(['action' => ['PicksController@orderPicks', $type], 'method' => 'post']) }}
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="col-xs-1 col-sm-2 col-md-1">#</th>
				<th class="col-xs-7 col-sm-8 col-md-9">Course Name</th>
				<th class="col-xs-4 col-sm-2 col-md-2">
					<span class="pull-left">Order</span> <button type="submit" class="btn-link pull-right save-order"><i class="fa fa-floppy-o"></i></button>
					<div class="clearfix"></div>
				</th>
			</tr>
		</thead>
		<tbody>
			{{View::make('administration.picks.listing_items', compact('courses'))}}
		</tbody>
	</table>
{{ Form::close() }}