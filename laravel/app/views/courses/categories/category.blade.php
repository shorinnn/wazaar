@extends('layouts.default')
@section('page_title')
    
    @if( Input::has('term') ) {{ Input::get('term') }} - 
    @else
        @if( isset($subcategory->name) ) {{ $subcategory->name }} - @endif
        @if( isset($category->name) ) {{ $category->name }} - @endif
    @endif
    Wazaar
@stop
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
    .other-main-category-list-item,
    .selected-main-category{
      padding-left: 27px;
      padding-right: 30px;
    }
    .other-sub-category-list-item{
      padding-left: 50px;
      padding-right: 30px;
    }
    .modal-body .mobile-main-category-list{
      padding-top: 10px;
    }
    .mobile-main-category-list .list-group-item a,
    .mobile-sub-category-list .list-group-item a{
      display: block;
    }
    .mobile-main-category-list .arrow,
    .mobile-sub-category-list .arrow{
      line-height: 25px;
      font-size: 13px;
    }
    .subcat-selected .arrow{
      margin-top: -13px;
    }
    .selected-main-category,
    .selected-sub-category{
      cursor: pointer;
    }
    .selected-main-category .small,
    .selected-sub-category .small{
      font-size: 12px;
      color: #798794;
    }
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
        <section class="visible-xs visible-sm hidden-md hidden-lg filter-container">
          @if(count(Request::segments()) >= 2)
            <ul class="mobile-main-category-list list-group">
              <li class="selected-main-category list-group-item">
                <div @if(count(Request::segments()) == 4)class="subcat-selected"@endif>
                  @if(count(Request::segments()) == 4)
                    @foreach($categories as $cat)
                      @if(Request::segment(3)==$cat->slug)
                        <span class="small"> {{ $cat->name }}</span><br />
                        @foreach($cat->courseSubcategories as $subcat)
                            @if(Request::segment(4)==$subcat->slug)
                              {{$subcat->name}}
                            @endif
                        @endforeach
                      @endif
                    @endforeach
                  @elseif(count(Request::segments()) == 3)
                    @foreach($categories as $cat)
                      @if(Request::segment(3)==$cat->slug)
                        {{ $cat->name }}
                      @endif
                    @endforeach
                  @else
                    Categories
                  @endif
                  <i class="arrow wa-chevron-down right"></i>
                  <div class="clearfix"></div>
                </div>
              </li>
            </ul>
          @endif

          <?php /*@if(count(Request::segments()) == 4)
            <ul class="mobile-sub-category-list list-group">
              <li class="selected-sub-category list-group-item">
                <div>
                @foreach($categories as $cat)
                  @if(Request::segment(3)==$cat->slug)
                    <div class="small"> {{ $cat->name }}</div>
                    @foreach($cat->courseSubcategories as $subcat)
                        @if(Request::segment(4)==$subcat->slug)
                          {{$subcat->name}}
                        @endif
                    @endforeach
                  @endif
                @endforeach
                  <i class="arrow wa-chevron-down right"></i>
                  <div class="clearfix"></div>
                </div>
              </li>
              <div class="other-sub-category-list hide">
                @foreach($categories as $cat)
                  @if(Request::segment(3)==$cat->slug)
                    @foreach($cat->courseSubcategories as $subcat)
                        @if(Request::segment(4)!=$subcat->slug)
                        <li class="other-sub-category-list-item list-group-item">
                            <a href="{{ action('CoursesController@subCategory',['slug' => $cat->slug, 'subcat' => $subcat->slug] ) }}">
                              {{$subcat->name}}
                              <i class="arrow wa-chevron-right right"></i>
                              <div class="clearfix"></div>
                            </a>
                        </li>
                        @endif
                    @endforeach
                  @endif
                @endforeach
              </div>
            </ul>
          @endif */?>
        </section>
        <div class="hidden-xs hidden-sm visible-md visible-lg">
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
    </div>
    <div class="category-content-container pull-right">
      <div class="hidden-xs hidden-sm visible-md visible-lg filter-container">
        @include('courses.categories.partials._filter_partial')
      </div>
      <div class='ajax-content'>
           {{ View::make('courses.categories.courses')->with( compact( 'courses', 'category', 'subcategory', 'search', 'wishlisted' ) ) }}
      </div>
    </div>
    <div class="clearfix"></div>
  </section>
