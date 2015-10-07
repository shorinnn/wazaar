    @extends('layouts.default')
    @section('content')	
		<section class="container-fluid category-heading-container">
            <div class="container-fluid cat-row-{{$category->color_scheme}}">
            	<div class="row category-heading">
                    <form id="course-filter-form">
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                            @if($category->name!='')
                                <p class="category-heading-title"> <a href="#">{{ $category->name }}</a> 
                                    @if(isset($subcategory))
                                        <i class="wa-chevron-right"></i>
                                        {{$subcategory->name}}
                                    @endif
                                </p>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 filters">
                        	<div class="clearfix category-heading-buttons">
                                <div class="sort-options clearfix"><label>Sort by:</label>
                                    {{ Form::select('sort', CourseHelper::getCourseSortOptions(), Input::get('sort'), ['class' => 'form-control course-sort', 'onchange'=>"loadFilteredCourseCategory();"] ) }}
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
        
                                <div class="segmented-controls clearfix course-filters">
                                	<div class="segmented-buttons-wrapper segmented-controls inline-block clearfix">
                                        <div class="btn-group buttons-container" data-toggle="buttons">
                                          <label class="btn btn-default segmented-buttons @if(empty(Input::get('filter')) || Input::get('filter') == 'all' ) active @endif">
                                            <input type="radio" name="filter" value="all" class="filter" autocomplete="off" 
                                                   @if(empty(Input::get('filter')) || Input::get('filter') == 'all' ) checked='checked' @endif
                                                   onchange="loadFilteredCourseCategory();"> {{ trans('courses/general.filter.all') }}
                                          </label>
                                          <label class="btn btn-default segmented-buttons @if(!empty(Input::get('filter')) && Input::get('filter') == 'paid' ) active @endif">
                                            <input type="radio" name="filter" value="paid" class="filter" autocomplete="off" 
                                                   @if(!empty(Input::get('filter')) && Input::get('filter') == 'paid' ) checked='checked' @endif
                                                   onchange="loadFilteredCourseCategory();"> {{ trans('courses/general.filter.paid') }}
                                          </label>
                                          <label class="btn btn-default segmented-buttons @if(!empty(Input::get('filter')) && Input::get('filter') == 'free' ) active @endif">
                                            <input type="radio" name="filter" value="free" class="filter" autocomplete="off" 
                                                   @if(!empty(Input::get('filter')) && Input::get('filter') == 'free' ) checked='checked' @endif
                                                   onchange="loadFilteredCourseCategory();"> {{ trans('courses/general.filter.free') }}
                                          </label>
                                        </div>
                                    </div>
									<div class="segmented-buttons-wrapper segmented-controls inline-block clearfix">
                                        <div class="btn-group buttons-container" data-toggle="buttons">
                                          <label class="btn btn-default segmented-buttons @if(empty(Input::get('difficulty')) || Input::get('difficulty') == '0' ) active @endif">
                                            <input type="radio" name="difficulty" value="0" class="difficulty" autocomplete="off" checked="checked" onchange="loadFilteredCourseCategory();"> {{ trans('courses/general.filter.all') }}
                                          </label>
                                          <label class="btn btn-default segmented-buttons @if(!empty(Input::get('difficulty')) && Input::get('difficulty') == '1' ) active @endif">
                                            <input type="radio" name="difficulty" value="1" class="difficulty" autocomplete="off" onchange="loadFilteredCourseCategory();"> {{ trans('courses/general.filter.beginner') }}
                                          </label>
                                          <label class="btn btn-default segmented-buttons @if(!empty(Input::get('difficulty')) && Input::get('difficulty') == '2' ) active @endif">
                                            <input type="radio" name="difficulty" value="2" class="difficulty" autocomplete="off" onchange="loadFilteredCourseCategory();"> {{ trans('courses/general.filter.advanced') }}
                                          </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="segmented-controls difficulty-level clearfix">
                                    <div class="buttons-container level-buttons-container">
                                        <a href="{{Request::url() . '?difficulty=0&sort=' . Input::get('sort').'&term='. Input::get('term') }}"  data-target=".ajax-content" 
                                           data-url="{{Request::url() . '?difficulty=0&sort=' . Input::get('sort'). '&term='. Input::get('term') }}"
                                            data-callback="ajaxifyPagination" class="load-remote beginner segmented-buttons level-buttons @if(!isset($difficultyLevel) || $difficultyLevel == 0 ) active @endif">
                                               {{ trans('courses/general.filter.all') }}
                                        </a>
                                        <a href="{{Request::url() . '?difficulty=1&sort=' . Input::get('sort').'&term='. Input::get('term') }}"  data-target=".ajax-content" 
                                           data-url="{{Request::url() . '?difficulty=1&sort=' . Input::get('sort'). '&term='. Input::get('term') }}"
                                           data-callback="ajaxifyPagination" class="load-remote advanced segmented-buttons level-buttons @if($difficultyLevel == 1) active @endif">
                                             {{ trans('courses/general.filter.beginner') }}
                                        </a>
                                        
                                           
                                        <a href="{{Request::url() . '?difficulty=3&sort=' . Input::get('sort').'&term='. Input::get('term') }}"  data-target=".ajax-content" 
                                           data-url="{{Request::url() . '?difficulty=3&sort=' . Input::get('sort'). '&term='. Input::get('term') }}" 
                                           data-callback="ajaxifyPagination" class="load-remote intermediate segmented-buttons level-buttons @if($difficultyLevel == 3) active @endif">
                                             {{ trans('courses/general.filter.advanced') }}
                                        </a>
                                    </div>
                                    <div class="toggle-menus">
                                        <a href="#" class="menu menu-1"><i class="fa fa-th"></i></a>
                                        <a href="#" class="menu menu-2"><i class="fa fa-th-list"></i></a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>      
        </section>
        <section class="container-fluid category-box-container relative">
        	<style>
				.sidebar-menu{
					position: absolute;
					left: 0;
					top: 0;
					width: 260px;
					height: auto;
					background: #fff;
					padding: 15px 24px;
				}
				.sidebar-menu .group{
				}
				.sidebar-menu .group h3{
					text-transform: uppercase;
					font-size: 11px;
					font-weight: 600;
					margin: 24px 0 20px;
					color: #a7b7c4;
				}
				.sidebar-menu .group ul{
				}
				.sidebar-menu .group .main-menu .popular-list,
				.sidebar-menu .group .main-menu .main-menu-list{
					font-size: 13px;
					font-weight: 600;
					text-transform: uppercase;
				}
				.sidebar-menu .group .main-menu .popular-list a,
				.sidebar-menu .group .main-menu .main-menu-list{
					display: block;
					padding: 9px 13px;
					color: #303941;
					clear: both;
				}
				.sidebar-menu .group .main-menu .popular-list.active a,
				.sidebar-menu .group .main-menu .popular-list:hover a,
				.sidebar-menu .group .main-menu .main-menu-list.active,
				.sidebar-menu .group .main-menu .main-menu-list:hover,
				.sidebar-menu .group .main-menu .main-menu-list.open{
					background: #0099ff;
					color: #fff;
					border-radius: 2px;
					font-weight: normal;
				}
				.sidebar-menu .group ul li .dropdown-toggle{
					background: none;
					border: none;
					padding: 0;
					margin: 0;
					
				}
				.sidebar-menu .group ul li .dropdown-menu{
					position: relative;
					box-shadow: none;
					border: none;
					padding: 0;
					margin: 10px 0 35px;
					background: none;
				}
				.sidebar-menu .group ul li .dropdown-menu li a,
				.sidebar-menu .group ul li .dropdown-menu li {
					padding: 0;
					margin: 0;
					font-size: 13px;
					font-weight: normal;
					color: #798794;
				}
				.sidebar-menu .group ul li .dropdown-menu li a{
					padding: 6px 8px 6px 38px;
				}
				.sidebar-menu .group ul li .dropdown-menu li a:hover,
				.sidebar-menu .group ul li .dropdown-menu li a:active,
				.sidebar-menu .group ul li .dropdown-menu li a:focus{
					background: #0099ff;
					color: #fff;
					border-radius: 2px;
				}
				.sidebar-menu .group ul li .dropdown-menu li{
					margin-top: 13px;
				}
				.sidebar-menu .popular a:hover{
					color: #303941;
				}
			</style>
            <div class="sidebar-menu">
            	<div class="group popular">
                	<h3>Popular</h3>
                    <ul class="main-menu">
                    	<li class="popular-list"><a href="#">Featured</a></li>
                        <li class="popular-list"><a href="#">Best sellers</a></li>
                    </ul>
                </div>
            	<div class="group">
                	<h3>Categories</h3>
                    <ul class="main-menu">
                    	<li class="dropdown main-menu-list"> 
                        	<button class="dropdown-toggle" type="button" 
                            id="dropdownMenu2" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="true">
                            家庭と暮らし&ハンドメイド
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li><a href="#" class="active">Separated link</a></li>
                            </ul>
                        </li>
                    	<li class="dropdown main-menu-list"> 
                        	<button class="dropdown-toggle" type="button" 
                            id="dropdownMenu3" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="true">
                            家庭と暮らし&ハンドメイド
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    	<li class="dropdown main-menu-list"> 
                        	<button class="dropdown-toggle" type="button" 
                            id="dropdownMenu4" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="true">
                            家庭と暮らし&ハンドメイド
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu4">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    	<li class="dropdown main-menu-list"> 
                        	<button class="dropdown-toggle" type="button" 
                            id="dropdownMenu5" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="true">
                            家庭と暮らし&ハンドメイド
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu5">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    	<li class="dropdown main-menu-list"> 
                        	<button class="dropdown-toggle" type="button" 
                            id="dropdownMenu6" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="true">
                            家庭と暮らし&ハンドメイド
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu6">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    	<li class="dropdown main-menu-list"> 
                        	<button class="dropdown-toggle" type="button" 
                            id="dropdownMenu7" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="true">
                            家庭と暮らし&ハンドメイド
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu7">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    	<li class="dropdown main-menu-list"> 
                        	<button class="dropdown-toggle" type="button" 
                            id="dropdownMenu8" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="true">
                            家庭と暮らし&ハンドメイド
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu8">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    	<li class="dropdown main-menu-list"> 
                        	<button class="dropdown-toggle" type="button" 
                            id="dropdownMenu9" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="true">
                            家庭と暮らし&ハンドメイド
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu9">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    	<li class="dropdown main-menu-list"> 
                        	<button class="dropdown-toggle" type="button" 
                            id="dropdownMenu10" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="true">
                            家庭と暮らし&ハンドメイド
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu10">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    	<li class="dropdown main-menu-list"> 
                        	<button class="dropdown-toggle" type="button" 
                            id="dropdownMenu11" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="true">
                            家庭と暮らし&ハンドメイド
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu11">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            
        <div class='ajax-content'>
             {{ View::make('courses.categories.courses')->with( compact( 'courses', 'category', 'wishlisted' ) ) }}
        </div>
        </section>

    @stop

    @section('extra_js')
        <script type="text/javascript">
            function loadFilteredCourseCategory()
            {
                var url = '/courses/category?';
                var data = Array('term='+$('.header-search').val(),'sort='+$('.course-sort').val(),'filter='+$('.filter:checked').val(),'difficulty='+$('.difficulty:checked').val())
                // console.log(data);

                url = url + data.join('&');

                $('.ajax-content').html( '<a href="#" data-callback="ajaxifyPagination" data-target=".ajax-content" data-url="'+url+'" class="load-remote course-desc-ajax-link">loading</a>' );
                $('.course-desc-ajax-link').click();
            }
            $(function(){
                $('.level-buttons-container a').click(function(){
                    $('.level-buttons-container a').removeClass('active');
                });
                
//                 $('select[name=sort]').on('change', function(){
//                     var sort = $("select[name=sort] option:selected").val();
//                     var loc = location.href;
//                     loc += loc.indexOf("?") === -1 ? "?" : "&";
//                     var existingParams = document.URL.split('?');

//                     if (existingParams.length > 1){
//                         var params = existingParams[1].split('&');
//                         var validParams = new Array();
//                         for(var i = 0; i< params.length; i++){
//                             if (params[i].indexOf('sort') < 0){
//                                 validParams.push(params[i]);
//                             }
//                         }
// //                        location.href = existingParams[0] + '?' + validParams.join('&') + '&' + "sort=" + sort;
//                         url = existingParams[0] + '?' + validParams.join('&') + '&' + "sort=" + sort;
//                     }
//                     else {
// //                        location.href = loc + "sort=" + sort;
//                         url = loc + "sort=" + sort;
//                     }
                    
//                     $('.ajax-content').html( '<a href="#" data-callback="ajaxifyPagination" data-target=".ajax-content" data-url="'+url+'" class="load-remote course-desc-ajax-link">loading</a>' );
//                     $('.course-desc-ajax-link').click();
//                 });
            });
            
            ajaxifyPagination( null );
            
        </script>
    @stop