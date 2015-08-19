<li id='category-{{$category->id}}'>
	<div class="input-wrapper">
    	<div>
            <input type="text" value="{{$category->name}}" class='ajax-updatable block' 
                   data-url='{{action('CoursesCategoriesController@update', $category->id )}}' data-name='name' />
            
            {{ Form::open(array('action' => ['CoursesCategoriesController@update', $category->id], 'method' => 'delete', 
                        'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#category-'.$category->id )) }}
                    <button type="submit" name="delete-category-{{$category->id}}" class="btn btn-danger btn-mini delete-button" 
                            data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i></button>
            {{ Form::close() }}
            <button type="button" class="btn btn-primary slide-toggler" data-target=".category-options-{{$category->id}}">
                <i class="fa fa-pencil-square-o" data-target=".category-options-{{$category->id}}"></i>
            </button>
        </div>
    </div>
    <div class='options-div category-options-{{$category->id}}'>
        {{trans('crud/labels.category-groups')}}
        <br class='clearfix' />
        
        <div class='checkbox-buttons'  style="display:block">
            {{ Form::open(array('action' => ['CoursesCategoriesController@group', $category->id], 'method' => 'PUT', 
                        'class' => 'ajax-form inline-block') ) }}
              @foreach(CategoryGroup::all() as $group)
                
                <div class="checkbox-item">
                      <div class="checkbox-checkbox checkbox-checked">
                        <input name='group[]' id="group-{{$category->id}}-{{$group->id}}" autocomplete="off" value='{{ $group->id }}'
                               @if($group->categories()->where('course_category_id', $category->id)->count() > 0)
                                   checked="checked" 
                               @endif
                           type="checkbox" />                        
                        <label for="group-{{$category->id}}-{{$group->id}}" class="small-checkbox">
                        </label> {{ $group->name }}
                      </div>  
                    </div>
                @endforeach
                <button type='submit' class="btn btn-primary">{{ trans('crud/labels.update') }}</button>
            {{ Form::close() }}
        </div>
        
        
        <div class='clearfix'></div>
        <br />
        
        {{trans('crud/labels.description')}} <textarea name='description' class='ajax-updatable' 
               data-url='{{action('CoursesCategoriesController@update', $category->id )}}' data-name='description'>{{$category->description}}</textarea>
        <br />
        <br />
        {{ trans('administration.color-scheme') }}:
        <br />
        <form class="clearfix">
            <div class="radio-buttons clearfix homepage explore-category">
                <?php $i = 0;?>
            @foreach( $cssClasses as $css )
                <?php
                $i++;
                $checked = $css==$category->graphics_url ? 'checked="checked"' : '' ;
                ?>
                <div class="radio-checkbox radio-checked col-lg-3" style="margin-bottom:10px">
                <input id="color-scheme-{{$category->id}}-{{$i}}" {{$checked}} type='radio' name='graphics_url[{{$category->id}}]' value='{{$css}}'  class='ajax-updatable' 
               data-url='{{action('CoursesCategoriesController@update', $category->id )}}' data-name='graphics_url' />
               <label for="color-scheme-{{$category->id}}-{{$i}}" class="small-radio"></label>
               
                    <div class=" category-box">
                            <a href="#" class="{{$css}}">
                                <em></em><span> {{$css}}</span>
                            </a>
                    </div>
                </div>
            @endforeach
			</div>
        </form>
        <br />
       
    </div>
    
    <ul class="first-sub" id="subcategory-holder-{{$category->id}}">
        @foreach($category->courseSubcategories as $subcategory)
            {{ View::make('administration.course_categories.subcategory')->with(compact('subcategory')) }}
        @endforeach
    </ul>
    <div class="input-wrapper">
    	<div class="subcategory">
            <form method='post' class='ajax-form' data-callback='addToList' data-destination="#subcategory-holder-{{$category->id}}"
              action='{{action('CoursesSubcategoriesController@store')}}' id='add-subcat-{{$category->id}}'>
                <input type='hidden' name='category_id' value="{{$category->id}}" />
                <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                <input type='text' name='name' placeholder="{{trans('crud/labels.name')}}" class="block" />
                <button type='submit' class='btn btn-primary'>{{ trans('crud/labels.add_subcategory') }}</button>
            </form>
        </div>
    </div>
</li>