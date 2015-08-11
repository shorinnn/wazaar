<div class="row">
    <div class="top-menu clearfix col-md-12">
            <a href="{{ action('SiteController@index') }}" class="main-logo">
                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" 
               class="img-responsive" alt=""></a>
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
            <?php
            $student = Student::find(Auth::user()->id);
            ?>
        <div class="clearfix left">
            <div class="logged-out-header-search text-center">
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
                                    $categories = CourseCategory::withCourses();
                                    $categories->load( 'courseSubcategories' );
                                ?>
                                @foreach( $categories as $category)
    
                                        @if($category->courseSubcategories)
                                            <li  class="dropdown-list"><a href="{{url('courses/category/' . $category->slug)}}">{{$category->name}}</a> <i class="wa-chevron-right"></i>
                                                <ul>
                                                    @foreach($category->courseSubcategories as $subCategory)
                                                        <li><a href="{{url('courses/category/' . $category->slug . '/' . $subCategory->slug)}}">{{$subCategory->name}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                        <li><a href="{{url('courses/category/' . $category->slug)}}">{{$category->name}}</a></li>
                                        @endif
    
                                @endforeach
                                <!--<li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li class="dropdown-list">
                                    Business & Marketing <i class="wa-chevron-right"></i>
                                    <ul>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>                                
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                    <form>
                        <div>
                            <button><i class="wa-search"></i></button>
                            <input type="search" name="header-search" class="header-search" placeholder="Search...">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clearfix right logged-in-menu-holder">
            <ul class="logged-in-top-menu">
                
                @if(Auth::check() && $student->hasRole('Affiliate'))
                    <li>
                        <a href="#">Affiliate{{trans('site/homepage.dashboard')}}</a>
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
                
                @if(Auth::check() && $student->hasRole('Instructor'))
                    <li>
                        <a href="{{ action('CoursesController@myCourses') }}">{{trans('site/homepage.teach')}}</a>
                    </li>
                @endif
            </ul>
            <div class="top-profile-info">          
                <span class="profile-level">12</span>
                <div class="profile-thumbnail">
                    <?php
                    if( Auth::check() ) Auth::user()->load('roles', 'profiles');
                    ?>
                    @if(Auth::check() && Auth::user()->hasRole('Instructor') && Instructor::find(Auth::user()->id)->profile!=null )
                    <img style="height: 30px; width: 30px; border-radius: 30px;" 
                             src="{{ cloudfrontUrl( Instructor::find(Auth::user()->id)->profile->photo ) }}" alt="">
                    @elseif(Auth::check() && Auth::user()->hasRole('Affiliate') && LTCAffiliate::find(Auth::user()->id)->profile != null)
                    <img style="height: 30px; width: 30px; border-radius: 30px;" 
                             src="{{ cloudfrontUrl( LTCAffiliate::find(Auth::user()->id)->profile->photo ) }}" alt="">
                    @elseif(Auth::check() &&  $student->profile )
                        <img style="height: 30px; width: 30px; border-radius: 30px;" 
                             src="{{ cloudfrontUrl( Student::find(Auth::user()->id)->profile->photo ) }}" alt="">
                       
                    @else
                        <img style="height: 30px; width: 30px; border-radius: 30px;" 
                             src="{{cloudfrontUrl("//s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg")}}" alt="">
                    @endif
                </div>
                <ul class="profile-name">
                    <li class="activate-dropdown">
                        <button aria-expanded="false" data-toggle="dropdown" 
                                class="btn btn-default dropdown-toggle" type="button" id="btnGroupDrop1">
                            <span class="greeting">{{trans('site/menus.hi')}}, </span> {{ Auth::user()->fullName() }} <i class="wa-chevron-down"></i>
                        </button>
                        <ul id="top-profile-dropdown" aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu">
                            <?php /*-- <li>
                                <a class="profile-button" href="{{ action('ProfileController@index') }}">{{trans('site/menus.profile')}}</a>
                            </li> */?>
                            <li>
                                <a class="courses-button" href="{{ action('StudentController@mycourses') }}">{{trans('site/menus.courses')}}</a>
                            </li>
                            <li>
                                <a class="settings-button" href="#">{{trans('site/menus.analytics')}}</a>
                            </li>
                            <li>
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
                                                @foreach( $student->grouppedNotifications( $received ) as $key => $notification)
                                                <tr><td>
                                                    <a href="{{ $notification['url'] }}">{{ $notification['text'] }}</a>
                                                    </td></tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </span>
                                @endif
                            </li>
                            <li>
                                <a class="settings-button" href="{{ action('ProfileController@settings')}}">{{trans('site/menus.settings')}}</a>
                            </li>
                            <li>
                                <a class="settings-button" href="{{ action('UsersController@logout') }}">{{trans('site/menus.logout')}}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        @else
            
            @if( Route::currentRouteAction()!='UsersController@login' && Route::currentRouteAction()!='UsersController@create')
            <style>
                .top-menu .main-logo {
                    display:block;
                }
            </style>
            @endif
            <ul class="logged-out visible-xs-block hidden-sm hidden-md hidden-lg">
                <li>
                    <!--<a href="{{ action('UsersController@login') }}" data-toggle="modal" data-target="#loginModal"> {{trans('general.login')}}</a> -->
                    <a href="" data-toggle="modal" data-target="#loginModal"> {{trans('general.login')}}</a> 
                </li>
                <li class="register-button">
                    <!--<a href="{{ action('UsersController@create') }}" data-toggle="modal" data-target="#registerModal"> {{ trans('general.register') }}</a>-->
                    <a href="" data-toggle="modal" data-target="#registerModal"> {{ trans('general.register') }}</a>
                </li>
            </ul>
            <div class="logged-out-header-search text-center">
            	<div class="clearfix inline-block">
                    <div class="activate-dropdown left relative">
                        <button aria-expanded="false" data-toggle="dropdown" 
                                class="catalogue-button dropdown-toggle" type="button" id="btnGroupDrop2">
                            <i class="wa-tiny-list"></i>
                            <em>{{trans('general.catalogue')}}</em>
                        </button>
                        <div id="catalogue-dropdown" aria-labelledby="btnGroupDrop2" role="menu" class="dropdown-menu">
                            <ul>
                                
                               
                                @foreach($categories as $category)
    
                                        @if($category->courseSubcategories)
                                            <li  class="dropdown-list"><a href="{{url('courses/category/' . $category->slug)}}">{{$category->name}}</a> <i class="wa-chevron-right"></i>
                                                <ul>
                                                    @foreach($category->courseSubcategories as $subCategory)
                                                        <li><a href="{{url('courses/category/' . $category->slug . '/' . $subCategory->slug)}}">{{$subCategory->name}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                        <li><a href="{{url('courses/category/' . $category->slug)}}">{{$category->name}}</a></li>
                                        @endif
    
                                @endforeach
                                <!--<li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li class="dropdown-list">
                                    Business & Marketing <i class="wa-chevron-right"></i>
                                    <ul>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>
                                        <li>
                                            <a href="#">Entrepreneurship</a>
                                        </li>                                
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li>
                                <li>
                                    <a href="#">Business & Marketing</a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                    <form>
                        <div>
                            <button><i class="wa-search"></i></button>
                            <input type="search" name="header-search" class="header-search" placeholder="Search...">
                        </div>
                    </form>
                </div>
            </div>
            <ul class="logged-out hidden-xs">
                <li>
                    <!--<a href="{{ action('UsersController@login') }}" data-toggle="modal" data-target="#loginModal"> {{trans('general.login')}}</a> -->
                    <a href="" data-toggle="modal" data-target="#loginModal"> {{trans('general.login')}}</a> 
                </li>
                <li class="register-button">
                    <!--<a href="{{ action('UsersController@create') }}" data-toggle="modal" data-target="#registerModal"> {{ trans('general.register') }}</a>-->
                    <a href="" data-toggle="modal" data-target="#registerModal"> {{ trans('general.register') }}</a>
                </li>
            </ul>
        @endif

    </div>
</div>
