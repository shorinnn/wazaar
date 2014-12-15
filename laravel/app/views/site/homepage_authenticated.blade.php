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
        <section class="container-fluid main-nav-section">
        	<div class="container">
                <div class="navbar navbar-default">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> 
                        	<span class="icon-bar"></span> 
                            <span class="icon-bar"></span> 
                            <span class="icon-bar"></span> 
                        </button>
                    </div><!--navbar-header ends-->
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            @foreach($categories as $category)
                                <li><a href="{{action('CoursesController@category', $category->slug)}}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div><!--nav-collapse ends--> 
                </div><!--navbar-default ends-->
            </div><!--container ends-->
        </section>
        <section class="container">
            
@foreach($categories as $category)
<?php $row_class = cycle(Config::get('custom.html_row_classes'));?>
        <!-- {{ $row_class }} row begins -->         
            <div class="row {{ $row_class }}-row">
            	<div class="col-xs-12 col-sm-12 col-md-12">
                <div class="category-heading">         
                    <div class="clearfix">
                        <p class="lead">{{ $category->name }}<small>{{ $category->description }}</small></p>
                        <a href="{{ action('CoursesController@category', $category->slug) }}">{{trans('site/homepage.view-all')}}</a>
                    </div>
                </div>
                <div class="object big-box">
                	<div class="price-tag">
                    300,000 &yen; SALE
                	</div>
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image1.jpg" alt="" 
                    class="hidden-sm hidden-xs img-responsive">
                    <div><div class="level">{{trans('site/homepage.beginner')}}</div><h2>FAKE FEATURED: App development</h2>
                        <p>Create your very first application in 2 weeks! You get a beginner award after completing the course.</p>
                        <div class="next_">
                        <div class="learn-more">
                          <a href="#">{{trans('site/homepage.learn-more')}}</a>
                        </div>
                        <div class="students-attending">
                          1233 Students
                        </div>            
                      </div>
                  </div>
                </div>
              </div>
            </div>       
            <div class="row {{ $row_class }}-row">
                @foreach($category->courses->take(3) as $course)
                    {{ View::make('courses.course_box')->with(compact('course')) }}
                @endforeach
            </div>
			<!-- End of {{ $row_class }} row -->
@endforeach
			
			
        </section>
        @if(Auth::guest() || !Auth::user()->hasRole('Instructor'))
            <section class="container-fluid become-an-instructor">
                    <div class="container">
                  <div class="row">
                    <div class="col-xs-12">
                      <h1>BECOME</h1>
                      <h2>AN INSTRUCTOR</h2>
                      <a href="{{ action('InstructorsController@become') }}"><span>{{trans('site/homepage.get-started')}}</span></a>
                    </div>
                  </div>
              </div>
            </section>
        @endif
    @stop