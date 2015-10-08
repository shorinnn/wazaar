    @extends('layouts.default')
    @section('content')	
    <style>
	.category-heading-title,
		.footer-search{
			display: none;
		}
		
	</style>
  <section class="container-fluid category-box-container relative">
    <div class="sidebar-menu">
        <div class="group popular">
            <h3>Popular</h3>
            <ul class="main-menu">
                <li class="popular-list"><a href="#">Featured<i class="wa-chevron-right right hidden-md hidden-lg"></i></a></li>
                <li class="popular-list"><a href="#">Best sellers<i class="wa-chevron-right right hidden-md hidden-lg"></i></a></li>
            </ul>
        </div>
        <div class="group">
            <h3>Categories</h3>
            <ul class="main-menu clearfix category-menu-list">
                @if(count(Request::segments()) >= 3)
                    @foreach($categories as $cat)
                        @if(Request::segment(3)==$cat->slug)
                            <li class="dropdown main-menu-list open @if(count(Request::segments()) == 3) active @endif">
                                <a href="{{ action('CoursesController@category',[ 'slug' => $cat->slug ] ) }}" class="dropdown-toggle category-menu-item" id="dropdownMenu-c-{{$cat->id}}">
                                    {{ $cat->name }}
                                    <i class="wa-chevron-down right hidden-md hidden-lg"></i>
                                    <i class="wa-chevron-up hidden-md hidden-lg"></i>
                                </a>
                                <ul class="dropdown-menu sub-category-menu-list">
                                    @foreach($cat->courseSubcategories as $subcat)
                                        <li @if(Request::segment(4)==$subcat->slug) class='active' @endif>
                                            <a class="sub-categoty-menu-item" href="{{
                                            action('CoursesController@subCategory',['slug' => $cat->slug, 'subcat' => $subcat->slug] ) }}">
                                                <span class="sub-category-menu-item-label">{{$subcat->name}}</span>
                                                <i class="wa-chevron-right right hidden-md hidden-lg"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                
                    @foreach($categories as $cat)
                        @if(Request::segment(3)!=$cat->slug)
                            <li class="dropdown main-menu-list"> 
                                <a href="{{ action('CoursesController@category',[ 'slug' => $cat->slug ] ) }}" class="dropdown-toggle category-menu-item" id="dropdownMenu-c-{{$cat->id}}">
                                    {{ $cat->name }}
                                    <i class="wa-chevron-down right hidden-md hidden-lg"></i>
                                    <i class="wa-chevron-up hidden-md hidden-lg"></i>
                                </a>
                                <ul class="dropdown-menu sub-category-menu-list">
                                    @foreach($cat->courseSubcategories as $subcat)
                                        <li>
                                            <a class="sub-categoty-menu-item" href="{{ action('CoursesController@subCategory',['slug' => $cat->slug, 'subcat' => $subcat->slug] ) }}">
                                                <span class="sub-category-menu-item-label">{{$subcat->name}}</span>
                                                <i class="wa-chevron-right right hidden-md hidden-lg"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach

                @elseif(count(Request::segments()) <= 2)
                    @foreach($categories as $cat)
                        <li class="dropdown main-menu-list"> 
                            <a href="{{ action('CoursesController@category',[ 'slug' => $cat->slug ] ) }}" class="dropdown-toggle category-menu-item" id="dropdownMenu-c-{{$cat->id}}">
                                {{ $cat->name }}
                                <i class="wa-chevron-down right hidden-md hidden-lg"></i>
                                <i class="wa-chevron-up hidden-md hidden-lg"></i>
                            </a>
                            <ul class="dropdown-menu sub-category-menu-list">
                                @foreach($cat->courseSubcategories as $subcat)
                                <li>
                                    <a class="sub-categoty-menu-item" href="{{ action('CoursesController@subCategory',['slug' => $cat->slug, 'subcat' => $subcat->slug] ) }}">
                                        <span class="sub-category-menu-item-label">{{$subcat->name}}</span>
                                        <i class="wa-chevron-right right hidden-md hidden-lg"></i>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    <div class="category-content-container">
      <div>
        @include('courses.categories.partials._filter_partial')
      </div>
      <div class='ajax-content'>
           {{ View::make('courses.categories.courses')->with( compact( 'courses', 'category', 'wishlisted' ) ) }}
      </div>
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
			function arrangeCourseBox(){
				var $window = $(window);
				var $windowWidth = $window.width();

				if($windowWidth <= 1200 && $windowWidth >= 991){
					$('.category-box-container .course-box-wrap').removeClass('col-md-4').addClass('col-md-6');
					$('.category-box-container .ajax-content > .container').css('width', '100%');	
				}
				else if($windowWidth > 1300){
					$('.category-box-container .ajax-content > .container').css('width', '1032px');
				}
				
			}
			$(window).resize(function(){
				arrangeCourseBox();
			});
			
			$(window).load(function(){
				arrangeCourseBox();
			});
			
				
			$( document ).ajaxComplete(function() {
			   arrangeCourseBox(); 
			});
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