<li id="lesson-{{$lesson->id}}">
    Lesson <span class="lesson-order">{{ $lesson->order }}</span> - 
    <input type="hidden" class="lesson-order ajax-updatable" value="{{$lesson->order}}"
           data-url='{{action('LessonsController@update', $lesson->id)}}' data-name='order' /> 
    
    <input type="text" class="ajax-updatable" value="{{$lesson->name}}"
           data-url='{{action('LessonsController@update', $lesson->id)}}' data-name='name'  />
    <button type="button" class="btn btn-primary"></button>
    {{ Form::open(array('action' => ['LessonsController@destroy', $lesson->id], 'method' => 'delete', 
                'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#lesson-'.$lesson->id )) }}
            <button type="submit" class="btn btn-danger btn-mini delete-button" data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i></button>
    {{ Form::close() }}
    <span class="sortable-handle">[dragicon]</span> 
</li>