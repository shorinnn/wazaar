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
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop2" type="button">
                                Top Courses Today</button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop2" role="menu" class="dropdown-menu">
                                <li>
                                    <a class="active" href="#">Today</a>
                                </li>
                                <li>
                                    <a class="#" href="#">This week</a>
                                </li>
                                <li>
                                    <a class="#" href="#">This month</a>
                                </li>
                                <li>
                                    <a class="#" href="#">All time</a>
                                </li>
                            </ul>
                        </div>
                        <ul>

                            @foreach($topCoursesToday['data'] as $key => $course)
                                <li>
                                    <a href="#">
                                        <span>{{$key+1}}.</span>
                                        {{$course['name']}}
                                        <em>¥{{number_format($course['total_purchase'],2)}}</em>
                                    </a>
                                </li>
                            @endforeach


                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div id="sales-today">
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop3" type="button">
                                Sales Today</button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop3" role="menu" class="dropdown-menu">
                                <li>
                                    <a class="active" href="#">Today</a>
                                </li>
                                <li>
                                    <a class="#" href="#">This week</a>
                                </li>
                                <li>
                                    <a class="#" href="#">This month</a>
                                </li>
                                <li>
                                    <a class="#" href="#">All time</a>
                                </li>
                            </ul>
                        </div>
                        <h2>¥{{number_format($weeklySales['sales_total'],2)}}
                            <span>(+20%)</span>
                        </h2>
                        <ul>
                            @foreach($weeklySales['data'] as $sale)
                            <li id="monday" class="clearfix">
                                <span>{{date('l',strtotime($sale['created_at']))}}</span>
                                <div>
                                    <span></span>
                                </div>
                                <em>¥{{number_format($sale['total_purchase'],2)}}</em>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div>
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop4" type="button">
                                Top Tracking Codes Today</button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop4" role="menu" class="dropdown-menu">
                                <li>
                                    <a class="active" href="#">Today</a>
                                </li>
                                <li>
                                    <a class="#" href="#">This week</a>
                                </li>
                                <li>
                                    <a class="#" href="#">This month</a>
                                </li>
                                <li>
                                    <a class="#" href="#">All time</a>
                                </li>
                            </ul>
                        </div>
                        <ul>
                            <li>
                                <a href="#">
                                    <span>1.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>2.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>3.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>4.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>5.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>6.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>7.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>8.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>9.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>10.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                        </ul>
                        <a href="#" class="view-all">View All</a>
                    </div>
                </div>
            </div>
            <div class="row top-activities">
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div>
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop5" type="button">
                                Top Converting Today</button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop5" role="menu" class="dropdown-menu">
                                <li>
                                    <a class="active" href="#">Today</a>
                                </li>
                                <li>
                                    <a class="#" href="#">This week</a>
                                </li>
                                <li>
                                    <a class="#" href="#">This month</a>
                                </li>
                                <li>
                                    <a class="#" href="#">All time</a>
                                </li>
                            </ul>
                        </div>
                        <ul>
                            <li>
                                <a href="#">
                                    <span>1.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>2.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>3.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
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
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop6" type="button">
                                Top Converting Today</button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop6" role="menu" class="dropdown-menu">
                                <li>
                                    <a class="active" href="#">Today</a>
                                </li>
                                <li>
                                    <a class="#" href="#">This week</a>
                                </li>
                                <li>
                                    <a class="#" href="#">This month</a>
                                </li>
                                <li>
                                    <a class="#" href="#">All time</a>
                                </li>
                            </ul>
                        </div>
                        <ul>
                            <li>
                                <a href="#">
                                    <span>1.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>2.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>3.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>4.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>5.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>6.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>7.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>8.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>9.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>10.</span>
                                    Javascript Fenzy
                                    <em>12,50%</em>
                                </a>
                            </li>
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