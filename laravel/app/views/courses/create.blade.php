@extends('layouts.default')
@section('content')	

<section class="container-fluid edit-course create-course-start-page-container">
    <form method='post' class='ajax-form' id="create-form" data-callback='followRedirect' 
                  action='{{action('CoursesController@store')}}' data-parsley-validate>	
    <div class="container">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
            	<div class="row">
                	<div class="col-lg-12">
                    	<img />
                        <h2 class="text-center">{{ trans('courses/create.create-new-course') }}</h2>
                    </div>
                </div>
                <div class="row first-row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <span class="step-number">1</span>
                        <h3>{{ trans('courses/create.give-title') }}</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <input type='hidden' name='_token' value='{{csrf_token()}}' />
                        <input type='text' name='name' id='name' placeholder="Title..." required /><br />
                    </div>
                </div>
                <div class="row second-row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <span class="step-number">2</span>
                        <h3>{{ trans('courses/create.what-is-it-about') }}</h3>                    
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    {{ Form::select('course_category_id', $categories, null,  
                                ['onChange'=>'populateDropdown(this)', 'data-target'=>'#course_subcategory_id', 
                                'data-url'=> action('CoursesCategoriesController@subcategories_instructor'), 'required']) }}
                                
                    <select name='course_subcategory_id' id='course_subcategory_id' required>
                        <option value=''>{{ trans('courses/create.choose-subcategory') }}</option>
                    </select><br />

                    	<!--<select>
                        	<option>{{ trans('courses/create.choose-category') }}</option>
                        </select>
                    	<select>
                        	<option>{{ trans('courses/create.choose-subcategory') }}</option>
                        </select>-->
                    </div>
                </div>
                <div class="row">
                	<div class="col-lg-12 text-center">
                    	<button type='submit' class="blue-button extra-large-button margin-top-30">CREATE COURSE</button>
                    </div>
                </div>
        	</div>
        </div>
     </div>
     </form>
</section>
@stop