    @extends('layouts.default')
    @section('content')	

        <section class="container">
			<!-- First row begins -->         
            <div class="row first-row">
            	<div class="col-xs-12 col-sm-12 col-md-12">
               
                <div class="object big-box">
                	<div class="price-tag">
                    300,000 &yen; SALE
                	</div>
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image1.jpg" alt="" 
                    class="hidden-sm hidden-xs img-responsive">
                    <div><div class="level">{{trans('site/homepage.beginner')}}</div><h2>Details Page For {{$slug}} course</h2>
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
         
			<!-- End of First row -->
        </section>

    @stop