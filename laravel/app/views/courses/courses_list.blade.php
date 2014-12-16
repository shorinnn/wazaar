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
        @if( $featured = Course::featured()->where('course_category_id', $category->id)->first() )   
            <div class="row {{ $row_class }}-row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="category-heading">         
                        <div class="clearfix">
                            <p class="lead">{{ $category->name }}<small>{{ $category->description }}</small></p>
                            <a href="{{ action('CoursesController@category', $category->slug) }}">{{trans('site/homepage.view-all')}}</a>
                        </div>
                    </div>
                 {{ View::make('courses.course_box_featured')->with( compact('category') )->withCourse($featured) }}
                 </div>
            </div>       
        
            <div class="row {{ $row_class }}-row">
                @foreach($category->courses()->where('featured',0)->take(3)->get() as $course)
                    {{ View::make('courses.course_box')->with(compact('course')) }}
                @endforeach
            </div>
        @else
            <div class="row {{ $row_class }}-row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="category-heading">         
                    <div class="clearfix">
                        <p class="lead">{{ $category->name }}<small>{{ $category->description }}</small></p>
                        <a href="{{ action('CoursesController@category', $category->slug) }}">{{trans('site/homepage.view-all')}}</a>
                    </div>
                </div>
                </div>
                @foreach($category->courses()->orderBy('id','Desc')->take(3)->get() as $course)
                    {{ View::make('courses.course_box')->with(compact('course')) }}
                @endforeach
            </div>
        
            <div class="row {{ $row_class }}-row">
                @foreach($category->courses()->orderBy('id','Desc')->skip(3)->take(3)->get() as $course)
                    {{ View::make('courses.course_box')->with(compact('course')) }}
                @endforeach
            </div>
        @endif
            
			<!-- End of {{ $row_class }} row -->
@endforeach
</section>