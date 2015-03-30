<li id='subcategory-{{$difficulty->id}}'>
 <input type="text" value="{{$difficulty->name}}" class='ajax-updatable' 
        data-url='{{action('CourseDifficultiesController@update', $difficulty->id )}}' data-name='name' placeholder="{{trans('crud/labels.name')}}" />
 
 {{ Form::open(array('action' => ['CourseDifficultiesController@update', $difficulty->id], 'method' => 'delete', 
                'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#subcategory-'.$difficulty->id )) }}
            <button type="submit" name="delete-subcategory-{{$difficulty->id}}" class="btn btn-danger btn-mini delete-button" 
                    data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i></button>
    {{ Form::close() }}
</li>