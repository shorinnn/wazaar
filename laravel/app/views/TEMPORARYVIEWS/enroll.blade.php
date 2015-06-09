    @extends('layouts.default')
    @section('content')	
        <div class="wrapper enroll">
        	<div class="enroll-header">
            	<h1>
                	Congratulations!
                    <small>You bought the course</small>
                </h1>
            </div>
        	<div class="course-enroll-wrapper cat-box-7">
            	<p>You have enrolled in</p>
                <h2>Javascript Advanced Animations II</h2>
				<a href="#" class="others-you-liked">Others you’ve also liked</a>
                <div class="object small-box small-box-one">
                    <!--<div class="level">Beginner</div>-->
                    <!--            <div class="new-tag">NEW</div>
                    -->
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
                        <div class="students-attending">
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
                <a href="#" class="begin-my-learning">BEGIN MY LEARNING</a>
                <span class="bottom-course-title">Javascript Advanced Animations II</span>
            </div>
            <!--<section class="container-fluid become-an-instructor affiliate">
                <div class="container">
                  <div class="row">
                    <div class="col-xs-12">
                      <h1>BECOME</h1>
                      <h2>AN INSTRUCTOR</h2>
                      <a href="{{ action('InstructorsController@become') }}"><span>{{trans('site/homepage.get-started')}}</span></a>
                    </div>
                  </div>
              </div>
            </section>-->
        </div>
    @stop