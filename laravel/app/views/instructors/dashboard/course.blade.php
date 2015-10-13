@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <div class="container affiliate-dashboard dashboard  analytics-page">


            <h2 class="margin-top-10">{{trans('analytics.course')}}: {{$course->name}}</h2>
            <div class="row-fluid">
                <div class="panel panel-default clearfix">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{trans('analytics.filters')}}</h3>
                    </div>

                    <div class="segmented-controls analytics-filter clearfix">
                        <div class="panel-body buttons-container clearfix">
                            <!--<a class="segmented-buttons button-filter button-filter-daily" href="#" onclick="Analytics.SalesCount('daily', '',this); return false;">{{trans('analytics.daily')}}</a>-->
                            <a class="segmented-buttons button-filter button-filter-daily" href="#" onclick="Analytics.SalesCount('daily', {{$course->id}},this); return false;">{{trans('analytics.daily')}}</a>
                            <a class="segmented-buttons button-filter button-filter-week" href="#" onclick="Analytics.SalesCount('week', {{$course->id}},this); return false;">{{trans('analytics.weekly')}}</a>
                            <a class="segmented-buttons button-filter button-filter-month" href="#" onclick="Analytics.SalesCount('month', {{$course->id}},this); return false;">{{trans('analytics.monthly')}}</a>
                            <a class="segmented-buttons button-filter button-filter-alltime" href="#" onclick="Analytics.SalesCount('alltime', {{$course->id}},this); return false;">{{trans('analytics.allTime')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row top-activities">


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


            </div>


            <div class="row hide">
                <div class="top-affiliates-table table-wrapper">
                    {{-- @include('administration.dashboard.partials.user.topAffiliates') --}}
                </div>
            </div>

            <div class="row hide">
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

            <div class="row hide">
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

            $.get('/analytics/course/stats/{{$course->id}}', function ($table){
                $('.table-stats-wrapper').html($table);
            });

            $.get('/analytics/course/affiliates/{{$course->id}}', function ($table){
                $('.table-affiliates-wrapper').html($table);
            });

            $('.table-stats-wrapper').on('click','a', function ($e){
                $e.preventDefault();
                var $url = $(this).attr('href');
                $.get($url, function ($table){
                    $('.table-stats-wrapper').html($table);
                });
            });

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