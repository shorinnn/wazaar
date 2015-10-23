@extends('layouts.default')
@section('content')
<style>
    .course-stats{
        border: 1px solid #E0E1E2;
        border-radius: 4px;
    }
    .stats-filter{
        background: #F5F5F5;
        padding: 5px 10px;
        border-bottom: 1px solid #E0E1E2;
    }
    .course-stats .course-summary-block{
        border:0px;
    }
    .stats-filter .large-button{
        padding-top: 7px;
        padding-bottom: 7px;
    }
    .filter-buttons .analytics-filter{
        float: none;
        text-align: center;
    }

    .filter-buttons .analytics-filter .buttons-container{
        float: none;
        margin: 0px auto;
        left: 50%;
        display: inline-block;
    }
</style>

    <div class="wrapper">
        <div class="container affiliate-dashboard dashboard  analytics-page">


            <h2 class="margin-top-10" style="padding-bottom:8px">{{trans('analytics.course')}}: {{$course->name}}</h2>
            <!-- <div class="row-fluid hide">
                <div class="panel panel-default clearfix">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{trans('analytics.filters')}}</h3>
                    </div>

                    <div class="segmented-controls analytics-filter clearfix">
                        <div class="panel-body buttons-container clearfix">
                            <!--<a class="segmented-buttons button-filter button-filter-daily" href="#" onclick="Analytics.SalesCount('daily', '',this); return false;">{{trans('analytics.daily')}}</a>->
                            <a class="segmented-buttons button-filter button-filter-daily" href="#" onclick="Analytics.SalesCount('daily', {{$course->id}},this); return false;">{{trans('analytics.daily')}}</a>
                            <a class="segmented-buttons button-filter button-filter-week" href="#" onclick="Analytics.SalesCount('week', {{$course->id}},this); return false;">{{trans('analytics.weekly')}}</a>
                            <a class="segmented-buttons button-filter button-filter-month" href="#" onclick="Analytics.SalesCount('month', {{$course->id}},this); return false;">{{trans('analytics.monthly')}}</a>
                            <a class="segmented-buttons button-filter button-filter-alltime" href="#" onclick="Analytics.SalesCount('alltime', {{$course->id}},this); return false;">{{trans('analytics.allTime')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default stats-panel">
                <div class="panel-heading">
                    <button type="button" class="pull-right blue-button large-button" style="margin-left: 10px" onclick="Analytics.ApplyCoursePageTableDateFilter(); return false;" >Apply Filter</button>
                    <div id="reportrange" class="pull-right text-center" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                        <span></span> <b class="caret"></b>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    
                    <div class="stats-block hide">
                        <div class="table-affiliates-wrapper">
                            <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            -->

            <div class="col-lg-12 course-stats no-padding">
                <div class="stats-filter">
                    <button type="button" class="pull-right blue-button large-button" style="margin-left: 10px" onclick="Analytics.ApplyCoursePageTableDateFilter(); return false;" >Apply Filter</button>
                    <div id="reportrange" class="pull-right text-center" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                        <span></span> <b class="caret"></b>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="stats-block">
                    <div class="table-stats-wrapper">
                        <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="filter-buttons">
                <div class="segmented-controls analytics-filter clearfix">
                    <div class="buttons-container">
                        <!--<a class="segmented-buttons button-filter button-filter-daily" href="#" onclick="Analytics.SalesCount('daily', '',this); return false;">{{trans('analytics.daily')}}</a>-->
                        <a class="segmented-buttons button-filter button-filter-daily" href="#" onclick="Analytics.SalesCount('daily', {{$course->id}},this); return false;">{{trans('analytics.daily')}}</a>
                        <a class="segmented-buttons button-filter button-filter-week" href="#" onclick="Analytics.SalesCount('week', {{$course->id}},this); return false;">{{trans('analytics.weekly')}}</a>
                        <a class="segmented-buttons button-filter button-filter-month" href="#" onclick="Analytics.SalesCount('month', {{$course->id}},this); return false;">{{trans('analytics.monthly')}}</a>
                        <a class="segmented-buttons button-filter button-filter-alltime" href="#" onclick="Analytics.SalesCount('alltime', {{$course->id}},this); return false;">{{trans('analytics.allTime')}}</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="top-activities">


                {{-- Total Sales in Yen --}}
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div class="stat-block">
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default" type="button">
                                <span id="header-sales-frequency">{{trans('analytics.today')}}</span>{{trans('analytics.sales')}} </button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop2" role="menu" class="dropdown-menu sales-dropdown">
                                <li>
                                    <a class="with-today" href="#" onclick="Analytics.Sales('daily',{{$course->id}},'',this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.Sales('week',{{$course->id}},'',this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.Sales('month',{{$course->id}},'',this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.Sales('alltime',{{$course->id}},'',this); return false;">{{trans('analytics.allTime')}}</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-sales">
                            {{$salesView}}
                        </ul>
                    </div>
                </div>
                {{-- // Total Sales in Yen --}}


                {{-- Number of Sales (Count) --}}
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div id="sales-today" class="stat-block">
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop3" type="button">
                                <span id="header-sales-count-frequency">{{trans('analytics.today')}}</span>{{trans('analytics.salesCount')}} </button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop3" role="menu" class="dropdown-menu sales-count-dropdown">
                                <li>
                                    <a class="active" href="#" onclick="Analytics.SalesCount('daily',{{$course->id}}, this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="" href="#" onclick="Analytics.SalesCount('week',{{$course->id}}, this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="" href="#" onclick="Analytics.SalesCount('month',{{$course->id}}, this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="" href="#" onclick="Analytics.SalesCount('alltime',{{$course->id}}, this); return false;">{{trans('analytics.alltime')}}</a>
                                </li>
                            </ul>
                        </div>

                        <div id="wrapper-sales-count">
                            {{$salesCountView}}
                        </div>

                    </div>
                </div>
                {{-- // Number of Sales (Count) --}}

                {{-- Top Tracking Codes
                <div class="col-md-4 col-sm-6 sol-xs-12 hidden">
                    <div class="stat-block">
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default">
                                <span id="header-tracking-codes-frequency">{{trans('analytics.today')}}</span>{{trans('analytics.topTrackingCodes')}} </button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop4" role="menu" class="dropdown-menu tracking-codes-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="Analytics.trackingSalesCodes('daily',{{$course->id}}, this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.trackingSalesCodes('week',{{$course->id}}, this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.trackingSalesCodes('month',{{$course->id}}, this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.trackingSalesCodes('alltime',{{$course->id}}, this); return false;">{{trans('analytics.allTime')}}</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-tracking-codes">
                            {{$trackingCodesView}}
                        </ul>


                    </div>
                </div> --}}
                {{-- // Top Tracking Codes --}}
                <div class="clearfix"></div>

            </div>

            
            <!-- <hr /> -->


            <div class="row-fluid hide">
                <div class="top-affiliates-table table-wrapper">
                    {{-- @include('administration.dashboard.partials.user.topAffiliates') --}}
                </div>
            </div>

            <!--
            <div class="row-fluid">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">{{trans('analytics.courseStats')}}</h3>
                  </div>
                  <div class="panel-body">
                      <div class="table-stats-wrapper">
                          <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
                      </div>
                  </div>
                </div>

            </div>

            <div class="row-fluid">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">{{trans('analytics.topAffiliates')}}</h3>
                  </div>
                  <div class="panel-body">
                      <div class="table-affiliates-wrapper">
                          <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
                      </div>
                  </div>
                </div>

            </div>
            -->
            <div id="ajax-loader-wrapper" class="hidden">
                <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
            </div>


        </div>
    </div>


@stop

@section('extra_css')
    <link rel="stylesheet" href="{{url('resources/select2-dist/select2.css')}}"/>
    <link rel="stylesheet" href="{{url('resources/select2-dist/select2-bootstrap.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('plugins/daterangepicker/daterangepicker.css')}}"/>
@stop

@section('extra_js')
    <script type="text/javascript" src="{{url('resources/select2-dist/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('js/instructor-analytics.js')}}"></script>
    <script type="text/javascript" src="{{url('js/admin.dashboard.js')}}"></script>
    <script src="{{url('resources/moment/min/moment.min.js')}}"></script>

    <script type="text/javascript" src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{url('js/instructor-analytics.js')}}"></script>
    <script type="text/javascript">
        $(function(){


            Analytics.CourseId = '{{$course->id}}';
            Analytics.InitCalendarFilter();
            Analytics.InitCoursePage();

            /*$('.courses-table-and-pagination-yes').on('click', '.pagination-top-courses ul a',function ($e){
                $e.preventDefault();

                var $loc = $(this).attr('href');

                $.post($loc, function ($resp){
                    $('.courses-table-and-pagination-yes').html($resp.html);
                },'json');
            });

            $('.courses-table-and-pagination-no').on('click', '.pagination-top-courses ul a',function ($e){
                $e.preventDefault();

                var $loc = $(this).attr('href');

                $.post($loc, function ($resp){
                    $('.courses-table-and-pagination-no').html($resp.html);
                },'json');
            });*/
        });
    </script>
@stop