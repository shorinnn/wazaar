    @extends('layouts.default')
    @section('content')	
		<section class="container-fluid category-heading-container">
            <div class="container-fluid cat-row-{{$category->color_scheme}}">
            	<div class="row category-heading">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <p class="category-heading-title">
                    </p>
                        @if($category->name!='')
                            <p class="category-heading-title"> <a href="#">{{ $category->name }}</a> 
                                @if(isset($subcategory))
                                    <i class="wa-chevron-right"></i>
                                    {{$subcategory->name}}
                                @endif
                            </p>
                        @endif
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    	<div class="clearfix category-heading-buttons">
                            <div class="sort-options clearfix"><label>Sort by:</label>
                                {{ Form::select('sort', CourseHelper::getCourseSortOptions(), Input::get('sort'), ['class' => 'form-control'] ) }}
<!--                            <div class="date-dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Date
                                    <i class="wa-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <li><a href="#">Yesterday</a></li>
                                    <li><a href="#">1 weeek</a></li>
                                    <li><a href="#">1 month</a></li>
                                    <li><a href="#">1 year</a></li>
                                </ul>
                            </div>-->
                            </div>
    
    
                            <div class="difficulty-levels clearfix">
                                <div class="level-buttons-container">
                                    <a href="{{Request::url() . '?difficulty=0&sort=' . Input::get('sort').'&term='. Input::get('term') }}"  data-target=".ajax-content" 
                                       data-url="{{Request::url() . '?difficulty=0&sort=' . Input::get('sort'). '&term='. Input::get('term') }}"
                                        data-callback="ajaxifyPagination" class="load-remote beginner  level-buttons @if(!isset($difficultyLevel) || $difficultyLevel == 0 ) active @endif">
                                           {{ trans('courses/general.filter.all') }}
                                    </a>
                                    <a href="{{Request::url() . '?difficulty=1&sort=' . Input::get('sort').'&term='. Input::get('term') }}"  data-target=".ajax-content" 
                                       data-url="{{Request::url() . '?difficulty=1&sort=' . Input::get('sort'). '&term='. Input::get('term') }}"
                                       data-callback="ajaxifyPagination" class="load-remote advanced level-buttons @if($difficultyLevel == 1) active @endif">
                                         {{ trans('courses/general.filter.beginner') }}
                                    </a>
                                    
                                       
                                    <a href="{{Request::url() . '?difficulty=3&sort=' . Input::get('sort').'&term='. Input::get('term') }}"  data-target=".ajax-content" 
                                       data-url="{{Request::url() . '?difficulty=3&sort=' . Input::get('sort'). '&term='. Input::get('term') }}" 
                                       data-callback="ajaxifyPagination" class="load-remote intermediate level-buttons @if($difficultyLevel == 3) active @endif">
                                         {{ trans('courses/general.filter.advanced') }}
                                    </a>
                                </div>
                                <div class="toggle-menus">
                                    <a href="#" class="menu menu-1"><i class="fa fa-th"></i></a>
                                    <a href="#" class="menu menu-2"><i class="fa fa-th-list"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
        </section>
        <section class="container-fluid category-box-container">
            
        <div class='ajax-content'>
             {{ View::make('courses.categories.courses')->with( compact( 'courses', 'category', 'wishlisted' ) ) }}
        </div>
        </section>

    @stop

    @section('extra_js')
        <script type="text/javascript">
            $(function(){
                $('.level-buttons-container a').click(function(){
                    $('.level-buttons-container a').removeClass('active');
                });
                
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
//                        location.href = existingParams[0] + '?' + validParams.join('&') + '&' + "sort=" + sort;
                        url = existingParams[0] + '?' + validParams.join('&') + '&' + "sort=" + sort;
                    }
                    else {
//                        location.href = loc + "sort=" + sort;
                        url = loc + "sort=" + sort;
                    }
                    
                    $('.ajax-content').html( '<a href="#" data-callback="ajaxifyPagination" data-target=".ajax-content" data-url="'+url+'" class="load-remote course-desc-ajax-link">loading</a>' );
                    $('.course-desc-ajax-link').click();
                });
            });
            
            ajaxifyPagination( null );
            
        </script>
    @stop