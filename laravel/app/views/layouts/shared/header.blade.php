<div class="row">
    <div class="top-menu clearfix">
        <a href="#" class="main-logo"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" 
                                           class="img-responsive" alt=""></a>
        @if(Auth::check())
        <ul>
            <li>
                <a href="#">{{trans('site/homepage.dashboard')}}</a>
            </li>
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
                        <a class="profile-button" href="#">{{trans('site/homepage.profile')}}</a>
                    </li>
                    <li>
                        <a class="courses-button" href="#">{{trans('site/homepage.courses')}}</a>
                    </li>
                    <li>
                        <a class="settings-button" href="#">{{trans('site/homepage.settings')}}</a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="profile-thumbnail">
            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/thumbnails/top-profile-thumbnail.png" alt="">
            <span class="notification-number">3</span>
        </div>
    </div>
    @endif
</div>