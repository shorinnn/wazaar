    @extends('layouts.default')
    @section('content')	
		<section class="container-fluid category-heading-container">
            <div class="container cat-row-{{$category->color_scheme}}">
            	<div class="row category-heading">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        @if($category->name!='')
                            <p class="category-heading-title"> {{ $category->name }}
                                @if(isset($subcategory))
                                    {{$subcategory->name}}
                                @endif
                            </p>
                        @endif
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="pull-left margin-top-20">
                            {{Form::select('sort',CourseHelper::getCourseSortOptions(),Input::get('sort'),['class' => 'form-control'])}}

                        </div>



                    	<div class="difficulty-levels">
                        	<div class="level-buttons-container">
                            	<a href="{{Request::url() . '?difficulty=1&sort=' . Input::get('sort')}}" class="beginner level-buttons @if($difficultyLevel == 1) active @endif">Beginner</a>
                                <a href="{{Request::url() . '?difficulty=2&sort=' . Input::get('sort')}}" class="advanced level-buttons @if($difficultyLevel == 2) active @endif">Advanced</a>
                                <a href="{{Request::url() . '?difficulty=3&sort=' . Input::get('sort')}}" class="intermediate level-buttons @if($difficultyLevel == 3) active @endif">Intermediate</a>
                            </div>
                            <div class="toggle-menus">
                            	<a href="#" class="menu menu-1"><i class="fa fa-th"></i></a>
                                <a href="#" class="menu menu-2"><i class="fa fa-th-list"></i></a>
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
        {{ $courses->appends(Input::only('sort','difficulty'))->links() }}
        
        </section>

    @stop

    @section('extra_js')
        <script type="text/javascript">
            $(function(){
                $('select[name=sort]').on('change', function(){
                    var sort = $("select[name=sort] option:selected").val();
                    var loc = location.href;
                    loc += loc.indexOf("?") === -1 ? "?" : "&";
                    var existingParams = document.URL.split('?');

                    if (existingParams.length > 1){
                        var params = existingParams[1].split('&');
                        var validParams = new Array();
                        for(var i = 0; i< params.length; i++){
                            if (params[i].indexOf('sort') < 0){
                                validParams.push(params[i]);
                            }
                        }
                        location.href = existingParams[0] + '?' + validParams.join('&') + '&' + "sort=" + sort;
                    }
                    else {
                        location.href = loc + "sort=" + sort;
                    }
                });
            });
        </script>
    @stop