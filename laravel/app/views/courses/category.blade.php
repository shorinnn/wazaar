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
              {{ View::make('courses.course_box')->with(compact('course')) }}
              {{ View::make('courses.course_box')->with(compact('course')) }}
              {{ View::make('courses.course_box')->with(compact('course')) }}
            </div>
        @endforeach
        
        {{ $courses->links() }}
        
        </section>

    @stop