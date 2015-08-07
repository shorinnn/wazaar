@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <div class="container affiliate-dashboard dashboard  analytics-page">

            <div class="row">
                <div class="col-md-12">
                    <div class="header clearfix">
                        <img alt="" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/thumbnails/top-profile-thumbnail.png">
                        <p class="lead">Welcome Jerome</p>
                        <ul>
                            <li class="right-twenty-margin">
                                <a href="#" class="active">Dashboard</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row top-activities">
                {{-- Total Sales in Yen --}}
                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div>
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default" type="button">
                                {{trans('analytics.sales')}} <span id="header-sales-frequency">{{trans('analytics.today')}}</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop2" role="menu" class="dropdown-menu sales-dropdown">
                                <li>
                                    <a class="with-today" href="#" onclick="Analytics.Sales('daily','','',this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.Sales('week','','',this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.Sales('month','','',this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.Sales('alltime','','',this); return false;">{{trans('analytics.allTime')}}</a>
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
                    <div id="sales-today">
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop3" type="button">
                                {{trans('analytics.salesCount')}} <span id="header-sales-count-frequency">{{trans('analytics.today')}}</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop3" role="menu" class="dropdown-menu sales-count-dropdown">
                                <li>
                                    <a class="active" href="#" onclick="Analytics.SalesCount('daily', this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="" href="#" onclick="Analytics.SalesCount('week', this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="" href="#" onclick="Analytics.SalesCount('month', this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="" href="#" onclick="Analytics.SalesCount('alltime', this); return false;">{{trans('analytics.alltime')}}</a>
                                </li>
                            </ul>
                        </div>

                        <div id="wrapper-sales-count">
                            {{$salesCountView}}
                        </div>

                    </div>
                </div>
                {{-- // Number of Sales (Count) --}}

                {{-- Top Tracking Codes --}}
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
                            {{$trackingCodesView}}
                        </ul>


                    </div>
                </div>
                {{-- // Top Tracking Codes --}}


            </div>


            <div class="row">
                <div class="top-affiliates-table table-wrapper">
                    <div class="table-header clearfix">
                        <h1 class="left">Top Affiliates</h1>
                        <form class="right">
                            <div class="search-affiliates">
                                <input type="search" placeholder="Search affiliates ..." />
                                <button><i class="wa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div>
                        {{$topAffiliates}}
                    </div>
                </div>
            </div>



            <div id="ajax-loader-wrapper" class="hidden">
                <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
            </div>

        </div>
    </div>


@stop

@section('extra_js')
    <script type="text/javascript" src="{{url('js/instructor-analytics.js')}}"></script>
@stop