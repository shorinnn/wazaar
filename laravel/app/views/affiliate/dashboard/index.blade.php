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
                                {{trans('analytics.topCourses')}} <span id="header-top-courses-frequency">{{trans('analytics.today')}}</span></button>
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
                                    <a class="active with-today" href="#" onclick="Analytics.courseConversions('daily', 0,this); return false;">Today</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.courseConversions('week', 0,this); return false;">This week</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.courseConversions('month', 0,this); return false;">This month</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.courseConversions('alltime', 0,this); return false;">All time</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-course-conversions">
                           {{$courseConversionView}}

                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div id="customize">
                        <a href="#">
                            <span>Customize</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div>
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default">
                                {{trans('analytics.trackingCodeConverting')}} <span id="header-tracking-code-conversions-frequency">{{trans('analytics.today')}}</span> </button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop6" role="menu" class="dropdown-menu tracking-code-conversions-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="Analytics.trackingCodeConversions('daily',0, this); return false;">Today</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.trackingCodeConversions('week', 0,this); return false;">This week</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.trackingCodeConversions('month', 0,this); return false;">This month</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.trackingCodeConversions('alltime', 0,this); return false;">All time</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-tracking-code-conversions">
                           {{$trackingCodeConversionView}}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="white-row">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="upcoming-courses-header">
                        <a href="#" class="left-arrow"></a>
                        <h3>Upcoming Courses</h3>
                        <a href="#" class="right-arrow"></a>
                    </div>
                </div>
            </div>
            <div class="row upcoming-courses">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="courses course-1">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/courses-sample-img.jpg"
                             class="img-responsive">
                        <h4>Javascript Primer</h4>
                        <span>00:12:15</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="courses course-2">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/courses-sample-img.jpg"
                             class="img-responsive">
                        <h4>Javascript Primer</h4>
                        <span>00:12:15</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="courses course-3">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/courses-sample-img.jpg"
                             class="img-responsive">
                        <h4>Javascript Primer</h4>
                        <span>00:12:15</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="courses course-4">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/courses-sample-img.jpg"
                             class="img-responsive">
                        <h4>Javascript Primer</h4>
                        <span>00:12:15</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="weekly-topsellers-header">
                        <a href="#" class="left-arrow"></a>
                        <h3>Top sellers this week <small> (in your categories)</small></h3>
                        <a href="#" class="right-arrow"></a>
                    </div>
                </div>
            </div>
            <div class="row weekly-topsellers">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="courses course-1">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/courses-sample-img.jpg"
                             class="img-responsive">
                        <h4>Javascript Primer</h4>
                        <span>00:12:15</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="courses course-2">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/courses-sample-img.jpg"
                             class="img-responsive">
                        <h4>Javascript Primer</h4>
                        <span>00:12:15</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="courses course-3">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/courses-sample-img.jpg"
                             class="img-responsive">
                        <h4>Javascript Primer</h4>
                        <span>00:12:15</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="courses course-4">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/courses-sample-img.jpg"
                             class="img-responsive">
                        <h4>Javascript Primer</h4>
                        <span>00:12:15</span>
                    </div>
                </div>
            </div>
        </div>
        <section class="container-fluid become-an-instructor affiliate">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h1>BECOME</h1>
                        <h2>AN INSTRUCTOR</h2>
                        <a href="{{ action('InstructorsController@become') }}"><span>{{trans('site/homepage.get-started')}}</span></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop

@section('extra_js')
    <script type="text/javascript" src="{{url('js/analytics.js')}}"></script>
@stop