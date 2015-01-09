<li id="module-{{ $module->id }}">
    Module <span class="module-order">{{ $module->order }}</span>
    <input type="hidden" class="module-order ajax-updatable" value="{{$module->order}}"
           data-url='{{action('ModulesController@update', $module->id)}}' data-name='order' /> 
    
    <input type="text" value="{{$module->name}}" class='ajax-updatable' 
           data-url='{{action('ModulesController@update', $module->id)}}' data-name='name' />
    {{ Form::open(array('action' => ['ModulesController@destroy', $module->id], 'method' => 'delete', 
                'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#module-'.$module->id )) }}
        <button class="btn btn-danger btn-mini delete-button" data-message="{{ trans('crud/labels.you-sure-want-delete') }}">X</button>
    {{ Form::close() }}
    <span class="sortable-handle">[dragicon]</span> 
    <ul class="lessons" id="lessons-holder-{{$module->id}}">
        <li>
            Lesson <span class="lesson-order">1</span> - <input type="text" />
            <button class="btn btn-danger">X</button>
            <span class="sortable-handle">[dragicon]</span> 
        </li>
    </ul>
    <button class="btn btn-primary add-lesson">Add Lesson</button>
</li>