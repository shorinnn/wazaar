@extends('layouts.default')
@section('content')
    <div class="container affiliate-dashboard dashboard  analytics-page">
        {{-- Filters --}}
        <div class="row-fluid">

            <div class="panel panel-default clearfix">
                <div class="panel-heading">
                    <h3 class="panel-title">{{trans('analytics.filters')}}</h3>
                </div>
                <div class="segmented-controls analytics-filter clearfix">
                    <div class="panel-body buttons-container clearfix">
                        <a class="segmented-buttons button-filter button-filter-daily" href="#" onclick="Analytics.sales('daily','','', this); return false;">{{trans('analytics.daily')}}</a>
                        <a class="segmented-buttons button-filter button-filter-week" href="#" onclick="Analytics.sales('week','','', this); return false;">{{trans('analytics.weekly')}}</a>
                        <a class="segmented-buttons button-filter button-filter-month" href="#" onclick="Analytics.sales('month','','', this); return false;">{{trans('analytics.monthly')}}</a>
                        <a class="segmented-buttons button-filter button-filter-alltime" href="#" onclick="Analytics.sales('alltime','','', this); return false;">{{trans('analytics.allTime')}}</a>
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
                            {{trans('analytics.totalSignUps')}} <span id="header-total-signups-student-instructors-frequency">{{trans('analytics.today')}}</span> </button>
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
                            {{trans('analytics.totalRevenues')}} <span id="header-total-revenues-frequency">{{trans('analytics.today')}}</span> </button>
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
                            {{trans('analytics.totalSignUpsAffs')}} <span id="header-total-signups-affiliates-frequency">{{trans('analytics.today')}}</span> </button>
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



    </div>
@stop

@section('extra_js')
    <script type="text/javascript" src="{{url('js/admin-analytics.js')}}"></script>
@stop