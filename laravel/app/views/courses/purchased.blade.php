    @extends('layouts.default')
    @section('page_title')
        {{ $course->name }} -
    @stop
    @section('content')	
        <div class="wrapper enroll">
        	<div class="enroll-header">
            	<h1>
                	{{ trans('courses/student_dash.congratulations') }}!
                    <small>{{ trans('courses/student_dash.you-bought-the-course') }}</small>
                </h1>
            </div>
        	<div class="course-enroll-wrapper cat-box-7">
            	<p>{{ trans('courses/student_dash.you-have-enrolled-in') }}</p>
                <h2>{{ $course->name }}</h2>
                <!--
                <a href="#" class="others-you-liked">Others you’ve also liked</a>
                <div class="object small-box small-box-one">
                    <!--<div class="level">Beginner</div>-->
                    <!--            <div class="new-tag">NEW</div>
                    
                    <div class="img-container">
                    <img src="https://wazaardev.s3.amazonaws.com/course_preview/54905e838a388.jpg" class="img-responsive" alt="">
                         <div class="sale-ends">SALE ENDS IN 2 DAYS 15:22:21</div>
                    </div>
                    <h2>Health App Development</h2>
                    <p>Create your very first application in 2 weeks! You get a beginner award after completing the course.
                        <br>
                        <small>Subcategory: 
                            <a href="http://wazaar.dev/courses/category/health/health-subcat">Health subcat</a>
                        </small>
                    </p>
                    <div class="price-tag clear">
                         ¥ 300,000
                                </div>
            
                    <div class="next_">
                        <!--<div class="learn-more">
                            <a href="http://wazaar.dev/courses/health-app-development">Learn more</a>
                        </div>-->
                   <!--     <div class="students-attending">
                            0 Students
                        </div>   
                        <span class="likes">89%</span>         
                    </div> 
                </div>
                <span class="cancelled-price">¥500.000</span>
                <span class="price">¥150.000</span>
                <em class="w-tax">w.tax</em>
                <span class="save">YOU SAVE <em>20%</em></span>
                <form>
                	<button class="add-to-order">ADD TO ORDER</button>
                </form>
                <span class="or">Or</span>
                -->
                <a href="{{ action('ClassroomController@dashboard', $course->slug) }}" class="begin-my-learning">
                {{ trans('courses/student_dash.begin-my-learning') }}</a>
                <span class="bottom-course-title">{{ $course->name }}</span>
            </div>
        </div>
    @stop