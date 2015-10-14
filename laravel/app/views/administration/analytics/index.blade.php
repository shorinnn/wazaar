@extends('layouts.default')
@section('page_title') 受注管理 - Wazaar @stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class='icon admin-page-title'>{{ trans('administration.analytics.page-title' )}}</h1>
        </div>
    </div>
    <div class="container affiliate-dashboard dashboard  analytics-page">
        {{-- Filters --}}
        <div class="row-fluid">

            <div class="panel panel-default clearfix">
                <div class="panel-heading">
                    <h3 class="panel-title">{{trans('analytics.filters')}}</h3>
                </div>
                <div class="segmented-controls analytics-filter clearfix">
                    <div class="panel-body buttons-container clearfix">
                        <a class="segmented-buttons button-filter button-filter-today btn-primary" href="#" onclick="Analytics.ApplyFilter('today'); return false;">{{trans('analytics.daily')}}</a>
                        <a class="segmented-buttons button-filter button-filter-week" href="#" onclick="Analytics.ApplyFilter('week'); return false;">{{trans('analytics.weekly')}}</a>
                        <a class="segmented-buttons button-filter button-filter-month" href="#" onclick="Analytics.ApplyFilter('month'); return false;">{{trans('analytics.monthly')}}</a>
                        {{--<a class="segmented-buttons button-filter button-filter-alltime" href="#" onclick="Analytics.ApplyFilter('alltime'); return false;">{{trans('analytics.allTime')}}</a>--}}
                    </div>
                </div>
            </div>
        </div>
        {{-- //Filters --}}

        {{-- Boxes --}}
        <div class="row top-activities">

            <div class="col-md-4 col-sm-6 col-xs-12">{{-- Total Signups (Students & Instructors) --}}
                <div class="with-progress-bar stat-block">
                    <div class="dropdown-wrapper">
                        <button class="btn btn-default">
                            <span id="header-total-signups-student-instructors-frequency">{{trans('analytics.today')}}</span>{{trans('analytics.totalSignUps')}}  </button>
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
                    <ul id="wrapper-total-signups-student-instructors">
                        <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
                    </ul>
                </div>
            </div>




            <div class="col-md-4 col-sm-6 col-xs-12">{{-- Total Revenues --}}
                <div class="with-progress-bar stat-block">
                    <div class="dropdown-wrapper">
                        <button class="btn btn-default">
                            <span id="header-total-revenues-frequency">{{trans('analytics.today')}}</span>{{trans('analytics.totalRevenues')}}  </button>
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
                    <ul id="wrapper-total-revenues">
                        <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
                    </ul>
                </div>
            </div>



            <div class="col-md-4 col-sm-6 col-xs-12"> {{-- Total Signups (Affiliates) --}}
                <div class="with-progress-bar stat-block">
                    <div class="dropdown-wrapper">
                        <button class="btn btn-default">
                            <span id="header-total-signups-affiliates-frequency">{{trans('analytics.today')}}</span>{{trans('analytics.totalSignUpsAffs')}}  </button>
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
                    <ul id="wrapper-total-signups-affiliates">
                        <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
                    </ul>
                </div>
            </div>

        </div>
        {{-- //Boxes --}}

        <hr/>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{trans('analytics.tableFilter')}}</h3>
            </div>
            <div class="panel-body">
                <div id="reportrange" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 50%">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                    <span></span> <b class="caret"></b>
                </div>

                <button class="btn btn-success" onclick="Analytics.ApplyTableDateFilter(); return false;" style="margin-left: 10px">{{trans('analytics.applyFilter')}}</button>
            </div>
        </div>
        <div class="row-fluid">
            @include('administration.analytics.tables')
        </div>
    </div>




    <div id="ajax-loader-wrapper" class="hidden"><div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div></div>
@stop

@section('extra_css')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/latest/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{url('plugins/daterangepicker/daterangepicker.css')}}"/>
@stop
@section('extra_js')
    <script type="text/javascript" src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{url('js/admin-analytics.js')}}"></script>
@stop