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
                    <a href="{{ action('CoursesController@category', $category->slug) }}" class="learn-more">Learn more</a>
                    <i class="fa fa-arrow-down fa-1"></i>
                    <a href="{{ action('UsersController@create') }}" class="sign-up">Sign up and earn ¥500 credit</a>
                </div>
                    <div class="col-md-6 hidden-xs">
                    <img class="hidden-xs img-responsive right"
                    src="{{ $category->graphics_url }}" alt="">
                </div>
            @else
                <div class="col-md-6 hidden-xs">
                    <img class="hidden-xs img-responsive left"
                    src="{{ $category->graphics_url }}" alt="">
                </div>
                <div class="col-md-6">
                    <h3>{{ $category->name }}</h3>
                    <p class="description">
                        {{ $category->description }}
                    </p>
                    <a href="{{ action('CoursesController@category', $category->slug) }}" class="learn-more">Learn more</a>
                    <i class="fa fa-arrow-down fa-1"></i>
                    <a href="{{ action('UsersController@create') }}" class="sign-up">Sign up and earn ¥500 credit</a>
                </div>
            @endif
            </div>
        <div class="row">
            <!-- include the 3 course boxes -->
            @foreach($category->unauthenticatedHomepageCourses as $course)
                {{ View::make('courses.course_box')->with(compact('course')) }}
            @endforeach
            <!-- end of the 3 course boxes -->
        </div>
    </div>
</section>
@endforeach