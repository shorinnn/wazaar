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
    {{ Form::select( 'published', ['no'=>'No', 'yes'=>'Yes'], $lesson->published, ['data-name'=>'published', 'class'=>'ajax-updatable', 
                'data-url'=> action('LessonsController@update', [$lesson->module->id, $lesson->id] )] ) }}
</div>