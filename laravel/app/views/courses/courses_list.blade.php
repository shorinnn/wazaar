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