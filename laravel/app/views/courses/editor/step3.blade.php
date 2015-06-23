<input type='hidden' class='step-3-filled' value='{{ $course->course_difficulty_id > 0 ? 1 : 0}}' />
{{ Form::model($course, ['action' => ['CoursesController@update', $course->slug], 'data-parsley-validate' => '1',
                'id'=>'edit-course-form', 'files' => true, 'method' => 'PUT', 'class' => 'ajax-form step-3-form',  'data-callback'=>'submittedCourse']) }}
    <input type='hidden' name='publish_status' value='1' />
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 left-content">
    <div class="approval-box">
            <h4 class="not-approved">
                {{ ucfirst( trans( 'courses/statuses.'.$course->publish_status ) ) }}
            </h4>
        @if($course->publish_status =='unsubmitted')
            <p class="regular-paragraph">
                {{ trans('courses/create.wazaar_must_review') }}
            </p>
        @endif
    </div>
    <div class="row editor-settings-layout margin-bottom-30">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">{{ trans('courses/curriculum.enable-ask-coach') }} 
            <span class="lead">{{ trans('courses/general.enable-ask-coach-tip') }}</span>
            </h4>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="toggle-switch">
                <label class="toggle-button
                       @if($course->ask_teacher=='enabled') active @endif" for="ask-enabled">
                    {{ Form::radio('ask_teacher', 'enabled', ($course->ask_teacher=='enabled'), ['id'=>'ask-enabled'] ) }}
                    {{trans('courses/curriculum.yes')}}
                </label>
                <label class="toggle-button
                       @if($course->ask_teacher=='disabled') active @endif" for="ask-disabled">
                    {{ Form::radio('ask_teacher', 'disabled', ($course->ask_teacher=='disabled'), ['id'=>'ask-disabled'] ) }}
                    {{trans('courses/curriculum.no')}}
                </label>
