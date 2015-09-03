@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <div class="container affiliate-dashboard dashboard">

                    @if(Auth::user()->is_super_vip == 'yes')
                        <div class="row">
                            <div class="col-md-12">
    <!--                        <div class="row welcome-message-wrap">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">-->
                                        <div class="supervip-affiliate-link">
                                        <div class="row">
                                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/supervip-badge.png" class="supervip-badge img-responsive">
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                                                <h1>アフィエイト２ティアの募集はこちらのリンクをお使いください！</h1>
                                                <?php
                                                $date = new DateTime();
                                                $date->setTimezone(new DateTimeZone('Asia/Tokyo'));
                                                $now = strtotime( $date->format('Y-m-d H:i:s') ) ;
                                                $show_on = strtotime( '2015-09-01 17:45:00' );
                                                ?>
                                                @if( $now > $show_on)
                                                    <input type="text" readonly="readonly" value="{{ action('AffiliateController@create' )}}?stai={{ Auth::user()->affiliate_id }}">
                                                @else
                                                    <input type="text" readonly="readonly" value="９月1日（火）の18時以降にリンクが表示されます。" />
                                                @endif
                                            </div>
                                        </div>
                                        </div>
    <!--                            </div>
                            </div>-->
                            </div>
                        </div>
                    @elseif(Auth::user()->is_vip == 'yes')
                        <div class="row">
                            <div class="col-md-12">
    <!--                        <div class="row welcome-message-wrap">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">-->
                                        <div class="supervip-affiliate-link">
                                        <div class="row">
                                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                                <img src="{{ url('images/VIP_badge.png') }}" class="supervip-badge img-responsive">
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                                                <h1>アフィエイト２ティアの募集はこちらのリンクをお使いください！</h1>
                                                <?php
                                                $date = new DateTime();
                                                $date->setTimezone(new DateTimeZone('Asia/Tokyo'));
                                                $now = strtotime( $date->format('Y-m-d H:i:s') ) ;
                                                $show_on = strtotime( '2015-09-04 17:45:00' );
                                                ?>
                                                @if( $now > $show_on)
                                                    <input type="text" readonly="readonly" value="{{ action('AffiliateController@create' )}}?stai={{ Auth::user()->affiliate_id }}">
                                                @else
                                                    <input type="text" readonly="readonly" value="９月4日（金）の18時以降にリンクが表示されます。" />
                                                @endif
                                            </div>
                                        </div>
                                        </div>
    <!--                            </div>
                            </div>-->
                            </div>
                        </div>
                    @else
                    
                    <!--<div class="row">-->
                    <div class="row welcome-message-wrap">&nbsp;
                        @if(Auth::user()->is_super_vip == 'no' &&  Auth::user()->sawLetter != 1)
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert" role='alert' style="margin-bottom:0px;">
                                    {{ View::make('affiliate.welcome-letter') }}
                            </div> 
                        @endif
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert">
                            <div class="affiliate-welcome-footer">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <p>{{ trans('general.affiliate-ref-link') }}</p>
                                    </div>
                                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                                         <?php
                                            $date = new DateTime();
                                            $date->setTimezone(new DateTimeZone('Asia/Tokyo'));
                                            $now = strtotime( $date->format('Y-m-d H:i:s') ) ;
                                            $show_on = strtotime( '2015-09-10 17:45:00' );
                                        ?>
                                        @if( $now > $show_on)
                                            <input type="text" readonly="" value="{{ action('AffiliateController@create' )}}?stai={{ Auth::user()->affiliate_id }}" />
                                        @else
                                            <input type="text" readonly="" value="９月10日（木）にリンクが表示されます。" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!--</div>-->
                @endif
                
            <div class="row top-activities">
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div class="with-progress-bar">
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default">
                                {{trans('analytics.ltcRegistrations')}} <span id="header-ltc-registrations-frequency">{{trans('analytics.today')}}</span> </button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop6" role="menu" class="dropdown-menu tracking-code-conversions-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="Analytics.ltcRegistrations('daily',this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.ltcRegistrations('week', this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.ltcRegistrations('month', this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.ltcRegistrations('alltime', this); return false;">{{trans('analytics.allTime')}}</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-ltc-registrations">
                            {{$ltcRegistrationsView}}
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div id="sales-today">
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop3" type="button">
                                {{trans('analytics.sales')}} <span id="header-sales-frequency">{{trans('analytics.today')}}</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop3" role="menu" class="dropdown-menu sales-dropdown">
                                <li>
                                    <a class="active" href="#" onclick="Analytics.sales('daily','','', this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="" href="#" onclick="Analytics.sales('week','','', this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="" href="#" onclick="Analytics.sales('month','','', this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="" href="#" onclick="Analytics.sales('alltime','','', this); return false;">{{trans('analytics.alltime')}}</a>
                                </li>
                            </ul>
                        </div>

                        <div id="wrapper-sales">
                            {{$salesView}}
                        </div>

                    </div>
                </div>
                
                {{-- 2 Tier Signups --}}
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div class="with-progress-bar">
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default">
                                {{trans('analytics.2TierSignups')}} <span id="header-second-tier-registrations-frequency">{{trans('analytics.today')}}</span> </button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop6" role="menu" class="dropdown-menu tracking-code-conversions-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="Analytics.twoTierRegistrations('daily',this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.twoTierRegistrations('week', this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.twoTierRegistrations('month', this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.twoTierRegistrations('alltime', this); return false;">{{trans('analytics.allTime')}}</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-second-tier-registrations">
                            {{$secondTierRegistrationsView}}
                        </ul>
                    </div>
                </div>

                {{-- // 2 Tier Signups --}}
                
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div>
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default" type="button">
                                {{trans('analytics.topCourses')}} <span id="header-top-courses-frequency">{{trans('analytics.today')}}</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop2" role="menu" class="dropdown-menu top-courses-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="Analytics.topCourses('daily','', this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.topCourses('week','', this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.topCourses('month','', this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.topCourses('alltime','', this); return false;">{{trans('analytics.allTime')}}</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-top-courses">
                            {{$topCoursesView}}
                        </ul>
                    </div>
                </div>
                
                {{-- LTC Earnings --}}
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div class="with-progress-bar">
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default">
                                {{trans('analytics.ltcEarnings')}} <span id="header-ltc-earnings-frequency">{{trans('analytics.today')}}</span> </button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop6" role="menu" class="dropdown-menu ltc-earnings-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="Analytics.ltcEarnings('daily',this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.ltcEarnings('week', this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.ltcEarnings('month', this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.ltcEarnings('alltime', this); return false;">{{trans('analytics.allTime')}}</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-ltc-earnings">
                            {{$ltcEarningsView}}
                        </ul>
                    </div>
                </div>

                {{-- // LTC Earnings --}}
                
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div>
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default">
                                {{trans('analytics.topTrackingCodes')}} <span id="header-tracking-codes-frequency">{{trans('analytics.today')}}</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop4" role="menu" class="dropdown-menu tracking-codes-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="Analytics.trackingSalesCodes('daily',0, this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.trackingSalesCodes('week',0, this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.trackingSalesCodes('month',0, this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.trackingSalesCodes('alltime',0, this); return false;">{{trans('analytics.allTime')}}</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-tracking-codes">
                            {{$trackingCodesSalesView}}
                        </ul>


                    </div>
                </div>
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div>
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default">
                                {{trans('analytics.topConvertingCourses')}} <span id="header-course-conversions-frequency">{{trans('analytics.today')}}</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop5" role="menu" class="dropdown-menu course-conversions-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="Analytics.courseConversions('daily', 0,this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.courseConversions('week', 0,this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.courseConversions('month', 0,this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.courseConversions('alltime', 0,this); return false;">{{trans('analytics.allTime')}}</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-course-conversions">
                           {{$courseConversionView}}

                        </ul>
                    </div>
                </div>

                

                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div>
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default">
                                {{trans('analytics.trackingCodeConverting')}} <span id="header-tracking-code-conversions-frequency">{{trans('analytics.today')}}</span> </button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop6" role="menu" class="dropdown-menu tracking-code-conversions-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="Analytics.trackingCodeConversions('daily',0, this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.trackingCodeConversions('week', 0,this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.trackingCodeConversions('month', 0,this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.trackingCodeConversions('alltime', 0,this); return false;">{{trans('analytics.allTime')}}</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-tracking-code-conversions">
                           {{$trackingCodeConversionView}}
                        </ul>
                    </div>
                </div>

                


                

            </div>
            <div id="ajax-loader-wrapper" class="hidden">
                <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
            </div>

            </div>
        </div>

    </div>
@stop

@section('extra_js')
    <script type="text/javascript" src="{{url('js/analytics.js')}}"></script>
    <script>
        function hideLetter(){
            $.get('{{action("AffiliateController@hideLetter")}}');
        }
    </script>
@stop