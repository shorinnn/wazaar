<li id="module-{{ $module->id }}">
	<div class="new-module">
        <span>
        	{{ trans('general.module') }} 
            <span class="module-order">{{ $module->order }}</span>
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
            {{ Form::open(array('action' => ['ModulesController@destroy', $module->course->id, $module->id], 'method' => 'delete', 
                        'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#module-'.$module->id )) }}
                    <button type="submit" name="delete-module-{{$module->id}}" class="delete-button" data-message="{{ trans('crud/labels.you-sure-want-delete') }}"></button>
            {{ Form::close() }}
        </div>
    </div>
        <ul class="lesson-container clearfix lessons" id="lessons-holder-{{$module->id}}">
            @foreach($module->lessons()->orderBy('order','ASC')->get() as $lesson)
                {{ View::make('courses.lessons.lesson')->with(compact('lesson')) }}
            @endforeach
        </ul>
            <form method='post' class='ajax-form' id="modules-form" data-callback='addLesson'
              action='{{action('LessonsController@store', $module->id)}}'>
                <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                <button type='submit' class='create-lesson-button'>{{ trans('crud/labels.add_lesson') }}</button>
            </form>
</li>