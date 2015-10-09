    @extends('layouts.default')
    @section('content')	
    <style>
	.category-heading-title,
		.footer-search{
			display: none;
		}
    .course-main-container .course-box-wrap.pull-left{
      width:324px;
      padding: 0px 10px;
    }
    .course-main-container{
      max-width: 1050px;
      margin: 0px auto;
    }
    /*@media (min-width: 1190px){
      .course-main-container{
        padding: 0px 40px;
      }
    }*/
    @media (max-width: 650px){
      .category-content-container{
        width: 100%;
        float: none;
      }
      .course-main-container .course-box-wrap.pull-left{
        float: none !important;
        margin: 0px auto;
      }
    }
    @media (min-width:750px) and (max-width: 810px){
      .course-main-container{
        padding: 0px 50px;
      }
    }
    @media (min-width:1014px) and (max-width: 1074px){
      .course-main-container{
        padding: 0px 50px;
      }
    }
    @media (min-width:790px) and (max-width: 850px){
      .course-main-container{
        padding: 0px 70px;
      }
    }
	</style>
  <section class="visible-xs visible-sm hidden-md hidden-lg filter-container">
    @include('courses.categories.partials._filter_partial')
  </section>
  <section class="container-fluid category-box-container relative no-padding">
    <div class="sidebar-menu pull-left">
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
    <div class="category-content-container pull-right">
      <div class="hidden-xs hidden-sm visible-md visible-lg filter-container">
        @include('courses.categories.partials._filter_partial')
      </div>
      <div class='ajax-content'>
           {{ View::make('courses.categories.courses')->with( compact( 'courses', 'category', 'wishlisted' ) ) }}
      </div>
    </div>
    <div class="clearfix"></div>
  </section>

    @stop

    @section('extra_js')
        <script type="text/javascript">
          function loadFilteredCourseCategory(el)
          {
              var parent_visible_container = $('.filter-container:visible');
              var parent_hidden_container = $('.filter-container:hidden');
              
              $(parent_hidden_container).find('.course-sort').val($(parent_visible_container).find('.course-sort').val())
              $(parent_hidden_container).find('.filter').each(function(){
                if($(this).val() != $(parent_visible_container).find('.filter:checked').val()){
                  $(this).prop('checked', false).parent().removeClass('active');
                } else {
                  $(this).prop('checked', true).parent().addClass('active');
                }
              })

              $(parent_hidden_container).find('.difficulty').each(function(){
                if($(this).val() != $(parent_visible_container).find('.difficulty:checked').val()){
                  $(this).prop('checked', false).parent().removeClass('active');
                } else {
                  $(this).prop('checked', true).parent().addClass('active');
                }
              })

              var url = '/courses/category?';
              var data = Array('term='+$('.header-search').val(),'sort='+$(parent_visible_container).find('.course-sort').val(),'filter='+$(parent_visible_container).find('.filter:checked').val(),'difficulty='+$(parent_visible_container).find('.difficulty:checked').val())
              // var data = Array('term='+$('.header-search').val(),'sort='+$('.course-sort').val(),'filter='+$('.filter:checked').val(),'difficulty='+$('.difficulty:checked').val())
              // console.log(data);

              url = url + data.join('&');

              $('.ajax-content').html( '<a href="#" data-callback="ajaxifyPagination" data-target=".ajax-content" data-url="'+url+'" class="load-remote course-desc-ajax-link">loading</a>' );
              $('.course-desc-ajax-link').click();
          }

          function makeFluid()
          {
            if($(window).width() <= 1300){
              $('.ajax-content .container').each(function(){
                $(this).addClass('fluid-added').removeClass('container').addClass('container-fluid');
              })
            } else {
              $('.ajax-content .fluid-added').each(function(){
                $(this).removeClass('container-fluid').addClass('container');
              });
            }

            if($(document).width() <= 1000){
              $('.category-content-container, .sidebar-menu').css('height', 'auto');
            } else {
              var sidebar_height = $('.sidebar-menu').height();
              var category_content = $('.category-content-container').height();

              if(Number(sidebar_height) >= Number(category_content)){
                $('.category-content-container').height(sidebar_height);
              } else {
                $('.sidebar-menu').height(category_content);
              }
            }
            // if($(window).width() <= 1200 && $(window).width() >= 991){
            //   $('.category-box-container .course-box-wrap').removeClass('col-md-4').addClass('col-md-6');
            //   $('.category-box-container .ajax-content > .container').css('width', '100%'); 
            // }

          }

    			$(window).resize(function(){
            makeFluid();
    			});
		
    			$(function(){
            makeFluid();
            $('.level-buttons-container a').click(function(){
                $('.level-buttons-container a').removeClass('active');
            });
                    
          });
          
          ajaxifyPagination( null );
            
        </script>
    @stop