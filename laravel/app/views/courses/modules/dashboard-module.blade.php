<li id="module-{{ $module->id }}">
	<div class="new-module">
        <span>
        	{{ trans('general.opening-lesson') }}
        </span>
        <input type="hidden" class="module-order ajax-updatable" value="{{$module->order}}"
               data-url='{{action('ModulesController@update', [$module->course->id, $module->id] )}}' data-name='order' /> 
        
        <input type="text" value="{{$module->name}}" class='ajax-updatable' 
        	data-url='{{action('ModulesController@update', [$module->course->id, $module->id] )}}' 
                placeholder="{{trans('courses/create.enter-module-name')}}" data-name='name' />
        <div class="buttons">       
            <!--<i class="sortable-handle fa fa-bars"></i> -->
            <div class="sortable-handle menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
        <ul class="lesson-container clearfix lessons" id="lessons-holder-{{$module->id}}">
            @foreach($module->lessons()->orderBy('order','ASC')->get() as $lesson)
                {{ View::make('courses.lessons.dashboard-lesson')->with(compact('lesson')) }}
            @endforeach
        </ul>
</li>