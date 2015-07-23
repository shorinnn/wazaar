@extends('layouts.default')
@section('content')	

<section class="container-fluid edit-course create-course-start-page-container">
    <form method='post' class='ajax-form' id="create-form" data-callback='followRedirect' 
          data-redirect-target-elem='.create-course-btn' data-redirect-label='{{ trans('general.please-wait') }}'
          action='{{action('CoursesController@store')}}' data-parsley-validate>	
    <div class="container">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
            	<div class="row">
                	<div class="col-lg-12 text-center">
                    	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/create-new-icon.png" />
                        <h2 class="text-center">{{ trans('courses/create.create-new-course') }}
                        	<div class="lead">Fill out a form</div>
                        </h2>
                    </div>
                </div>
                <div class="row first-row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h3>{{ trans('courses/create.give-title') }}</h3>
                        <input type='hidden' name='_token' value='{{csrf_token()}}' />
                        <input type='text' name='name' id='name' placeholder="Title..." required />
                    </div>
                </div>
                <div class="row second-row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h3>{{ trans('courses/create.what-is-it-about') }}</h3>                                        
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        {{ Form::select('course_category_id', $categories, null,  
                                    ['onChange'=>'populateDropdown(this)', 'data-target'=>'#course_subcategory_id', 
                                    'data-url'=> action('CoursesCategoriesController@subcategories_instructor'), 'required']) }}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                           
                        <select name='course_subcategory_id' id='course_subcategory_id' required>
                            <option value=''>{{ trans('courses/general.subcategory') }}</option>
                        </select>

                    	<!--<select>
                        	<option>{{ trans('courses/create.choose-category') }}</option>
                        </select>
                    	<select>
                        	<option>{{ trans('courses/create.choose-subcategory') }}</option>
                        </select>-->
                    </div>
                </div>
                <div class="row second-row padding-bottom-40">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h3>{{ trans('courses/create.paid-or-free') }}</h3>
                        <select name='free' required>
                            <option></option>
                            <option value='no'>{{ trans('courses/create.paid') }}</option>
                            <option value='yes'>{{ trans('courses/create.free') }}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    	<button type='submit' class="create-course-btn blue-button large-button margin-top-30">
                        {{ trans('courses/create.create_a_course') }}
                        </button>                    
                    </div>
                </div>
        	</div>
        </div>
     </div>
     </form>
</section>
@stop