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
                                <li><a href="#cat-row-{{$category->color_scheme}}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div><!--nav-collapse ends--> 
                </div><!--navbar-default ends-->
            </div><!--container ends-->
        </section>
        <section class="container">
            
@foreach($categories as $category)
<?php 
$category->load('homepageCourses.courseDifficulty', 'homepageCourses.previewImage', 'homepageCourses.courseSubcategory', 
 'homepageCourses.courseCategory', 'homepageCourses');
$row_class = cycle(Config::get('custom.html_row_classes'));?>
        <!-- {{ $row_class }} row begins -->   
        @if( $category->featuredCourse->first() != null )   
            <div class="row cat-row-{{$category->color_scheme}}" id="cat-row-{{$category->color_scheme}}">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="category-heading">         
                        <div class="clearfix">
                            <p class="lead">{{ $category->name }}<small>{{ $category->description }}</small></p>
                            <a href="{{ action('CoursesController@category', $category->slug) }}">{{trans('site/homepage.view-all')}}</a>
                        </div>
                    </div>
                 {{ View::make('courses.course_box_featured')->with( compact('category') )->withCourse($category->featuredCourse->first()) }}
                 </div>
            </div>       
        
            <div class="row cat-row-{{$category->color_scheme}}">
                
                @foreach($category->homepageCourses->take(3) as $course)
                    {{ View::make('courses.course_box')->with(compact('course')) }}
                @endforeach
            </div>
        @else
            <div class="row cat-row-{{$category->color_scheme}}" id="cat-row-{{$category->color_scheme}}">
                <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="category-heading">         
                    <div class="clearfix">
                        <p class="lead">{{ $category->name }}<small>{{ $category->description }}</small></p>
                        <a href="{{ action('CoursesController@category', $category->slug) }}">{{trans('site/homepage.view-all')}}</a>
                    </div>
                </div>
                </div>
                <?php $i = 0;?>
                @foreach($category->homepageCourses->take(3) as $course)
                    {{ View::make('courses.course_box')->with(compact('course')) }}
                    <?php unset($category->homepageCourses[$i]); ++$i;?>
                @endforeach
            </div>
        
            <div class="row cat-row-{{$category->color_scheme}}">
                @foreach($category->homepageCourses->take(3) as $course)
                    {{ View::make('courses.course_box')->with(compact('course')) }}
                @endforeach
            </div>
        @endif
            
			<!-- End of {{ $row_class }} row -->
@endforeach
</section>