<li id="module-{{ $module->id }}">
    Module <span class="module-order">{{ $module->order }}</span>
    <input type="hidden" class="module-order ajax-updatable" value="{{$module->order}}"
           data-url='{{action('ModulesController@update', $module->id)}}' data-name='order' /> 
    
    <input type="text" value="{{$module->name}}" class='ajax-updatable' 
           data-url='{{action('ModulesController@update', $module->id)}}' data-name='name' />
    {{ Form::open(array('action' => ['ModulesController@destroy', $module->id], 'method' => 'delete', 
                'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#module-'.$module->id )) }}
            <button type="submit" class="btn btn-danger btn-mini delete-button" data-message="{{ trans('crud/labels.you-sure-want-delete') }}">X</button>
    {{ Form::close() }}
    <span class="sortable-handle">[dragicon]</span> 
    <ul class="lessons" id="lessons-holder-{{$module->id}}">
        @foreach($module->lessons()->orderBy('order','ASC')->get() as $lesson)
            {{ View::make('courses.lessons.lesson')->with(compact('lesson')) }}
        @endforeach
    </ul>
    <form method='post' class='ajax-form' id="modules-form" data-callback='addLesson'
      action='{{action('LessonsController@store')}}'>
        <input type='hidden' name='_token' value='{{ csrf_token() }}' />
        <input type='hidden' name='module_id' value='{{ $module->id }}' />
        <button type='submit' class='btn btn-primary'>Add Lesson</button>
    </form>
</li>