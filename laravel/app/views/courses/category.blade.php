    @extends('layouts.default')
    @section('content')	
		<section class="container-fluid category-heading-container">
            <div class="container cat-row-{{$category->color_scheme}}">
            	<div class="row category-heading">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <p class="category-heading-title"> {{ $category->name }} 
                            @if(isset($subcategory))
                                {{" > $subcategory->name"}}
                            @endif
                            
                            <!--<small>{{ $category->description }}</small>-->
                        </p>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                    	<div class="difficulty-levels">
                        	<div class="level-buttons-container">
                            	<a href="#" class="beginner level-buttons">Beginner</a>
                                <a href="#" class="advanced level-buttons">Advanced</a>
                                <a href="#" class="intermediate level-buttons">Intermediate</a>
                            </div>
                            <div class="toggle-menus">
                            	<a href="#" class="menu menu-1"></a>
                                <a href="#" class="menu menu-2"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
        </section>
        <section class="container-fluid category-box-container">
            
			
        @if( $featured = Course::featured()->where('course_category_id', $category->id)->first() )   
            <div class="container cat-row-{{$category->color_scheme}}">
            	<div class="row">      
                    <div class="col-xs-12 col-sm-12 col-md-12">
                         {{ View::make('courses.course_box_featured')->with( compact('category') )->withCourse($featured) }}
                    </div>
                </div>
            </div>
        @endif
         
        
       	<div class="container">
        @foreach($courses as $course)
            {{ cycle(["<div class='row cat-row-$category->color_scheme'>",'','']) }}
              {{ View::make('courses.course_box')->with(compact('course')) }} 
            {{ cycle(['','','</div>']) }}
        @endforeach
        </div>
        @if($courses->count() % 3!=0)
            </div>
        @endif
        {{ $courses->links() }}
        
        </section>

    @stop