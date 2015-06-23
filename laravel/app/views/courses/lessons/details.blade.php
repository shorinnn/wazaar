<p class="tip"> {{ trans('courses/create.options-tip') }}</p>

<div class="clear clearfix">
	<h4>{{ trans('crud/labels.description') }}</h4> 
	<textarea class="ajax-updatable"  data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}'
                      data-name="description">{{ $lesson->description }}</textarea><br />
</div>

   <div class="row editor-settings-layout margin-bottom-30">
            <h4>{{ trans('courses/general.individual-sale') }}</h4>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="toggle-switch">
                <label class="toggle-button
                       @if($lesson->individual_sale=='yes') active @endif" for="individual-sale-yes-{{$lesson->id}}">
                    {{ Form::radio('individual_sale', 'yes', ($lesson->individual_sale=='yes'), 
                                ['id'=>'individual-sale-yes-'.$lesson->id,
                                'class' => 'ajax-updatable',
                                'onchange' => 'toggleVisible(event)',
                                'data-visible' => 'show',
                                'data-target' => '.price-holder-'.$lesson->id,
                                'data-url' => action('LessonsController@update', [$lesson->module->id, $lesson->id] ),
                                'data-name' => 'individual_sale',
                                'value' => 'yes'] ) }}
                    {{ trans('courses/curriculum.yes') }}
                </label>
                <label class="toggle-button
                       @if($lesson->individual_sale=='no') active @endif" for="individual-sale-no-{{$lesson->id}}">
                    {{ Form::radio('individual_sale', 'no', ($lesson->individual_sale=='no'), 
                                ['id'=>'individual-sale-no-'.$lesson->id,
                                'class' => 'ajax-updatable',
                                'onchange' => 'toggleVisible(event)',
                                'data-visible' => 'hide',
                                'data-target' => '.price-holder-'.$lesson->id,
                                'data-url' => action('LessonsController@update', [$lesson->module->id, $lesson->id] ),
                                'data-name' => 'individual_sale',
                                'value' => 'no'] ) }}
                    {{ trans('courses/curriculum.no') }}
                </label>
            </div>
        </div>
    </div>

   <div class="row editor-settings-layout margin-bottom-30">
        
            <h4>{{ trans('courses/general.free-preview') }}</h4>
       
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="toggle-switch">
                <label class="toggle-button
                       @if($lesson->free_preview=='yes') active @endif" for="free_preview-yes-{{$lesson->id}}">
                    {{ Form::radio('free_preview', 'yes', ($lesson->free_preview=='yes'), 
                                ['id'=>'free_preview-yes-'.$lesson->id,
                                'class' => 'ajax-updatable toggle-disable',
                                'data-target' => '#price-'.$lesson->id,
                                'data-disable' => 'disable',
                                'data-url' => action('LessonsController@update', [$lesson->module->id, $lesson->id] ),
                                'data-name' => 'free_preview',
                                'value' => 'yes'] ) }}
                    {{ trans('courses/curriculum.yes') }}
                </label>
                <label class="toggle-button
                       @if($lesson->free_preview=='no') active @endif" for="free_preview-no-{{$lesson->id}}">
                    {{ Form::radio('free_preview', 'no', ($lesson->free_preview=='no'), 
                                ['id'=>'free_preview-no-'.$lesson->id,
                                'class' => 'ajax-updatable toggle-disable',
                                'data-target' => '#price-'.$lesson->id,
                                'data-disable' => 'enable',
                                'data-url' => action('LessonsController@update', [$lesson->module->id, $lesson->id] ),
                                'data-name' => 'free_preview',
                                'value' => 'no'] ) }}
                    {{ trans('courses/curriculum.no') }}
                </label>
            </div>
        </div>
    </div>

<div class="clear clearfix price-holder-{{$lesson->id}}"
        @if($lesson->individual_sale=='no')
               style="display:none"
           @endif
           >
    <h4>{{ trans('general.lesson_price') }}</h4> 
    <input type="text" 
           @if($lesson->free_preview=='yes')
                disabled="disabled"
           @endif
           
       
           
           class="ajax-updatable"  
           data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}'
                      data-name='price' id='price-{{$lesson->id}}' value="{{ $lesson->price }}" /><br />
</div>

<!--<div class="clear clearfix">
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
    {{ Form::select( 'published', ['no'=>'No', 'yes'=>'Yes'], $lesson->published, ['data-name'=>'published', 'class'=>'ajax-updatable', 
                'data-url'=> action('LessonsController@update', [$lesson->module->id, $lesson->id] )] ) }}
</div>-->

<script>
    $('.toggle-switch .toggle-button').on('click', function(){
        $(this).addClass('active');
        if($(this).hasClass('active')){
                $(this).closest('.toggle-switch').find('.toggle-button').not(this).removeClass('active');
        }
    });	
</script>