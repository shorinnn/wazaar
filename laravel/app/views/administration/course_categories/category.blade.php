<li id='category-{{$category->id}}'>
    <input type="text" value="{{$category->name}}" class='ajax-updatable' 
           data-url='{{action('CoursesCategoriesController@update', $category->id )}}' data-name='name' />
    
    {{ Form::open(array('action' => ['CoursesCategoriesController@update', $category->id], 'method' => 'delete', 
                'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#category-'.$category->id )) }}
            <button type="submit" name="delete-category-{{$category->id}}" class="btn btn-danger btn-mini delete-button" 
                    data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i></button>
    {{ Form::close() }}
    
    <button type="button" class="btn btn-primary slide-toggler" data-target=".category-options-{{$category->id}}">
        <i class="fa fa-pencil-square-o" data-target=".category-options-{{$category->id}}"></i>
    </button>
    <div class='options-div category-options-{{$category->id}}'>
        {{trans('crud/labels.description')}} <textarea name='description' class='ajax-updatable' 
               data-url='{{action('CoursesCategoriesController@update', $category->id )}}' data-name='description'>{{$category->description}}</textarea>
        <br />
        Color Scheme:
        <br />
        <form>
            
            @for($i=1; $i<10; $i++)
                <?php
                $checked = $i==$category->color_scheme ? 'checked="checked"' : '' ;
                ?>
                <input {{$checked}} type='radio' name='color_scheme' value='{{$i}}'  class='ajax-updatable' 
               data-url='{{action('CoursesCategoriesController@update', $category->id )}}' data-name='color_scheme' />
                <div class='color-scheme-thumb unauthenticated-homepage cat-box-{{$i}}'></div>
            @endfor

        </form>
        <br />
        {{ trans('general.homepage_graphic') }}
        
        {{ View::make('administration.course_categories.graphics')->with(compact('category')) }}
        
        <form method='post' class='ajax-form' action='{{action('CoursesCategoriesController@graphics_url', $category->id)}}'>
            <input type='hidden' name='_token' value='{{ csrf_token() }}' />
            <input type='file' name='file' id='file-upload-{{$category->id}}' data-dropzone='' data-replace='#category-graphics-{{$category->id}}'
                   class='ajax-file-uploader' data-progress-bar='.progress-bar-{{$category->id}}' data-callback='replaceElementWithUploaded' />
        </form>

        <div class="progress">
            <div class="progress-bar progress-bar-striped active progress-bar-{{$category->id}}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                <span></span>
            </div>
        </div>
    </div>
    
    <ul class="first-sub" id="subcategory-holder-{{$category->id}}">
        @foreach($category->courseSubcategories as $subcategory)
            {{ View::make('administration.course_categories.subcategory')->with(compact('subcategory')) }}
        @endforeach
    </ul>
    <form method='post' class='ajax-form' data-callback='addToList' data-destination="#subcategory-holder-{{$category->id}}"
      action='{{action('CoursesSubcategoriesController@store')}}' id='add-subcat-{{$category->id}}'>
        <input type='hidden' name='category_id' value="{{$category->id}}" />
        <input type='hidden' name='_token' value='{{ csrf_token() }}' />
        <input type='text' name='name' placeholder="{{trans('crud/labels.name')}}" />
        <button type='submit' class='btn btn-primary'>{{ trans('crud/labels.add_subcategory') }}</button>
    </form>
</li>