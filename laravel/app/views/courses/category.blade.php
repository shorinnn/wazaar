    @extends('layouts.default')
    @section('content')	

        <section class="container">
            
			
            <div class="row first-row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="category-heading">         
                        <div class="clearfix">
                            <p class="lead"> {{ $category->name }} 
                                @if(isset($subcategory))
                                    {{" > $subcategory->name"}}
                                @endif
                                
                                <small>{{ $category->description }}</small></p>
                                                    </div>
                    </div>
                </div>
            </div>      
        @if( $featured = Course::featured()->where('course_category_id', $category->id)->first() )   
            <div class="row second-row">       
                <div class="col-xs-12 col-sm-12 col-md-12">
                     {{ View::make('courses.course_box_featured')->with( compact('category') )->withCourse($featured) }}
                </div>
            </div>
        @endif
         
        
        @foreach($courses as $course)
            {{ cycle(['<div class="row second-row">','','']) }}
              {{ View::make('courses.course_box')->with(compact('course')) }} 
            {{ cycle(['','','</div>']) }}
        @endforeach
        @if($courses->count() % 3!=0)
            </div>
        @endif
        {{ $courses->links() }}
        
        </section>

    @stop