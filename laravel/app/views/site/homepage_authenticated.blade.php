    @extends('layouts.default')
    @section('content')	
        <section class="container-fluid course-search-section">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-12">
                    	<p class="lead">{{trans('site/homepage.what-do-you-want-to-learn')}}</p>
                        <div class="course-search-form">
                        	<form>
                            	<input type="search" placeholder="E.g. Javascript, online business, etc ..." name="course-search">
                                <button></button>
                            </form>
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/sample-search-category.png" 
                            alt="" class="img-responsive">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="container-fluid progress-bar-container">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-12 progress-bar-contents">
                    	<p class="lead">{{trans('site/homepage.your-progress')}}</p>
                        <div class="clearfix">
                        	<div class="course-title">
                            	<em>A1</em>
                                <a href="#">Javascript Crash Course I</a>
                            </div>
                            <div class="deadline-date">
                            	<em>{{trans('site/homepage.deadline-date')}}</em>
                                <p>23h 43m 52s</p>
                                <a href="#">{{trans('site/homepage.continue-course')}}</a>
                            </div>
                        </div>
                        <div class="progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                            <span class="sr-only">50% Complete</span>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="alert-message container">
        	<div class="row">
            	<div class="col-md-12">
                	<p>{{trans('site/homepage.finish-course-alert')}}</p>
                </div>
            </div>
        </section>
    
        {{ View::make('courses.courses_list')->with(compact('categories')) }}
    
        @if(Auth::guest() || !Auth::user()->hasRole('Instructor'))
            <section class="container-fluid become-an-instructor">
            	<div class="container">
                  <div class="row">
                    <div class="col-xs-12">
                      <h1>{{ trans('site/homepage.become') }}</h1>
                      <h2>{{ trans('site/homepage.an-instructor') }}</h2>
                      <a href="{{ action('InstructorsController@become') }}"><span>{{trans('site/homepage.get-started')}}</span></a>
                    </div>
                  </div>
              </div>
            </section>
        @endif
    @stop