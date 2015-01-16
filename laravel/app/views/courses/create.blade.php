@extends('layouts.default')
@section('content')	
<style>
    .ui-select{
        position:relative;
    }
    .animated-step{
        border:1px solid transparent !important;
    }
</style>
<div class="container create-course">
<div class="row">
	<div class="col-md-12">
        <h1>{{ trans('courses/create.creating_a_course') }}
        	<small>{{ trans('courses/create.the_world_is_yours') }}</small>
		</h1>      
            <!--<form method='post' class='ajax-form' id="create-form" data-callback='prepareCourseDetails'--> 
            <form method='post' class='ajax-form' id="create-form" data-callback='followRedirect' 
                  action='{{action('CoursesController@store')}}' data-parsley-validate>
        <div id='step1' class="animated-step">
            <h1>TOP</h1>
        	<div>
                    <h2>{{ trans('courses/create.enter_course_name') }}</h2>
                    <input type='hidden' name='_token' value='{{csrf_token()}}' />
                    <input type='text' name='name' id='name' required /><br />
                    <button type="button" onclick='unhide("#step2")' class='btn btn-primary unhide-btn'>{{ trans('courses/create.next_step') }}</button>
                <!--</form>-->
            </div>
        </div>
<!--    <form method='post' class='ajax-form' id='edit-course-details-form' data-callback='followRedirect' data-parsley-validate >-->
        <div id='step2' class='# hidden animated-step'>
            <h1>TOP</h1>
	        <h2>{{ trans('courses/create.what_category_is_in') }}</h2>
            <div class="ui-select">
            {{ Form::select('course_category_id', $categories, null,  
                        ['onChange'=>'populateDropdown(this)', 'data-target'=>'#course_subcategory_id', 
                        'data-url'=> action('CoursesCategoriesController@subcategories'), 'required']) }}
            </div>
            <h2>{{ trans('courses/create.what_sub_category') }}</h2>
            	<div class="ui-select">
                    <select class="ui-select" name='course_subcategory_id' id='course_subcategory_id' required>
                        <option value=''>{{ trans('courses/create.select_category') }}</option>
                    </select><br />
                </div>
                <button class='btn btn-primary  unhide-btn' type="button" onclick='unhide("#step3")'>{{ trans('courses/create.next_step') }}</button>
        </div>
        
            <!--<input type='hidden' name='_token' value='{{csrf_token()}}' />-->
            <!--<input type='hidden' name='_method' value='PUT' />-->
                   
            <div id='step3' class='# hidden animated-step'>
                <h1>TOP</h1>
                <h1>{{ trans('courses/create.set_objectives') }}
                   <small>{{ trans('courses/create.this_helps_creating') }}</small>
                </h1> 
                 <h2>{{ trans('courses/create.course_level') }}</h2>
                 <div class="course-level btn-group clearfix" data-toggle="buttons">
                     @foreach($difficulties as $key=>$difficulty)
                     	<label class="btn btn-primary">
                         	<input type='radio' name='course_difficulty_id' id="option{{$key}}" autocomplete="off" value='{{$key}}' required /> {{$difficulty}}
                        </label>
                     @endforeach
        		 </div>
                 <div class="what-you-will-achieve">
                     <h2>{{ trans('courses/create.by_the_end') }}</h2>
                     <p class="tip">{{ trans('courses/create.make_it_results') }}</p>
                     <div>
                         <input type='text' name='what_will_you_achieve[]' class="clonable" required />
                         <span>1</span>
                     </div>
                     <a href="#" class="help-tip">{{ trans('general.help') }}</a>
        		 </div>
                 <div class="who-its-for">
                     <h2>{{ trans('courses/create.for_your_student_if') }}</h2>
                     <div>
                         <input type='text' name='who_is_this_for[]'  class="clonable" required /><br />
                         <span>1</span>
                     </div>
                     <a href="#" class="help-tip">{{ trans('general.help') }}</a>
                     <button type="submit" class='btn btn-primary clear start-creating'>{{ trans('courses/create.start_creating_curriculum') }}</button>
                 </div>
            </div>
        </form>
		<div class="steps-meter">
        	<p class="active" data-target='#step1'><span class="step-one"></span><em>{{ trans('general.step') }} 1</em></p>
        	<p data-target='#step2'><span class="step-two"></span><em>{{ trans('general.step') }} 2</em></p>
        	<p data-target='#step3'><span class="step-three"></span><em>{{ trans('general.step') }} 3</em></p>
        </div>
    </div>
</div>
</div>

@stop