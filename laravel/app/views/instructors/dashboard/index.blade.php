@extends('layouts.default')
@section('page_title') 販売管理 
@if( trim( Auth::user()->instructorNameOrCompany() ) != '')
    ({{ Auth::user()->instructorNameOrCompany() }}) 
@endif - Wazaar @stop
@section('content')
<style>
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
    <div class="wrapper clearfix">
        <div class="container affiliate-dashboard dashboard  analytics-page">

            <h1>
                販売管理 
                @if( trim( Auth::user()->instructorNameOrCompany() ) != '')
                    ({{ Auth::user()->instructorNameOrCompany() }})
                @endif
            </h1>

            {{-- Button Filters --}}
            <div class="row-fluid">
                <!-- <div class="panel panel-default clearfix">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{trans('analytics.filters')}}</h3>
                    </div>

                    <div class="segmented-controls analytics-filter clearfix">
                        <div class="panel-body buttons-container clearfix">
                            <!--<a class="segmented-buttons button-filter button-filter-daily" href="#" onclick="Analytics.SalesCount('daily', '',this); return false;">{{trans('analytics.daily')}}</a>->
                            <a class="segmented-buttons button-filter button-filter-daily" href="#" onclick="Analytics.SalesCount('today', '',this); return false;">{{trans('analytics.daily')}}</a>
                            <a class="segmented-buttons button-filter button-filter-week" href="#" onclick="Analytics.SalesCount('week', '',this); return false;">{{trans('analytics.weekly')}}</a>
                            <a class="segmented-buttons button-filter button-filter-month" href="#" onclick="Analytics.SalesCount('month', '',this); return false;">{{trans('analytics.monthly')}}</a>
                            <a class="segmented-buttons button-filter button-filter-alltime" href="#" onclick="Analytics.SalesCount('alltime', '',this); return false;">{{trans('analytics.allTime')}}</a>
                        </div>

                        <!--<div class="panel-body">
                            <a class="btn btn-primary button-filter button-filter-daily" href="#" onclick="Analytics.SalesCount('today', '',this); return false;">{{trans('analytics.daily')}}</a>
                            <a class="btn btn-default button-filter button-filter-week" href="#" onclick="Analytics.SalesCount('week', '',this); return false;">{{trans('analytics.weekly')}}</a>
                            <a class="btn btn-default button-filter button-filter-month" href="#" onclick="Analytics.SalesCount('month', '',this); return false;">{{trans('analytics.monthly')}}</a>
                            <a class="btn btn-default button-filter button-filter-alltime" href="#" onclick="Analytics.SalesCount('alltime', '',this); return false;">{{trans('analytics.allTime')}}</a>
                        </div>->
                    </div>
                </div>
                -->

                <div class="filter-buttons">
                    <div class="segmented-controls analytics-filter clearfix">
                        <div class="buttons-container">
                            <a class="segmented-buttons button-filter button-filter-daily" href="#" onclick="Analytics.SalesCount('today', '',this); return false;">{{trans('analytics.daily')}}</a>
                            <a class="segmented-buttons button-filter button-filter-week" href="#" onclick="Analytics.SalesCount('week', '',this); return false;">{{trans('analytics.weekly')}}</a>
                            <a class="segmented-buttons button-filter button-filter-month" href="#" onclick="Analytics.SalesCount('month', '',this); return false;">{{trans('analytics.monthly')}}</a>
                            <a class="segmented-buttons button-filter button-filter-alltime" href="#" onclick="Analytics.SalesCount('alltime', '',this); return false;">{{trans('analytics.allTime')}}</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="top-activities">
                    {{-- Total Sales in Yen --}}
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="stat-block">
                            <div class="dropdown-wrapper">
                                <button class="btn btn-default" type="button">
                                    <span id="header-sales-frequency">{{trans('analytics.today')}}</span>{{trans('instructors/analytics.sales-revenue')}} </button>
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
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div id="sales-today" class="stat-block">
                            <div class="dropdown-wrapper">
                                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop3" type="button">
                                    <span id="header-sales-count-frequency">{{trans('analytics.today')}}</span>{{trans('instructors/analytics.unit-sales')}} </button>
                                <ul id="activities-dropdown" aria-labelledby="btnGroupDrop3" role="menu" class="dropdown-menu sales-count-dropdown">
                                    <li>
                                        <a class="active" href="#" onclick="Analytics.SalesCount('daily', '',this); return false;">{{trans('analytics.today')}}</a>
                                    </li>
                                    <li>
                                        <a class="" href="#" onclick="Analytics.SalesCount('week', '',this); return false;">{{trans('analytics.thisWeek')}}</a>
                                    </li>
                                    <li>
                                        <a class="" href="#" onclick="Analytics.SalesCount('month', '',this); return false;">{{trans('analytics.thisMonth')}}</a>
                                    </li>
                                    <li>
                                        <a class="" href="#" onclick="Analytics.SalesCount('alltime', '',this); return false;">{{trans('analytics.alltime')}}</a>
                                    </li>
                                </ul>
                            </div>

                            <div id="wrapper-sales-count">
                                {{$salesCountView}}
                            </div>

                        </div>
                    </div>
                    {{-- // Number of Sales (Count) --}}

                    @if (Auth::user()->is_second_tier_instructor == 'yes')

                        {{-- Total Second Tier Sales in Yen --}}
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="stat-block">
                                <div class="dropdown-wrapper">
                                    <button class="btn btn-default" type="button">
                                        <span id="header-two-tier-sales-frequency">{{trans('analytics.today')}}</span>{{trans('analytics.twoTierSales')}} </button>
                                    <ul id="activities-dropdown" aria-labelledby="btnGroupDrop2" role="menu" class="dropdown-menu sales-dropdown">
                                        <li>
                                            <a class="with-today" href="#" onclick="Analytics.TwoTierSales('daily','','',this); return false;">{{trans('analytics.today')}}</a>
                                        </li>
                                        <li>
                                            <a class="with-weekly" href="#" onclick="Analytics.TwoTierSales('week','','',this); return false;">{{trans('analytics.thisWeek')}}</a>
                                        </li>
                                        <li>
                                            <a class="with-monthly" href="#" onclick="Analytics.TwoTierSales('month','','',this); return false;">{{trans('analytics.thisMonth')}}</a>
                                        </li>
                                        <li>
                                            <a class="with-alltime" href="#" onclick="Analytics.TwoTierSales('alltime','','',this); return false;">{{trans('analytics.allTime')}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <ul id="wrapper-two-tier-sales" class="analytics-box-wrapper">
                                    {{$secondTierSalesView}}
                                </ul>
                            </div>
                        </div>
                        {{-- // Total Second Tier Sales in Yen --}}
                    @endif


                    <div class="clearfix"></div>
                </div>


                <div class="row">
                    <div class="course-statistics-table table-wrapper" style="border:0px;">
                        @include('instructors.dashboard.partials.coursesTable')
                    </div>
                </div>





                <div id="ajax-loader-wrapper" class="hidden">
                    <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
                </div>

            </div>
        </div>


        @stop

        @section('extra_css')
            <link rel="stylesheet" href="{{url('resources/select2-dist/select2.css')}}"/>
            <link rel="stylesheet" href="{{url('resources/select2-dist/select2-bootstrap.css')}}"/>
            <link rel="stylesheet" href="{{url('resources/datetimepicker/build/css/bootstrap-datetimepicker.css')}}"/>
        @stop

        @section('extra_js')
            <script type="text/javascript" src="{{url('resources/select2-dist/select2.min.js')}}"></script>
            <script type="text/javascript" src="{{url('js/instructor-analytics.js')}}"></script>
            <script type="text/javascript" src="{{url('js/admin.dashboard.js')}}"></script>
            <script src="{{url('resources/moment/min/moment.min.js')}}"></script>

            <script type="text/javascript" src="{{url('resources/datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
            <!--<script type="text/javascript" src="{{url('plugins/datepicker/js/bootstrap-datepicker.js')}}"></script>-->

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


                    $('#startDate, #startDate-yes, #startDate-no').datetimepicker({format: 'MM/DD/YYYY'});
                    $('#endDate, #endDate-yes, #endDate-no').datetimepicker({format: 'MM/DD/YYYY'});

                    $("#startDate").on("dp.change",function (e) {
                        $('#endDate').data("DateTimePicker").minDate(e.date);
                    });
                    $("#endDate").on("dp.change",function (e) {
                        $('#startDate').data("DateTimePicker").maxDate(e.date);
                    });

                    $("#startDate-yes").on("dp.change",function (e) {
                        $('#endDate-yes').data("DateTimePicker").minDate(e.date);
                    });
                    $("#endDate-yes").on("dp.change",function (e) {
                        $('#startDate-yes').data("DateTimePicker").maxDate(e.date);
                    });

                    $("#startDate-no").on("dp.change",function (e) {
                        $('#endDate-no').data("DateTimePicker").minDate(e.date);
                    });
                    $("#endDate-no").on("dp.change",function (e) {
                        $('#startDate-no').data("DateTimePicker").maxDate(e.date);
                    });

                    $("#startDate-no").on("click",function (e) {
                        $('#startDate-no').data("DateTimePicker").show();
                    });
                    $("#startDate-yes").on("click",function (e) {
                        $('#startDate-yes').data("DateTimePicker").show();
                    });

                    $("#endDate-no").on("click",function (e) {
                        $('#endDate-no').data("DateTimePicker").show();
                    });
                    $("#endDate-yes").on("click",function (e) {
                        $('#endDate-yes').data("DateTimePicker").show();
                    });

                    $("#endDate").on("click",function (e) {
                        $('#endDate').data("DateTimePicker").show();
                    });
                    $("#startDate").on("click",function (e) {
                        $('#startDate').data("DateTimePicker").show();
                    });


                    $('.affiliates-table-and-pagination').on('click', '.pagination-top-affiliates ul a',function ($e){
                        $e.preventDefault();

                        var $loc = $(this).attr('href');

                        $.post($loc, function ($resp){
                            $('.affiliates-table-and-pagination').html($resp.html);
                        },'json');
                    });

                    $('#btn-apply-filter-affiliates').on('click', function (){
                        var $formData = $('#form-affiliates').serialize();

                        var $btn = $(this);
                        $btn.button('loading');

                        $.post('/analytics/affiliatestable', $formData, function ($resp){
                            $('.affiliates-table-and-pagination').html($resp.html);
                            $btn.button('reset');
                        },'json');
                    });

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