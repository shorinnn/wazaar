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
          <input type="checkbox" class="switch-input ajax-updatable"  value='yes'
                 data-checked-val='yes' data-unchecked-val='no'
                 data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}'
                      data-name='published'
                 @if($lesson->published=='yes')
                     checked="checked"
                 @endif
                 />
          <span data-off="No" data-on="Yes" class="switch-label"></span>
          <span class="switch-handle"></span>
        </label>
    </div>    
    <!--{{ Form::select( 'published', ['no'=>'No', 'yes'=>'Yes'], $lesson->published, ['data-name'=>'published', 'class'=>'ajax-updatable', 
                'data-url'=> action('LessonsController@update', [$lesson->module->id, $lesson->id] )] ) }}-->
</div>

