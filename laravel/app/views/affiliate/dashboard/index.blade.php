@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <div class="container affiliate-dashboard dashboard">

            <div class="row">
                <div class="col-md-12">
                    <div class="header clearfix">
                        <div class="row">
                            <div class="col-lg-3"> 
                                {{ trans('general.affiliate-ref-link') }} </div>
                            <div class="col-lg-9">
                                <input type="text" readonly="" 
                                             value="{{ action('AffiliateController@create' )}}?stai={{ Auth::user()->affiliate_id }}" />
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="row top-activities">
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
            </div>
            <div class="row top-activities">
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
@stop