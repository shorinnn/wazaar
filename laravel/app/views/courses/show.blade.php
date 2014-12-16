    @extends('layouts.default')
    @section('content')	
        <section class="container">
            @if (Session::get('success'))
                <div class="alert alert-success">{{{ Session::get('success') }}}</div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
            @endif
			<!-- First row begins -->         
            <div class="row first-row">
            	<div class="col-xs-12 col-sm-12 col-md-12">
               
                <div class="object big-box">
                	<div class="price-tag">
                     ¥ {{ number_format($course->price, Config::get('custom.currency_decimals')) }} {{trans('courses/general.sale')}}
                	</div>
                    <img 
                         @if($course->previewImage==null)
                            src="http://placehold.it/350x150&text=Preview Unavailable"
                        @else
                            src="{{$course->previewImage->url}}"
                        @endif
                        alt="" class="hidden-sm hidden-xs img-responsive">
                    <div>
                        <div class="level"> {{ $course->courseDifficulty->name }} </div>
                        <h2>{{$course->name}}</h2>
                        <p>{{$course->description }}</p>
                        <div class="next_">
                        <div class="learn-more">
                            @if(Auth::guest() || Auth::user()->can_purchase($course) )
                                {{ Form::open(['action' => ["CoursesController@purchase", $course->slug], 'id' => 'purchase-form']) }}
                                <input type='submit' class='btn btn-primary' value='{{ trans("courses/general.purchase") }}' />
                                {{Form::close()}}
                            @endif
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