    @extends('layouts.default')
    @section('content')	

        <section class="container">
			<!-- First row begins -->         
            <div class="row first-row">
            	<div class="col-xs-12 col-sm-12 col-md-12">
               
                <div class="object big-box">
                	<div class="price-tag">
                     ¥ {{ number_format($course->price, Config::get('custom.currency_decimals')) }} {{trans('courses/general.sale')}}
                	</div>
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image1.jpg" alt="" 
                    class="hidden-sm hidden-xs img-responsive">
                    <div>
                        <div class="level"> {{ $course->courseDifficulty->name }} </div>
                        <h2>{{$course->name}}</h2>
                        <p>{{$course->description }}</p>
                        <div class="next_">
                        <div class="learn-more">
                            {{ Form::open(['action' => ["CoursesController@purchase", $course->slug]]) }}
                            <input type='submit' class='btn btn-primary' value='{{ trans("courses/general.purchase") }}' />
                            {{Form::close()}}
                        </div>
                        <div class="students-attending">
                          {{ $course->student_count }} Students
                        </div>            
                      </div>
                  </div>
                </div>
              </div>
            </div>       
         
			<!-- End of First row -->
        </section>

    @stop