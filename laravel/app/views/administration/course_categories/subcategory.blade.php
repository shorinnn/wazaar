<li id='subcategory-{{$subcategory->id}}'>
 <input type="text" value="{{$subcategory->name}}" class='ajax-updatable' 
        data-url='{{action('CoursesSubcategoriesController@update', $subcategory->id )}}' data-name='name' placeholder="{{trans('crud/labels.name')}}" />
 
 <input type="text" value="{{$subcategory->description}}" class='ajax-updatable' 
        data-url='{{action('CoursesSubcategoriesController@update', $subcategory->id )}}' data-name='description' placeholder="{{trans('crud/labels.description')}}" />
 
 {{ Form::open(array('action' => ['CoursesSubcategoriesController@update', $subcategory->id], 'method' => 'delete', 
                'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#subcategory-'.$subcategory->id )) }}
            <button type="submit" name="delete-subcategory-{{$subcategory->id}}" class="btn btn-danger btn-mini delete-button" 
                    data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i></button>
    {{ Form::close() }}
</li>