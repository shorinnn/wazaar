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
        <ul class="logged-in-top-menu">
            
            @if($student->hasRole('Affiliate'))
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
            <ul class="profile-name">
                <li class="activate-dropdown">
                    <button aria-expanded="false" data-toggle="dropdown" 
                            class="btn btn-default dropdown-toggle" type="button" id="btnGroupDrop1">
                        {{ Auth::user()->fullName() }}
                    </button>
                    <ul id="top-profile-dropdown" aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu">
                        <?php /*-- <li>
                            <a class="profile-button" href="{{ action('ProfileController@index') }}">{{trans('site/menus.profile')}}</a>
                        </li> */?>
                        <li>
                            <a class="courses-button" href="{{ action('StudentController@mycourses') }}">{{trans('site/menus.courses')}}</a>
                        </li>
                        <li>
                            <a class="settings-button" href="{{ action('ProfileController@settings')}}">{{trans('site/menus.settings')}}</a>
                        </li>
                        <li>
                            <a class="settings-button" href="{{ action('PrivateMessagesController@index') }}">{{trans('site/menus.messages')}}</a>
                        </li>
                        <li>
                            <a class="settings-button" href="{{ action('UsersController@logout') }}">{{trans('site/menus.logout')}}</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="profile-thumbnail">
                @if(Auth::user()->hasRole('Instructor'))
                <img style="height: 50px; width: 50px; border-radius: 50px;" 
                         src="{{ cloudfrontUrl( Instructor::find(Auth::user()->id)->profile->photo ) }}" alt="">
                @elseif(Auth::user()->hasRole('Instructor'))
                <img style="height: 50px; width: 50px; border-radius: 50px;" 
                         src="{{ cloudfrontUrl( ProductAffiliate::find(Auth::user()->id)->profile->photo ) }}" alt="">
                @elseif( $student->profile )
                    <img style="height: 50px; width: 50px; border-radius: 50px;" 
                         src="{{ cloudfrontUrl( Student::find(Auth::user()->id)->profile->photo ) }}" alt="">
                   
                @else
                    <img style="height: 50px; width: 50px; border-radius: 50px;" 
                         src="{{cloudfrontUrl("//s3-ap-northeast-1.amazonaws.com/profile_pictures/avatar-placeholder.jpg")}}" alt="">
                @endif
                <?php
                    $received = $student->receivedMessages()->unread( $student->id )->with('sender.profiles')->with('sender')->with('course')->get();
                ?>
                @if( $received->count() > 0)
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
            <div class="logged-out-header-search">
            	<form class="clearfix">
                	<button class="catalogue-button">
                    	<i class="fa fa-list"></i>
                    	{{trans('general.catalogue')}}
                    </button>
                    <div>
                    	<button><i class="fa fa-search"></i></button>
                        <input type="search" name="header-search" class="header-search" placeholder="Search...">
                    </div>
                </form>
            </div>
            <ul class="logged-out">
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
