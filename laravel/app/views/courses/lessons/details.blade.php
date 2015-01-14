{{ trans('crud/labels.description') }} <textarea class="ajax-updatable"  data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}'
                      data-name="description">{{ $lesson->description }}</textarea><br />
{{ trans('general.lesson_price') }} <input type="text" class="ajax-updatable"  data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}'
                      data-name='price' value="{{ $lesson->price }}" /><br />
{{ trans('general.published') }} {{ Form::select( 'published', ['no'=>'No', 'yes'=>'Yes'], $lesson->published, ['data-name'=>'published', 'class'=>'ajax-updatable', 
            'data-url'=> action('LessonsController@update', [$lesson->module->id, $lesson->id] )] ) }}