<div class="row">
	 @if(Auth::check())
    	<div class="top-menu clearfix col-md-12">
     @else
     	<div class="top-menu unauthenticated-home-header clearfix col-md-12">
     @endif
            <a href="{{ action('SiteController@index') }}" class="main-logo">
                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" 
               class="img-responsive" alt="">
               <span class="beta-wazaar">ベータ版</span>
            </a>
            @if (!Request::segment(1))
                <style>
                    header{
                        background: none;
                    }
                    
                    .logged-out-header-search{
                        display: none;
                    }
                </style>        
            @endif
            @if(Auth::check())
        <div class="clearfix left">
            <div class="logged-out-header-search text-center hidden-xs">
                <?php if('dont-show' == 'dont-show'):?>
                <div class="clearfix inline-block">
                    <div class="activate-dropdown left relative">
                        <button aria-expanded="false" data-toggle="dropdown" 
                                class="catalogue-button dropdown-toggle" type="button" id="btnGroupDrop2">
                            <i class="wa-tiny-list"></i>
                            <em>{{trans('general.catalogue')}}</em>
                        </button>
                        
                        <div id="catalogue-dropdown" aria-labelledby="btnGroupDrop2" role="menu" class="dropdown-menu">
                            <ul>
                                <?php 
                                echo Flatten::section('header-categories-catalog', 10, function ()  { 
                                    $categories = CourseCategory::has('allCourses')->get();
                                    $categories->load( 'courseSubcategories' );?>
                                
                                    @foreach( $categories as $category)

                                            @if($category->courseSubcategories)
                                                <li  class="dropdown-list"><a href="{{Config::get('app.url') .'/courses/category/' . $category->slug}}">{{$category->name}} <i class="wa-chevron-right"></i></a>
                                                    <ul>
                                                        @foreach($category->courseSubcategories as $subCategory)
                                                            <li><a href="{{Config::get('app.url')  . '/courses/category/' . $category->slug . '/' . $subCategory->slug}}">{{$subCategory->name}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                            <li><a href="{{Config::get('app.url')  . '/courses/category/' . $category->slug}}">{{$category->name}}</a></li>
                                            @endif

                                    @endforeach
                                    
                                    <?php }); ?>
                            </ul>
                        </div>
                    </div>
                    <form action='{{ action('CoursesController@search') }}'>
                        <div>
                            <button><i class="wa-search"></i></button>
                            <input type="search" name="term" class="header-search" value='{{Input::get('term')}}' placeholder="{{ trans('general.search') }}">
                        </div>
                    </form>
                </div>
                <?php endif;?>
            </div>
        </div>
        <div class="clearfix right logged-in-menu-holder">
            @if( isset($headerShowTopLinks) )
                <ul class="logged-in-top-menu">
                
                @if(Auth::check() && Auth::user()->hasRole('Affiliate'))
                    <li>
                        <a href="#">{{trans('general.affiliate-dash')}}</a>
                    </li>
                @endif
                
                @if( App::environment() !='production')
                    <li>
                        <a href="#">{{trans('site/homepage.store')}}</a>
                    </li>
                    <li>
                        <a href="#">{{trans('site/homepage.my-courses')}}</a>
                        <!--<a href="{{ action('StudentController@mycourses') }}">{{trans('site/homepage.my-courses')}}</a>-->
                    </li>
                @endif
                
                @if(Auth::check() && Auth::user()->hasRole('Instructor'))
                    <li>
                        <a href="{{ action('CoursesController@myCourses') }}">{{trans('site/homepage.teach')}}</a>
                    </li>
                @endif
            </ul>
            @endif
            <div class="top-profile-info">          
                
                <span class="profile-level">12</span>
                <div class="profile-thumbnail">
          
                    @if( Auth::user()->_profile('Instructor') !=null && trim(Auth::user()->_profile('Instructor')->photo) !='' )
                    <img style="height: 30px; width: 30px; border-radius: 30px;" 
                             src="{{ cloudfrontUrl( Auth::user()->_profile('Instructor')->photo ) }}" alt="">
                    @elseif( Auth::user()->_profile('Affiliate') != null && trim(Auth::user()->_profile('Affiliate')->photo) !='' )
                    <img style="height: 30px; width: 30px; border-radius: 30px;" 
                             src="{{ cloudfrontUrl( Auth::user()->_profile('Affiliate')->photo ) }}" alt="">
                    @elseif( Auth::user()->_profile('Student') !=null && trim(Auth::user()->_profile('Student')->photo) !='' )
                        <img style="height: 30px; width: 30px; border-radius: 30px;" 
                             src="{{ cloudfrontUrl( Auth::user()->_profile('Student')->photo ) }}" alt="">                
                    @else
                        <img style="height: 30px; width: 30px; border-radius: 30px;" 
                             src="{{cloudfrontUrl("//s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg")}}" alt="">
                    @endif
                    
                </div>
                <ul class="profile-name">
                    <li class="activate-dropdown">
                        <button aria-expanded="false" data-toggle="dropdown" 
                                class="btn btn-default dropdown-toggle" type="button" id="btnGroupDrop1">
                            <span class="greeting hidden-xs">{{trans('site/menus.hi')}}, </span> <span class="hidden-xs">{{ Auth::user()->fullName() }}</span> <i class="wa-chevron-down"></i>
                        </button>
                        <ul id="top-profile-dropdown" aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu">
                            <?php /*-- <li>
                                <a class="profile-button" href="{{ action('ProfileController@index') }}">{{trans('site/menus.profile')}}</a>
                            </li> 
           @if( !Auth::user()->hasRole('Affiliate') &&  !Auth::user()->hasRole('Instructor') )
                            <li>
                                <a class="courses-button" href="{{ action('StudentController@mycourses') }}">{{trans('site/menus.courses')}}</a>
                            </li>
                            @endif
                             *                              */?>

                            @if( Auth::user()->hasRole('Affiliate'))
                                <li>
                                    <a class="courses-button" href="{{ action('AffiliateDashboardController@index') }}">{{trans('site/menus.analytics')}}</a>
                                </li>
                            @endif

                            @if( !Auth::user()->hasRole('Affiliate') && Auth::user()->hasRole('Student') &&  !Auth::user()->hasRole('Instructor') )
                                <li>
                                    <a class="courses-button" href="{{ action('StudentController@mycourses') }}">{{trans('site/menus.courses')}}</a>
                                </li>
                            @endif
                            @if( !Auth::user()->hasRole('Affiliate') &&  Auth::user()->hasRole('Instructor') )
                                <li>
                                    <a class="courses-button" href="{{ action('CoursesController@myCourses')}}">{{trans('site/menus.courses')}}</a>
                                </li>
                            @endif
                            
                            <!--
                            <li>
                                <a class="settings-button" href="#">{{trans('site/menus.analytics')}}</a>
                            </li>-->
                            <li style="display:none">
                                <a class="settings-button" href="{{ action('PrivateMessagesController@index') }}">{{trans('site/menus.messages')}}
    
                                </a>
                                <?php
//                                    $received = $student->receivedMessages()->unread( $student->id )->with('sender.profiles')->with('sender')->with('course')->get();
//                                    @if( $received->count() > 0)
                                ?>
                                @if( 1 == 2)
                                <style>
                                    .notification-number:hover div {
                                        display:block !important;
                                    }
                                </style>
                                    <span class="notification-number">
                                        {{ $received->count() }}
                                        <div style="background-color:white; position:absolute; right:0px; display:none; width: 300px; font-size:12px;">
                                            <table class="table table-striped">
                                                foreach( $student->grouppedNotifications( $received ) as $key => $notification)
                                                <tr><td>
                                                    <a href="{{ $notification['url'] }}">{{ $notification['text'] }}</a>
                                                    </td></tr>
                                                endforeach
                                            </table>
                                        </div>
                                    </span>
                                @endif
                            </li>
                            @if(Auth::check() && Auth::user()->hasRole('Instructor'))
                                <li>
                                    <a a href="{{action('InstructorDashboardController@index')}}">{{trans('site/menus.analytics')}}</a>
                                </li>
                            @endif
                            <li>
                                <a class="settings-button" href="{{ action('ProfileController@index')}}">{{trans('site/menus.profile')}}</a>
                            </li>
<!--                        <li>
                                <a class="settings-button" href="{{ action('ProfileController@settings')}}">{{trans('site/menus.settings')}}</a>
                            </li>-->
                            <li>
                                <a class="settings-button" href="{{ action('UsersController@logout') }}">{{trans('site/menus.logout')}}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                
            </div>
            @if(Auth::check() && Auth::user()->hasRole('Affiliate'))
            <ul class="logged-out clearfix" style="margin-right: 15px;">
                <li>
                    <a href="{{ action('CoursesController@category') }}"> <span class="hidden-xs">{{trans('general.browse-courses')}}</span><span class="visible-xs-inline hidden-sm hidden-md hidden-lg">{{trans('administration.browse')}}</span></a> 
                </li>
            </ul>
            @endif
            @if(Auth::check() && Auth::user()->hasRole('Instructor'))
            <ul class="logged-out clearfix" style="margin-right: 15px;">
                <li>
                    <a href="{{ action('CoursesController@category') }}"><span class="hidden-xs">{{trans('general.browse-courses')}}</span><span class="visible-xs-inline hidden-sm hidden-md hidden-lg">{{trans('administration.browse')}}</span></a> 
                </li>
            </ul>
            @endif
        </div>
        @else
            
            @if( Route::currentRouteAction()!='UsersController@login' && Route::currentRouteAction()!='UsersController@create')
            <style>
                .top-menu .main-logo {
                    display:block;
                }
            </style>
            @endif
            <div class="navbar navbar-default">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#logged-out-header-menu" aria-expanded="false">
                	<span class="sr-only">Toggle navigation</span>
                	<span class="icon-bar"></span>
                	<span class="icon-bar"></span>
                	<span class="icon-bar"></span>
                </button>
                <ul id="logged-out-header-menu" class="logged-out clearfix collapse navbar-collapse">
                    <li>
                        <a href="{{url('/')}}/courses/category">{{trans('site/menus.homepage.browse')}}</a> 
                    </li>
                    <li>
                        <a href="{{ action('UsersController@login') }}"> {{trans('site/menus.homepage.login')}}</a> 
                        <!--<a href="" data-toggle="modal" data-target="#loginModal"> {{trans('general.login')}}</a>--> 
                    </li>
                    <li class="register-button">
                        <a href="{{ action('UsersController@create') }}"> {{ trans('site/menus.homepage.register') }}</a>
                        <!--<a href="" data-toggle="modal" data-target="#registerModal"> {{ trans('general.register') }}</a>-->
                    </li>
                </ul>
            </div>
            <!-- please check if the code below are still usable if not lets remove -->
            <ul class="logged-out clearfix visible-xs-block hidden-sm hidden-md hidden-lg hide">
                <li>
                    <a href="{{ action('CoursesController@category') }}"><span class="hidden-xs">{{trans('general.browse-courses')}}</span><span class="visible-xs-inline hidden-sm hidden-md hidden-lg">{{trans('administration.browse')}}</span></a> 
                </li>
                <li>
                    <a href="{{ action('UsersController@login') }}"> {{trans('general.login')}}</a> 
                    <!--<a href="" data-toggle="modal" data-target="#loginModal"> {{trans('general.login')}}</a>--> 
                </li>
                <li class="register-button">
                    <a href="{{ action('UsersController@create') }}"> {{ trans('general.register') }}</a>
                    <!--<a href="" data-toggle="modal" data-target="#registerModal"> {{ trans('general.register') }}</a>-->
                </li>
            </ul>
            <div class="logged-out-header-search text-center hidden-xs">
                 <?php if('dont-show' == 'dont-show'):?>
            	<div class="clearfix inline-block">
                    <div class="activate-dropdown left relative">
                        <button aria-expanded="false" data-toggle="dropdown" 
                                class="catalogue-button dropdown-toggle" type="button" id="btnGroupDrop2">
                            <i class="wa-tiny-list"></i>
                            <em>{{trans('general.catalogue')}}</em>
                        </button>
                        <div id="catalogue-dropdown" aria-labelledby="btnGroupDrop2" role="menu" class="dropdown-menu">
                            <ul>
                                
                               <?php echo Flatten::section('header-categories-catalog', 10, function ()  { 
                                    $categories = CourseCategory::has('allCourses')->get();
                                    $categories->load( 'courseSubcategories' );?>
                               
                                
                                    @foreach( $categories as $category)

                                            @if($category->courseSubcategories)
                                                <li  class="dropdown-list"><a href="{{Config::get('app.url') . '/courses/category/' . $category->slug}}">{{$category->name}}<i class="wa-chevron-right"></i></a>
                                                    <ul>
                                                        @foreach($category->courseSubcategories as $subCategory)
                                                            <li><a href="{{Config::get('app.url')  . '/courses/category/' . $category->slug . '/' . $subCategory->slug }}">{{$subCategory->name}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                            <li><a href="{{Config::get('app.url')  . '/courses/category/' . $category->slug}}">{{$category->name}}</a></li>
                                            @endif

                                    @endforeach
                                    
                                    <?php }); ?>

                            </ul>
                        </div>
                    </div>
                    <form action='{{ action('CoursesController@search') }}'>
                        <div>
                            <button><i class="wa-search"></i></button>
                            <input type="search" name="term" class="header-search" value='{{Input::get('term')}}' placeholder="{{ trans('general.search') }}">
                        </div>
                    </form>
                </div>
                <?php endif;?>
            </div>
            <ul class="logged-out hidden-xs hide clearfix">
                <li>
                    <a href="{{ action('CoursesController@category') }}"><span class="hidden-xs">{{trans('general.browse-courses')}}a</span><span class="visible-xs-inline hidden-sm hidden-md hidden-lg">{{trans('administration.browse')}}s</span></a> 
                </li>
                <li>
                    <!--<a href="" data-toggle="modal" data-target="#loginModal"> {{trans('general.login')}}</a>-->
                    <a href="{{ action('UsersController@login') }}"> {{trans('general.login')}}c</a> 
                </li>
                <li class="register-button">
                    <!--<a href="" data-toggle="modal" data-target="#registerModal"> {{ trans('general.register') }}</a>-->
                    <a href="{{ action('UsersController@create') }}"> {{ trans('general.register') }}d</a>
                </li>
            </ul>
        @endif

    </div>
</div>
