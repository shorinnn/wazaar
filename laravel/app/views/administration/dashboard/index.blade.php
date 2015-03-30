@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <div class="container affiliate-dashboard dashboard">

            <div class="row">
                <div class="col-md-12">
                    <div class="header clearfix">
                        <img alt="" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/thumbnails/top-profile-thumbnail.png">
                        <p class="lead">Welcome Jerome</p>
                        <ul>
                            <li class="right-twenty-margin">
                                <a href="#" class="active">Dashboard</a>
                            </li>
                            <li class="right-twenty-margin">
                                <a href="#">Tracking codes</a>
                            </li>
                            <li>
                                <a href="#">Account Settings</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row top-activities">
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div>
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default" type="button">
                                {{trans('analytics.newUsers')}} <span id="header-top-courses-frequency">{{trans('analytics.today')}}</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop2" role="menu" class="dropdown-menu top-courses-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="Analytics.topCourses('daily','', this); return false;">Today</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.topCourses('week','', this); return false;">This week</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.topCourses('month','', this); return false;">This month</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.topCourses('alltime','', this); return false;">All time</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-top-courses">

                            {{$userCountView}}


                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div id="sales-today">
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop3" type="button">
                                {{trans('analytics.sales')}} /  <span id="header-sales-frequency">{{trans('analytics.today')}}</span></button>
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
                            {{@$salesView}}
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
                                    <a class="active with-today" href="#" onclick="Analytics.trackingSalesCodes('daily',0, this); return false;">Today</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.trackingSalesCodes('week',0, this); return false;">This week</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.trackingSalesCodes('month',0, this); return false;">This month</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.trackingSalesCodes('alltime',0, this); return false;">All time</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-tracking-codes">
                            {{@$trackingCodesSalesView}}
                        </ul>


                    </div>
                </div>
            </div>


        </div>
    </div>

    </div>
@stop

@section('extra_js')
    <script type="text/javascript" src="{{url('js/analytics.js')}}"></script>
@stop