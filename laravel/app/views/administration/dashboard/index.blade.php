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
                    <div class="with-progress-bar">
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default" type="button">
                                {{trans('analytics.newUsers')}} <span id="header-user-stats-frequency">{{trans('analytics.today')}}</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop2" role="menu" class="dropdown-menu top-courses-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="AdminDashboard.UserStats('today', this); return false;">Today</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="AdminDashboard.UserStats('week', this); return false;">This week</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="AdminDashboard.UserStats('month', this); return false;">This month</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="AdminDashboard.UserStats('alltime', this); return false;">All time</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-user-stats">

                            {{$userCountView}}


                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div id="sales-today">
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop3" type="button">
                                {{trans('analytics.sales')}}(¥)  <span id="header-sales-frequency">{{trans('analytics.today')}}</span></button>
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
                            {{$salesTotalView}}
                        </div>

                    </div>
                </div>
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div class="with-progress-bar">
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default">{{trans('analytics.salesCount')}} <span id="header-sales-count-frequency">{{trans('analytics.today')}}</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop4" role="menu" class="dropdown-menu tracking-codes-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="AdminDashboard.SalesCount('daily', this); return false;">Today</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="AdminDashboard.SalesCount('week', this); return false;">This week</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="AdminDashboard.SalesCount('month', this); return false;">This month</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="AdminDashboard.SalesCount('alltime', this); return false;">All time</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-sales-count">
                            {{$salesCountView}}
                        </ul>
                    </div>
                </div>
            </div>

            <div class="top-affiliates-wrapper">
                @include('administration.dashboard.partials.user.topAffiliates')
            </div>

            <hr/>

            <div class="top-courses-free-wrapper">
                {{$topCoursesFreeView}}
            </div>

            <hr/>

            <div class="top-courses-purchased-wrapper">
                {{$topCoursesPaidView}}
            </div>
        </div>
    </div>

    </div>
@stop

@section('extra_css')
    <link rel="stylesheet" href="{{url('resources/select2-dist/select2.css')}}"/>
    <link rel="stylesheet" href="{{url('resources/select2-dist/select2-bootstrap.css')}}"/>
@stop

@section('extra_js')
    <script type="text/javascript" src="{{url('resources/select2-dist/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('js/analytics.js')}}"></script>
    <script type="text/javascript" src="{{url('js/admin.dashboard.js')}}"></script>
    <script src="{{url('resources/moment/min/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{url('resources/datetimepicker/src/js/bootstrap-datetimepicker.js')}}"></script>

    <script type="text/javascript">
        $(function(){
            $('#affiliateId').select2({
                placeholder: "Select an Affiliate"
            });

            $('#tcyCategoryId').select2({
                placeholder: "Select a Category"
            });

            $('#tcnCategoryId').select2({
                placeholder: "Select a Category"
            });

            $('#startDate, #tcyStartDate, #tcnStartDate').datetimepicker({format: 'MM/DD/YYYY'});
            $('#endDate, #tcyEndDate, #tcnEndDate').datetimepicker({format: 'MM/DD/YYYY'});
            $("#startDate").on("dp.change",function (e) {
                $('#endDate').data("DateTimePicker").minDate(e.date);
            });
            $("#endDate").on("dp.change",function (e) {
                $('#startDate').data("DateTimePicker").maxDate(e.date);
            });

            $("#tcyStartDate").on("dp.change",function (e) {
                $('#tcyEndDate').data("DateTimePicker").minDate(e.date);
            });
            $("#tcyEndDate").on("dp.change",function (e) {
                $('#tcyStartDate').data("DateTimePicker").maxDate(e.date);
            });

            $("#tcnStartDate").on("dp.change",function (e) {
                $('#tcnEndDate').data("DateTimePicker").minDate(e.date);
            });
            $("#tcnEndDate").on("dp.change",function (e) {
                $('#tcnStartDate').data("DateTimePicker").maxDate(e.date);
            });


            $('.pagination-top-affiliates .pagination a').on('click', function ($e){
                $e.preventDefault();
                console.log($(this).attr('href'));
            });


        });
    </script>
@stop