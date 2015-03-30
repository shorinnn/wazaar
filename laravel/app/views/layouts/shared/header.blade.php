<div class="row">
    <div class="top-menu clearfix">
        <a href="{{url('/')}}" class="main-logo"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" 
                                           class="img-responsive" alt=""></a>
        @if(Auth::check())
        <?php
        $student = Student::find(Auth::user()->id);
        ?>
        <ul>
            <li>
                <a href="{{url('dashboard')}}">{{trans('site/homepage.dashboard')}}</a>
            </li>
            @if($student->hasRole('Affiliate'))
                <li>
                    <a href="{{url('dashboard')}}">Affiliate{{trans('site/homepage.dashboard')}}</a>
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
        </ul>
    </div>
    <div class="top-profile-info">          
        <span class="profile-level">12</span>
        <ul class="profile-name">
            <li class="activate-dropdown">
                <button aria-expanded="false" data-toggle="dropdown" 
                        class="btn btn-default dropdown-toggle" type="button" id="btnGroupDrop1">
                    {{ username() }}
                </button>
                <ul id="top-profile-dropdown" aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu">
                    <li>
                        <a class="profile-button" href="/profile">{{trans('site/menus.profile')}}</a>
                    </li>
                    <li>
                        <a class="courses-button" href="{{ action('StudentController@mycourses') }}">{{trans('site/menus.courses')}}</a>
                    </li>
                    <li>
                        <a class="settings-button" href="#">{{trans('site/menus.settings')}}</a>
                    </li>
                    <li>
                        <a class="settings-button" href="{{ action('PrivateMessagesController@index') }}">{{trans('site/menus.messages')}}</a>
                    </li>
                    <li>
                        <a class="settings-button" href="{{url('logout')}}">{{trans('site/menus.logout')}}</a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="profile-thumbnail">
            <!--<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/thumbnails/top-profile-thumbnail.png" alt="">-->
            @if( $student->profile )
                <img style="height: 50px; width: 50px; border-radius: 50px;" 
                     src="{{ Student::find(Auth::user()->id)->profile->photo }}" alt="">
               
            @else
                <img style="height: 50px; width: 50px; border-radius: 50px;" 
                     src="//s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar-placeholder.jpg" alt="">
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
        
        
        <ul>
            <li>
                <a href="{{url('login')}}">Login</a> 
            </li>
            <li>
                <a href="{{url('register')}}">Register</a>
            </li>
        </ul>
    @endif
</div>