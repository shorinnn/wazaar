@extends('layouts.default')
@section('content')	
<div class="edit-course">
	<section class="container-fluid header">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<h1>{{ trans('courses/general.edit') }}: Course name</h1>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<a href="#" class="blue-button large-button disabled-button right">{{ trans('courses/general.submit_for_approval') }}</a>
                <a href="#" class="default-button large-button right">
                	{{ trans('courses/general.preview_course') }}
            	</a>

            </div>
        </div>
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<a href="#" class="header-tabs regular-paragraph active">{{ trans('courses/general.course_description') }}</a>
            	<a href="#" class="header-tabs regular-paragraph">{{ trans('courses/general.curriculum') }}</a>
            	<a href="#" class="header-tabs regular-paragraph">{{ trans('courses/general.settings') }}</a>
                
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<div class="right steps-remaining">
                	<p class="regular-paragraph no-margin">
                    	{{ trans('courses/general.complete') }} <span>2 {{ trans('courses/general.steps') }}</span> {{ trans('courses/general.to_submit_course') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <form method='post' class='ajax-form' id="create-form" data-callback='followRedirect' 
                      action='{{action('CoursesController@store')}}' data-parsley-validate>
    <section class="container main">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 left-content">
            	<div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <p class="intro-paragraph">{{ trans('courses/general.details_for_public_course_page') }}</p>
                        <h4>
                        {{ trans('courses/general.short_description') }}
                        <span class="lead">{{ trans('courses/general.used_on_listings_description') }}</span>
                        </h4>
                        <textarea>
                        
                        </textarea>
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h4>
                        {{ trans('courses/general.full_description') }}
                        <span class="lead">{{ trans('courses/general.used_on_description_page') }}</span>
                        </h4>
                        <textarea>
                        
                        </textarea>                    
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 who-its-for">
                        <h4>{{ trans('courses/create.course-requirements') }}
                        	<span class="lead">{{ trans('courses/create.what-users-should-know') }}</span>
                        </h4>
                        <div class="relative">
                        	<input type='text' name='requirements[]' data-clonable-max='5' class="clonable" required />  
                            <span>1</span>                      	
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 who-its-for">
                        <h4>{{ trans('courses/general.who_is_this_for') }}
                        	<span class="lead">{{ trans('courses/general.who-benefits-most') }}</span>
                        </h4>
                        <div class="relative">
                        	<input type='text' name='who_is_this_for[]'  class="clonable" required />
                            <span>1</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 what-you-will-achieve">
                        <h4>
                        	{{ trans('courses/general.by_the_end') }}
                            <span class="lead">{{ trans('courses/general.skills_to_be_learnt') }}</span>
                        </h4>
                        <div class="relative">
                        	<input type='text' name='what_will_you_achieve[]' class="clonable" required />
                            <span>1</span>
                        </div>
                        <!--<a href="#" class="transparent-button add-input">add</a>-->
                    </div>
                </div>
            </div>
        	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 right-content">
            	<div class="row category-row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<div class="row">
                        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            	<p class="regular-paragraph">Category</p>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            	<p class="regular-paragraph semibold-text">IT & WEB</p>
                            </div>
                        </div>
                    	<div class="row">
                        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            	<p class="regular-paragraph">Sub-category</p>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            	<p class="regular-paragraph semibold-text">Websites</p>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="edit-button">Edit</a>
                </div>
                <div class="row margin-top-40 listing-image">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>
                        Listing image (thumbnail)
                        	<span class="lead">Image used for listings thumbnail</span>
                        </h4>
                        <div class="file-details">
                        	<p class="regular-paragraph">Recommended size 1080x680</p>
							<p class="regular-paragraph">Available formats png or jpg.</p>
                            <button class="default-button large-button">Upload Image</button>
                        </div>
                    </div>
                </div>
                <div class="row margin-top-40 listing-video">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>
                        	Introduction video
                        	<span class="lead">Video on public course page</span>
                        </h4>
                        <div class="file-details">
                        	<p class="regular-paragraph">Video should be 16:9 or</p>
							<p class="regular-paragraph">else it will be cropped</p>
                            <button class="default-button large-button">Upload Video</button>
                        </div>
                    </div>
                </div>
                <div class="row next-step-button">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<button class="blue-button extra-large-button">NEXT STEP</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </form>
</div>
@stop