    @extends('layouts.default')
    @section('content')	

        <section class="container">
            
			<!-- First row begins -->         
            <div class="row first-row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="category-heading">         
                        <div class="clearfix">
                            <p class="lead"> {{ $category->name }} <small>{{ $category->description }}</small></p>
                                                    </div>
                    </div>
                </div>
            </div>       
         
        @foreach($courses as $course)
        <div class="row second-row">
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-one">
                  <div class="price-tag">
                    300,000 ¥
                  </div><div class="level">Beginner</div><div class="new-tag">NEW</div>
                  <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image2.jpg" class="img-responsive" alt="">
                  <h2>{{ $course->name }}</h2>
                  <p>{{ $course->description }}</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="{{action("CoursesController@show", $course->slug)}}">Learn more</a>
                    </div>
                    <div class="students-attending">
                      {{ $course->student_count }} Students
                    </div>            
                  </div> 
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-two">
                  <div class="price-tag">
                    300,000 ¥
                  </div><div class="level">Beginner</div><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image3.jpg" class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">Learn more</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div> 
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-three">
                  <div class="price-tag">
                    300,000 ¥
                  </div><div class="level">Beginner</div><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image4.jpg" class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">Learn more</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div>
                </div>
              </div>
            </div>
        @endforeach
        
        {{ $courses->links() }}
        
        </section>

    @stop