<div class="row">
    <div class="top-menu clearfix">
        <a href="{{ action('SiteController@index') }}" class="main-logo">
            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" 
           class="img-responsive" alt=""></a>
        @if(Auth::check())
        <?php
        $student = Student::find(Auth::user()->id);
        ?>
        <!--<ul class="logged-in-top-menu">
            
            @if($student->hasRole('Affiliate'))
                <li>
                    <a href="#">Affiliate{{trans('site/homepage.dashboard')}}</a>
                </li>
            @endif
            <li>
                <a href="#">{{trans('site/homepage.store')}}</a>
            </li>
            <li>
                <a href="#">{{trans('site/homepage.learn')}}</a>
            </li>
            <li>
                <a href="#">{{trans('site/homepage.expert')}}</a>
            </li>
        </ul>-->
        <!--<nav class="navbar navbar-default">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>          
            <!--<span class="profile-level">12</span>-->
            <!--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="activate-dropdown nav navbar-nav">
                    <li>
                        <a class="profile-button" href="{{ action('ProfileController@index') }}">{{trans('site/menus.profile')}}</a>
                    </li>
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
            </div>-->
            <!--<div class="profile-thumbnail">
                @if( $student->profile )
                    <img style="height: 50px; width: 50px; border-radius: 50px;" 
                         src="{{ cloudfrontUrl( Student::find(Auth::user()->id)->profile->photo ) }}" alt="">
                   
                @else
                    <img style="height: 50px; width: 50px; border-radius: 50px;" 
                         src="../../../layouts/shared/{{cloudfrontUrl("//s3-ap-northeast-1.amazonaws.com/profile_pictures/avatar-placeholder.jpg")}}" alt="">
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
            </div>-->
        </nav>
        @else
            
            
            
            @if( Route::currentRouteAction()!='UsersController@login' && Route::currentRouteAction()!='UsersController@create')
            <style>
                .top-menu .main-logo {
                    display:none;
                }
            </style>
            @endif
            
            
            <ul class="logged-out">
                <li>
                    <a href="{{ action('UsersController@login') }}"> {{trans('general.login')}}</a> 
                </li>
                <li class="register-button">
                    <a href="{{ action('UsersController@create') }}"> {{ trans('general.register') }}</a>
                </li>
            </ul>
        @endif

    </div>
</div>