<div class="clear clearfix">
	<p>{{ trans('crud/labels.description') }}</p> 
	<textarea class="ajax-updatable"  data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}'
                      data-name="description">{{ $lesson->description }}</textarea><br />
</div>

<div class="clear clearfix">
    <p>{{ trans('general.lesson_price') }}</p> 
    <input type="text" class="ajax-updatable"  data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}'
                      data-name='price' value="{{ $lesson->price }}" /><br />
</div>

<div class="clear clearfix">
    <p>{{ trans('general.published') }}</p> 
    <div class="switch-buttons">
        <label class="switch">
          <input type="checkbox" class="switch-input ajax-updatable"  value='{{ trans('courses/curriculum.yes') }}'
                 data-checked-val='{{ trans('courses/curriculum.yes') }}' data-unchecked-val='{{ trans('courses/curriculum.no') }}'
                 data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}'
                      data-name='published'
                 @if($lesson->published=='yes')
                     checked="checked"
                 @endif
                 />
          <span data-off="{{ trans('courses/curriculum.no') }}" data-on="{{ trans('courses/curriculum.yes') }}" class="switch-label"></span>
          <span class="switch-handle"></span>
        </label>
    </div>    
    <!--{{ Form::select( 'published', ['no'=>'No', 'yes'=>'Yes'], $lesson->published, ['data-name'=>'published', 'class'=>'ajax-updatable', 
                'data-url'=> action('LessonsController@update', [$lesson->module->id, $lesson->id] )] ) }}-->
</div>

