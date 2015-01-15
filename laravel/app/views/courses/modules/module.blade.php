<li id="module-{{ $module->id }}">
    {{ trans('general.module') }} <span class="module-order">{{ $module->order }}</span>
    <input type="hidden" class="module-order ajax-updatable" value="{{$module->order}}"
           data-url='{{action('ModulesController@update', [$module->course->id, $module->id] )}}' data-name='order' /> 
    
    <input type="text" value="{{$module->name}}" class='ajax-updatable' 
           data-url='{{action('ModulesController@update', [$module->course->id, $module->id] )}}' data-name='name' />
    {{ Form::open(array('action' => ['ModulesController@destroy', $module->course->id, $module->id], 'method' => 'delete', 
                'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#module-'.$module->id )) }}
            <button type="submit" name="delete-module-{{$module->id}}" class="btn btn-danger btn-mini delete-button" data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i></button>
    {{ Form::close() }}
    <i class="sortable-handle fa fa-bars"></i> 
    <ul class="lessons" id="lessons-holder-{{$module->id}}">
        @foreach($module->lessons()->orderBy('order','ASC')->get() as $lesson)
            {{ View::make('courses.lessons.lesson')->with(compact('lesson')) }}
        @endforeach
    </ul>
    <form method='post' class='ajax-form' id="modules-form" data-callback='addLesson'
      action='{{action('LessonsController@store', $module->id)}}'>
        <input type='hidden' name='_token' value='{{ csrf_token() }}' />
        <button type='submit' class='btn btn-primary'>{{ trans('crud/labels.add_lesson') }}</button>
    </form>
</li>