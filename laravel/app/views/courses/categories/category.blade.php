@extends('layouts.default')
@section('page_title')
    
    @if( Input::has('term') ) {{ Input::get('term') }} - 
    @else
        @if( isset($subcategory->name) && trim($subcategory->name) !='' ) {{ $subcategory->name }} - @endif
        @if( isset($category->name) && trim($category->name) !='' ) {{ $category->name }} - @endif
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
  
  .mobile-main-category-list .list-group-item a,
  .mobile-sub-category-list .list-group-item a{
    display: block;
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
  .modal.fade .modal-dialog {
    -webkit-transition: -webkit-transform .2s ease-out;
         -o-transition:      -o-transform .2s ease-out;
            transition:         transform .2s ease-out;
  }
  #category-list-modal{
    overflow-y:hidden;
  }
  #category-list-modal .modal-dialog{
    width:100%;
    margin:0px !important;
  }
  #category-list-modal .modal-dialog .modal-content{
    border-radius:0px;
  }
  #category-list-modal .modal-dialog .modal-content .modal-header{
    border-bottom: 0px none;
    padding-bottom: 0px;
    z-index: 1;
    width: 100%;
    height: 50px;
    position: static;
    background: #ebeced;
    color: #6d7c85;
  }
  #category-list-modal .modal-dialog .modal-content .modal-header span{
    font-size: 14px;
  }
  #category-list-modal .modal-dialog .modal-content .modal-body{
    padding:0px;
    overflow:auto;
  }
  #category-list-modal .modal-dialog .modal-content .modal-body .list-group-item{
    border: 0px;
    padding: 0px;
    margin-bottom: 0px;
  }
  #category-list-modal .modal-dialog .modal-content .modal-body .list-group-item a{
    border-bottom: #ebeced solid 1px;
    padding: 0px 32px 0px 26px;
    color: #303941;
    font-size: 13px;
    height: 40px;
    line-height: 40px;
  }
  #category-list-modal .modal-dialog .modal-content .modal-body .list-group-item a .arrow{
    font-size: 10px;
    line-height: 40px;
  }
  #category-list-modal .modal-dialog .modal-content .modal-body .list-group-item .mobile-sub-category-list li a{
    padding: 0px 24px 0px 50px;
    color: #798794;
    font-size: 12px;
  }
  #category-list-modal .modal-dialog .modal-content .modal-body .modal-list-label{
    background: #ebeced;
    padding-left: 26px;
    height: 36px;
    line-height: 36px;
    color: #a7b7c4;
    text-transform: uppercase;
    font-size: 11px;
  }
  .category-modal-toggler-container{
    padding: 0px 16px;
  }
  .category-modal-toggler-container .category-modal-toggler{
    background:#fff;
    border:#e0e1e2 solid 1px;
    border-radius:6px;
    padding:0px 24px;
    cursor: pointer;
  }
  .category-modal-toggler-container .category-modal-toggler .single{
    font-size: 15px;
    height: 44px;
    line-height: 44px;
    font-weight: bold;
    color: #303941;
  }
  .category-modal-toggler-container .category-modal-toggler .single .arrow{
    font-size: 10px;
    line-height: 44px;
  }
  .category-modal-toggler-container .category-modal-toggler .double{
    font-size: 15px;
    height: 62px;
    font-weight: bold;
    color: #303941;
  }
  .category-modal-toggler-container .category-modal-toggler .double .pull-left{
    padding-top: 8px;
  }
  .category-modal-toggler-container .category-modal-toggler .double span{
    font-weight: normal;
    font-style: 11px;
    color: #798794;
  }
  .category-modal-toggler-container .category-modal-toggler .double .arrow{
    line-height: 62px;
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
        <section class="visible-xs visible-sm hidden-md hidden-lg category-modal-toggler-container">
          
            <div class="category-modal-toggler">
              @if(count(Request::segments()) == 4)
                <div>
                @foreach($categories as $cat)
                  @if(Request::segment(3)==$cat->slug)
                    <div class="double">
                      <div class="pull-left">
                        <span class="small"> {{ $cat->name }}</span><br />
                        @foreach($cat->courseSubcategories as $subcat)
                            @if(Request::segment(4)==$subcat->slug)
                              {{$subcat->name}}
                            @endif
                        @endforeach
                      </div>
                  @endif
                @endforeach
              @elseif(count(Request::segments()) == 3)
                @foreach($categories as $cat)
                  @if(Request::segment(3)==$cat->slug)
                    <div class="single">
                      {{ $cat->name }}
                  @endif
                @endforeach
              @else
                <div class="single">
                  Categories
              @endif
                <i class="arrow wa-chevron-down right"></i>
                <div class="clearfix"></div>
              </div>
            </div>

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

<div id="category-list-modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <span>Select category</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
        <div class="clearfix"></div>
      </div>
      <div class="modal-body">
        <div class="clearfix"></div>
          @if(count(Request::segments()) >= 2)
            <div class="modal-list-label">categories</div>
            <ul class="mobile-main-category-list list-group">
              @foreach($categories as $cat)
                @if(Request::segment(3)==$cat->slug)
                  <li class="selected-main-category list-group-item active" id="{{$cat->slug}}">
                    <a href="#" class="main-category-toggler" data-target="{{$cat->slug}}">
                      {{ $cat->name }}
                      <i class="arrow wa-chevron-up right"></i>
                      <div class="clearfix"></div>
                    </a>
                    @if(count($cat->courseSubcategories) >= 1)
                    <ul class="mobile-sub-category-list">
                      <li>
                        <a href="{{ action('CoursesController@category',[ 'slug' => $cat->slug ] ) }}">
                          All
                          <i class="arrow wa-chevron-right right"></i>
                          <div class="clearfix"></div>
                        </a>
                      </li>
                      @foreach($cat->courseSubcategories as $subcat)
                        <li>
                          <a href="{{ action('CoursesController@subCategory',['slug' => $cat->slug, 'subcat' => $subcat->slug] ) }}">
                            {{$subcat->name}}
                            <i class="arrow wa-chevron-right right"></i>
                            <div class="clearfix"></div>
                          </a>
                        </li>
                      @endforeach
                    @endif
                    </ul>
                  </li>
                @endif
              @endforeach
              @foreach($categories as $cat)
                @if(Request::segment(3)!=$cat->slug)
                  <li class="selected-main-category list-group-item" id="{{$cat->slug}}">
                    <a href="#" class="main-category-toggler" data-target="{{$cat->slug}}">
                      {{ $cat->name }}
                      <i class="arrow wa-chevron-down right"></i>
                      <div class="clearfix"></div>
                    </a>
                    @if(count($cat->courseSubcategories) >= 1)
                    <ul class="mobile-sub-category-list hide">
                      <li>
                        <a href="{{ action('CoursesController@category',[ 'slug' => $cat->slug ] ) }}">
                          All
                          <i class="arrow wa-chevron-right right"></i>
                          <div class="clearfix"></div>
                        </a>
                      </li>
                      @foreach($cat->courseSubcategories as $subcat)
                        <li>
                          <a href="{{ action('CoursesController@subCategory',['slug' => $cat->slug, 'subcat' => $subcat->slug] ) }}">
                            {{$subcat->name}}
                            <i class="arrow wa-chevron-right right"></i>
                            <div class="clearfix"></div>
                          </a>
                        </li>
                      @endforeach
                    @endif
                    </ul>
                  </li>
                @endif
              @endforeach
            </ul>
          @endif        
      </div>
    </div>
  </div>
</div>
    @stop

    @section('extra_js')
      <script src="/js/jquery.scrollTo.min.js"></script>
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

            if($('.category-modal-toggler').length >= 1){
              $('.category-modal-toggler').on('click', function(){
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

            $('a.main-category-toggler').each(function(){
              $(this).on('click', function(){
                if(!$(this).parent().hasClass('active')){
                  $('a.main-category-toggler').each(function(){
                    $(this).children('i').removeClass('wa-chevron-up').addClass('wa-chevron-down');
                    $(this).parent().removeClass('active').children('ul.mobile-sub-category-list').slideUp(300);
                  })

                  $(this).children('i').removeClass('wa-chevron-down').addClass('wa-chevron-up');
                  target = $(this).data('target');
                  $(this).parent().addClass('active').children('ul.mobile-sub-category-list').hide().removeClass('hide').slideDown(300, function(){
                    $('.modal-body').scrollTo($('#'+target), 300,  {offset:-15});
                  })
                  
                  
                } else {
                  $(this).children('i').removeClass('wa-chevron-up').addClass('wa-chevron-down');
                  $(this).parent().removeClass('active').children('ul.mobile-sub-category-list').hide(300);
                }
                return false;
              })
            })

          });
          
          ajaxifyPagination( null );
            
        </script>
    @stop