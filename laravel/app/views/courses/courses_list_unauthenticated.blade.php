@foreach($categories as $category)
<?php
$category->load('unauthenticatedHomepageCourses.courseDifficulty', 'unauthenticatedHomepageCourses.previewImage', 'unauthenticatedHomepageCourses.courseSubcategory', 
 'unauthenticatedHomepageCourses.courseCategory', 'unauthenticatedHomepageCourses');
?>
<section class="container-fluid unauthenticated-homepage cat-box-{{$category->color_scheme}}" id="cat-row-{{$category->color_scheme}}">
        <div class="container course-listing-container">
            <div class="row">
            @if(cycle(1,2)==1)
                <div class="col-md-6">
                    <h3>{{ $category->name }}</h3>
                    <p class="description">
                        {{ $category->description }}
                    </p>
                    <a href="{{ action('CoursesController@category', $category->slug) }}" class="learn-more">{{ trans('site/homepage.browse-category') }}</a>
                    <i class="fa fa-arrow-down fa-1"></i>
                    <!--<a href="{{ action('UsersController@create') }}" class="sign-up">{{ trans('site/homepage.sign-up-and-earn') }}</a>-->
                </div>
                    <div class="col-md-6 hidden-xs">
                    <img class="hidden-xs img-responsive right"
                    src="{{ cloudfrontUrl( $category->graphics_url ) }}" alt="">
                </div>
            @else
                <div class="col-md-6 hidden-xs">
                    <img class="hidden-xs img-responsive left"
                    src="{{ cloudfrontUrl( $category->graphics_url ) }}" alt="">
                </div>
                <div class="col-md-6">
                    <h3>{{ $category->name }}</h3>
                    <p class="description">
                        {{ $category->description }}
                    </p>
                    <a href="{{ action('CoursesController@category', $category->slug) }}" class="learn-more">{{ trans('site/homepage.learn-more') }}</a>
                    <i class="fa fa-arrow-down fa-1"></i>
                    <!--<a href="{{ action('UsersController@create') }}" class="sign-up">{{ trans('site/homepage.sign-up-and-earn') }}</a>-->
                </div>
            @endif
            </div>
        <div class="row">
            <section class="scrollable-course-listings-wrapper container-fluid">
        	<div class="scrollable-course-listings-container container">
                <div class="scrollable-course-listings row">
            <!-- include the 11 course boxes -->
            @foreach($category->unauthenticatedHomepageCourses as $course)
                {{-- View::make('courses.course_box')->with(compact('course')) --}}
            @endforeach
            
                   <div class="col-xs-12 col-sm-6 col-md-4"  aria-hidden="false" style="width: 344px;"> 
                   	   <div class="sample-course-listing browse-more-block">
                           <a href="{{ action('CoursesController@category', $category->slug)}}" class="browse-more"> 
                              Browse More &gt;&gt;
                           </a> 
                       </div>
                   	   <div class="col-xs-12 col-sm-6 col-md-4"> </div> 
                   </div>
            <!-- end of the 11 course boxes -->
                </div>
                </div>
            </section>
        </div>
    </div>

 
</section>
@endforeach