<div id="category-list-modal" class="modal fade" style="overflow-y:hidden;">
  <div class="modal-dialog" style="width:100%; margin:0px !important">
    <div class="modal-content" style="border-radius:0px;">
      <div class="modal-header" style="border-bottom: 0px none; padding-bottom: 0px; z-index: 1; width: 100%; height: 50px; position: static; background: #fff;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close fa-lg"></i></button>
        <div class="clearfix"></div>
      </div>
      <div class="modal-body" style="padding:0px; overflow:auto;">
        <div class="clearfix"></div>
          @if(count(Request::segments()) >= 2)
            <ul class="mobile-main-category-list list-group">
              <li class="selected-main-category list-group-item">
                <div @if(count(Request::segments()) == 4)class="subcat-selected"@endif>
                  @if(count(Request::segments()) == 4)
                    @foreach($categories as $cat)
                      @if(Request::segment(3)==$cat->slug)
                        <span class="small"> {{ $cat->name }}</span><br />
                        @foreach($cat->courseSubcategories as $subcat)
                            @if(Request::segment(4)==$subcat->slug)
                              {{$subcat->name}}
                            @endif
                        @endforeach
                      @endif
                    @endforeach
                  @elseif(count(Request::segments()) == 3)
                    @foreach($categories as $cat)
                      @if(Request::segment(3)==$cat->slug)
                        {{ $cat->name }}
                      @endif
                    @endforeach
                  @else
                    Categories
                  @endif
                  <i class="arrow wa-chevron-down right"></i>
                  <div class="clearfix"></div>
                </div>
              </li>
              <div class="other-main-category-list">
                @foreach($categories as $cat)
                  @if(Request::segment(3)==$cat->slug)
                    @if(count(Request::segments()) == 4)
                    <li class="other-main-category-list-item list-group-item">
                        <a href="{{ action('CoursesController@category',[ 'slug' => $cat->slug ] ) }}">
                            {{ $cat->name }}
                          <i class="arrow wa-chevron-right right"></i>
                          <div class="clearfix"></div>
                        </a>
                    </li>
                    @endif

                    @foreach($cat->courseSubcategories as $subcat)
                      <li class="other-sub-category-list-item list-group-item">
                          <a href="{{ action('CoursesController@subCategory',['slug' => $cat->slug, 'subcat' => $subcat->slug] ) }}">
                            {{$subcat->name}}
                            <i class="arrow wa-chevron-right right"></i>
                            <div class="clearfix"></div>
                          </a>
                      </li>
                    @endforeach
                  @endif
                @endforeach

                @if(count(Request::segments()) >= 3)
                    <li class="other-main-category-list-item list-group-item">
                        <a href="{{ action('CoursesController@category') }}">
                            All Categories
                          <i class="arrow wa-chevron-right right"></i>
                          <div class="clearfix"></div>
                        </a>
                    </li>
                @endif
                @foreach($categories as $cat)
                  @if(Request::segment(3)!=$cat->slug)
                      <li class="other-main-category-list-item list-group-item">
                          <a href="{{ action('CoursesController@category',[ 'slug' => $cat->slug ] ) }}">
                              {{ $cat->name }}
                            <i class="arrow wa-chevron-right right"></i>
                            <div class="clearfix"></div>
                          </a>
                      </li>
                  @endif
                @endforeach
              </div>
            </ul>
          @endif        
      </div>
    </div>
  </div>
</div>
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
              var url = '/courses/category';
              @if(isset($category->slug) && !empty($category->slug))
                url = url + '/{{$category->slug}}';
                @if(isset($subcategory->slug) && !empty($subcategory->slug))
                  url = url + '/{{$subcategory->slug}}';
                @endif
              @endif
              var data = Array('term='+$('.header-search').val(),'sort='+$(parent_visible_container).find('.course-sort').val(),'filter='+$(parent_visible_container).find('.filter:checked').val(),'difficulty='+$(parent_visible_container).find('.difficulty:checked').val())
              // var data = Array('term='+$('.header-search').val(),'sort='+$('.course-sort').val(),'filter='+$('.filter:checked').val(),'difficulty='+$('.difficulty:checked').val())
              // console.log(data);

              url = url + '?' + data.join('&');

              $('.ajax-content').html( '<a href="#" data-callback="ajaxifyPagination" data-target=".ajax-content" data-url="'+url+'" class="load-remote course-desc-ajax-link">loading</a>' );
              $('.course-desc-ajax-link').click();
              $('.category-content-container').css('height', 'auto');
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
          function makeCategoryModalHeightFixed()
          {
            if (navigator.userAgent.match(/(iPhone|iPod|iPad)/i)) {
                $(window).scroll(function () {
                    $currentScrollPos = $(document).scrollTop();
                })
                if ($('body').hasClass('modal-open')) {
                    $('body').css({
                        'position': 'fixed'
                    });
                    localStorage.cachedScrollPos = $currentScrollPos;
                }
            }

            var window_height = $(window).height();
            var modal_body_height = Number(window_height) - 51;
            $('#category-list-modal .modal-backdrop').height('100%');
            $('#category-list-modal .modal-body').height(modal_body_height);
          }

    			$(window).resize(function(){
            makeFluid();
            makeCategoryModalHeightFixed();
    			})
          $(document).scroll(function(){
            makeCategoryModalHeightFixed();
          });
    			$(function(){
            makeFluid();
            makeCategoryModalHeightFixed();
            $('.level-buttons-container a').click(function(){
                $('.level-buttons-container a').removeClass('active');
            });

            if($('.selected-main-category').length >= 1){
              $('.selected-main-category').on('click', function(){
                $('#category-list-modal').modal().on('shown.bs.modal', function () {
                    makeCategoryModalHeightFixed()
                }).on('hidden.bs.modal', function () {
                  if (navigator.userAgent.match(/(iPhone|iPod|iPad)/i)) {
                    $('body').css({
                        'position': 'relative'
                    });
                    $('body').scrollTop(localStorage.cachedScrollPos);
                  }
                });
              })
            }

            if($('.selected-sub-category').length >= 1){
              $('.selected-sub-category').on('click', function(){
                $('#category-list-modal').modal().on('shown.bs.modal', function () {
                    makeCategoryModalHeightFixed()
                }).on('hidden.bs.modal', function () {
                  if (navigator.userAgent.match(/(iPhone|iPod|iPad)/i)) {
                    $('body').css({
                        'position': 'relative'
                    });
                    $('body').scrollTop(localStorage.cachedScrollPos);
                  }
                });
              })
            }

          });
          
          ajaxifyPagination( null );
            
        </script>
    @stop