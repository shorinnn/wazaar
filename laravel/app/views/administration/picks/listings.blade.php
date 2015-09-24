{{ Form::open(['action' => ['PicksController@orderPicks', $type], 'id' => 'picks-list-form',  'method' => 'post']) }}
	<div class="pull-right" style="margin-bottom:10px;">
		<button class="btn btn-danger" type="button" onclick="deleteCourses();"><i class="fa fa-trash"></i></button>
	</div>
	<div class="clearfix"></div>
	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th style="width:50px; text-align:center"><input type="checkbox" class="course_checkbox toggleAll" name="toggleAll" onchange="toggleCheckboxes(this);" value=""></th>
				<th style="width:50px; text-align:center">#</th>
				<th style="width:auto;">{{ trans('administration.picks.course-name' )}}</th>
				<th style="width:100px;">
					<span class="pull-left">{{ trans('administration.picks.ordering' )}}</span> <button type="button" onclick="saveOrder();" class="btn-link pull-right save-order"><i class="fa fa-floppy-o"></i></button>
					<div class="clearfix"></div>
				</th>
			</tr>
		</thead>
		<tbody>
			{{View::make('administration.picks.listing_items', compact('courses'))}}
		</tbody>
	</table>
{{ Form::close() }}