<!--                <button name="yes" class="toggle-button">Yes</button>
                <button name="no" class="toggle-button">No</button>-->
            </div>
        </div>
        
    </div>
    <div class="row editor-settings-layout margin-bottom-30">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">{{ ucwords( trans('courses/statuses.public') ) }} </h4>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="toggle-switch">
                <label class="toggle-button
                       @if($course->privacy_status=='public') active @endif" for="privacy-public">
                    {{ Form::radio('privacy_status', 'public', ($course->privacy_status=='public'), ['id'=>'privacy-public'] ) }}
                    {{trans('courses/curriculum.yes')}}
                </label>
                <label class="toggle-button
                       @if($course->privacy_status=='private') active @endif" for="privacy-private">
                    {{ Form::radio('privacy_status', 'private', ($course->privacy_status=='private'), ['id'=>'privacy-private'] ) }}
                    {{trans('courses/curriculum.no')}}
                </label>
            </div>
        </div>
    </div>
       <?php
       /** TEMPORARILY HIDE PAYMENT TYPE AS IT'S NOT REQUIRED 
    <div class="row editor-settings-layout margin-bottom-30">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">{{ trans('courses/general.payment_type') }}</h4>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            {{ Form::select('payment_type', [ 'one_time' => trans('courses/general.one_time'), 
            'subscription' =>  trans('courses/general.subscription') ], null,['class'=>''] ) }}
            <span class="regular-paragraph clue-text">{{ trans('courses/general.how_users_will_pay') }}</span>
        </div>
    </div>
        * 
        */?>
    <div class="row editor-settings-layout margin-bottom-30">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">{{ trans('courses/general.difficulty') }}</h4>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="course-level toggle-switch btn-group clearfix">
                <div class="clearfix">
                     @foreach($difficulties as $key=>$difficulty)
                     <?php
                        $checked = ($key==$course->course_difficulty_id) ? 'checked="checked"' : '';
                        $active = ($key==$course->course_difficulty_id) ? 'active' : '';
                     ?>
                        <label class="toggle-button {{$active}}" for="option{{$key}}">
                            <input type='radio' name='course_difficulty_id' id="option{{$key}}" 
                            autocomplete="off" value='{{$key}}' 
                            {{$checked}} required /> {{ trans('general.'.$difficulty) }}
                        </label>
                     @endforeach
                 </div>
            </div>
        </div>
    </div>
    
    <div class="row editor-settings-layout margin-bottom-30">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">{{ trans('courses/general.price') }}</h4>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="value-unit">
                    <!--<input type="text" name="amount">-->
                    {{  Form::text( 'price', money_val($course->price),
                                            ['class' => 'delayed-keyup', 'data-delay' => '5000', 'data-callback' => 'adjustPrice'] ) }}
                <span>¥</span>
            </div>
        </div>
    </div>
    <div class="row editor-settings-layout margin-bottom-30">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">{{ trans('courses/general.affiliate_percentage') }} 
            <span class="lead">{{ trans('courses/general.affiliate-percentage-tip') }}</span></h4>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <div class="value-unit">
                <input type="text" class='span2 clear right' name='affiliate_percentage' id='affiliate_percentage' 
                    value="{{ $course->affiliate_percentage }}" data-slider-min="0" data-slider-max="68" 
                    data-slider-step="1" data-slider-value="{{ intval( $course->affiliate_percentage ) }}" 
                    data-slider-orientation="horizontal" 
                    data-slider-selection="after" data-slider-tooltip="show" data-label="#affiliate_percentage_output" 
                    data-target-input='1' />
                    <!--<input type="text" name="amount">-->
                <span>%</span>
            </div>
        </div>
    </div>
    <div class="row editor-settings-layout margin-bottom-30">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <h4 class="text-right">{{ trans('courses/general.discount') }} </h4>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <div class="value-unit">
            {{ Form::text('sale', money_val($course->sale),
                ['onkeyup' => 'toggleElementViaOther(event)', 
                'class' => 'delayed-keyup', 'data-delay' => '5000', 'data-callback' => 'adjustDiscount',
                'data-saleType' => 'sale_kind',
                'data-destination'=>'.sale-ends-on', 'data-hide-on' => '0', 'data-is-int' => 1 ]) }}
            <span>¥</span>
        </div>
    </div>
        <!--
    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" id="discount">
          {{ Form::select('sale_kind', ['amount' => '¥', 'percentage' => '%'], null,
      ['class'=>''] ) }}
    </div>-->
    </div>
        <div class='sale-ends-on' @if($course->sale == 0) style='display:none' @endif >
            <div class="row editor-settings-layout margin-bottom-30">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <h4 class="text-right">{{ trans('courses/general.sale_starts_on') }}</h4>
                </div>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="calender">
                          <div class="clear clearfix input-group date">
                              {{ Form::text('sale_starts_on', null, ['class'=>'form-control sales-end-calender datetimepicker']) }}
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                    </div>
                </div>
            </div>
            <div class="row editor-settings-layout margin-bottom-30">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <h4 class="text-right">{{ trans('courses/general.sale_ends_on') }}</h4>
                </div>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="calender">
                        <div class="clear clearfix input-group date">
                            {{ Form::text('sale_ends_on', null, ['class'=>'form-control sales-end-calender datetimepicker']) }}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 right-content">
    <h2>{{ trans('courses/general.course_summary') }}</h2>
    <div class="row category-row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <p class="regular-paragraph">{{ trans('courses/general.category') }}</p>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <p class="regular-paragraph semibold-text">
                        {{ Form::select('course_category_id', $categories, $course->course_category_id, ['onChange'=>'populateDropdown(this)', 'data-target'=>'#course_subcategory_id', 
                                    'data-url'=> action('CoursesCategoriesController@subcategories_instructor'), 'required', 'class'=>'']) }}
                    </p>
                </div>
            </div>
            <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <p class="regular-paragraph">{{ trans('courses/general.subcategory') }}</p>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <p class="regular-paragraph semibold-text">
                        {{ Form::select('course_subcategory_id', $subcategories, $course->course_subcategory_id,
                                    ['id'=>'course_subcategory_id', 'class'=>'']) }}
                    </p>
                </div>
            </div>
            <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <p class="regular-paragraph">{{ trans('courses/general.price') }}: </p>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <p class="regular-paragraph semibold-text">
                        ¥ {{ number_format($course->price, Config::get('custom.currency_decimals')) }}
                    </p>
                </div>
            </div>
            <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <p class="regular-paragraph">{{ trans('courses/general.modules') }}: </p>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <p class="regular-paragraph semibold-text"> {{ $course->modules()->count() }}</p>
                </div>
            </div>
            <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <p class="regular-paragraph">{{ trans('courses/general.total_lessons') }}: </p>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <p class="regular-paragraph semibold-text"> {{ $course->lessonCount() }}</p>
                </div>
            </div>
        </div>
        <!--<a href="#" class="edit-button">Edit</a>-->
    </div>
                    <div class="row margin-top-40">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>{{ trans('courses/general.description') }}:</h4>
            <p class="regular-paragraph text-left">
                {{ strip_tags($course->description) }}
            
            </p>
        </div>
    </div>
                    <div class="row margin-top-40">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>{{ trans('courses/general.who_is_this_for?') }}:</h4>
            <ul>
                    @if($values = json2Array($course->who_is_this_for))
                        @foreach($values as $val)
                            <li>{{$val}}</li>
                        @endforeach
                    @endif
            </ul>
        </div>
    </div>
                    <div class="row margin-top-40">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>{{ trans('courses/general.requirements') }}:</h4>
            <ul>
                    @if($values = json2Array($course->requirements))
                        @foreach($values as $val)
                            <li>{{$val}}</li>
                        @endforeach
                    @endif
            </ul>
        </div>
    </div>
                    <div class="row margin-top-40">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>{{ trans('courses/general.by_the_end') }}:</h4>
            <ul>
                    @if($values = json2Array($course->what_will_you_achieve))
                        @foreach($values as $val)
                            <li>{{$val}}</li>
                        @endforeach
                    @endif
            </ul>
        </div>
    </div>
    <div class="row next-step-button">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <button type='submit' class="blue-button extra-large-button">{{ trans('courses/general.submit-for-approval')}}</button>
        </div>
    </div>
</div>
{{ Form::close() }}
<script src="{{url('js/moment.js')}}" type="text/javascript"></script>
<script src="{{url('js/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
<script type="text/javascript"> 
    $('.datetimepicker').datetimepicker( { 
        sideBySide:true,
        extraFormats: ['YYYY-MM-DD hh:mm:s']
    } );
	
    $('.toggle-switch .toggle-button').on('click', function(){
        $(this).addClass('active');
        if($(this).hasClass('active')){
                $(this).closest('.toggle-switch').find('.toggle-button').not(this).removeClass('active');
        }
    });	

    $('.step-3-form input').change(function(){
        if( $('.step-3-form').parsley().isValid() && $('.step-3-filled').val()=='0' ) {
            $('.step-3-filled').val('1');
            course_steps_remaining--;
            $('.steps-remaining p span span').html( course_steps_remaining );
        }
    });

</script>

