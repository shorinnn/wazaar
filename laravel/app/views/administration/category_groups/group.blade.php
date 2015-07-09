<li id='category-{{$group->id}}'>
    <div class="input-wrapper">
    	<div>
            <input type="text" value="{{$group->name}}" class='ajax-updatable block' 
                   data-url='{{action('CategoryGroupsController@update', $group->id )}}' data-name='name' />
            
            <input type="text" value="{{$group->order}}" class='ajax-updatable block' 
                   data-placeholder='{{ trans('administration.order') }}'
                   data-url='{{action('CategoryGroupsController@update', $group->id )}}' data-name='order' />
            
            {{ Form::open(array('action' => ['CategoryGroupsController@update', $group->id], 'method' => 'delete', 
                        'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#category-'.$group->id )) }}
                    <button type="submit" name="delete-category-{{$group->id}}" class="btn btn-danger btn-mini delete-button" 
                            data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i></button>
            {{ Form::close() }}
            
        </div>
    </div>
    
</li>