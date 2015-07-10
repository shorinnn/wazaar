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
        <div>
            <div class='checkbox-buttons'  style="display:block">
                {{ Form::open(array('action' => ['CategoryGroupsController@group', $group->id], 'method' => 'PUT', 
                            'class' => 'ajax-form inline-block') ) }}
                  @foreach(CourseCategory::all() as $category)

                    <div class="checkbox-item">
                          <div class="checkbox-checkbox checkbox-checked">
                            <input name='group[]' id="group-{{$category->id}}-{{$group->id}}" autocomplete="off" value='{{ $category->id }}'
                                   @if($group->categories()->where('course_category_id', $category->id)->count() > 0)
                                       checked="checked" 
                                   @endif
                               type="checkbox" />                        
                            <label for="group-{{$category->id}}-{{$group->id}}" class="small-checkbox">
                            </label> {{ $category->name }}
                          </div>  
                        </div>
                    @endforeach
                    <button type='submit' class="btn btn-primary">{{ trans('crud/labels.update') }}</button>
                {{ Form::close() }}
            </div>
            <div class='clearfix'></div>
        </div>
    </div>
    
</li>