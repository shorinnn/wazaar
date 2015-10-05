@extends('layouts.default')
@section('content')
    <style type="text/css">
        .big-text
        {
            font-size: 18px;
            padding: 15px 5px;
        }

        .align-right
        {
            text-align: right;
        }

        .align-left
        {
            text-align: left;
        }

    </style>
    <div class="wrapper">
        <div class="container course-statistics">

            <div class="row">
                <div class="col-md-12">
                    <div class="header clearfix">
                        <h1>{{trans('analytics.trackingCode')}} 
                        	<p>{{$trackingCode}} ({{$course->name}})</p>
                        </h1>
                    </div>
                </div>
            </div>

            <div class="row top-activities">

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="stat-block">
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default">
                                <span id="header-tracking-codes-frequency">{{trans('analytics.today')}}</span>{{trans('analytics.topTrackingCodes')}} </button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop4" role="menu" class="dropdown-menu tracking-code-hits-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="Analytics.trackingCodeStats('daily',{{$course->id}},'{{$trackingCode}}', this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.trackingCodeStats('week',{{$course->id}},'{{$trackingCode}}', this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.trackingCodeStats('month',{{$course->id}},'{{$trackingCode}}',this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.trackingCodeStats('alltime',{{$course->id}},'{{$trackingCode}}', this); return false;">{{trans('analytics.alltime')}}</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-tracking-code-stats">
                            {{$hitsSalesView}}
                        </ul>

                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div id="sales-today" class="stat-block">
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop3" type="button">
                                <span id="header-sales-frequency">{{trans('analytics.today')}}</span>{{trans('analytics.sales')}} </button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop3" role="menu" class="dropdown-menu sales-dropdown">
                                <li>
                                    <a class="active" href="#" onclick="Analytics.sales('daily',{{$course->id}},'{{$trackingCode}}', this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="" href="#" onclick="Analytics.sales('week',{{$course->id}},'{{$trackingCode}}', this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="" href="#" onclick="Analytics.sales('month',{{$course->id}},'{{$trackingCode}}', this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="" href="#" onclick="Analytics.sales('alltime',{{$course->id}},'{{$trackingCode}}', this); return false;">{{trans('analytics.alltime')}}</a>
                                </li>
                            </ul>
                        </div>

                        <div id="wrapper-sales">
                            {{$salesView}}
                        </div>

                    </div>
                </div>

            </div>



            <div class="row">
                <div class="col-lg-12 margin-bottom-10">
                    <select name="courses" id="select-tracking-codes" class="form-control" multiple="multiple" placeholder="Compare with other tracking codes">
                        @foreach($trackingCodes as $code)
                            <option value="{{$code->tracking_code}}">{{$code->tracking_code}}</option>
                        @endforeach
                    </select>
                </div>

            </div>




            <div class="row margin-bottom-20 margin-top-10">

                <div class="col-md-3">
                    <h4 class="date-range-header">{{trans('analytics.dateRange')}}</h4>
                </div>

                <div class='col-md-3'>
                    <div class="form-group">
                        <div class='input-group date' id='start-date'>
                            <input type='text' class="form-control" id="startDate" value="{{date('m/d/Y',strtotime('-7 days'))}}" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        </div>
                    </div>
                </div>

                <div class='col-md-3'>
                    <div class="form-group">
                        <div class='input-group date' id='end-date'>
                            <input type='text' class="form-control" id="endDate" value="{{date('m/d/Y')}}" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <button class="large-button blue-button" id="btn-update-chart">{{trans('analytics.updateChart')}}</button>
                </div>
            </div>


            <div class="row">
                <canvas id="myChart" width="980px" height="400" class="margin-bottom-20"></canvas>
            </div>
            <div id="chartLegend"></div>

        </div>
    </div>

    <div id="tracking-code" data-tracking-code="{{$trackingCode}}"></div>
    <div id="ajax-loader-wrapper" class="hidden">
        <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
    </div>
@stop

@section('extra_css')
    <link rel="stylesheet" href="{{url('resources/select2-dist/select2.css')}}"/>
    <link rel="stylesheet" href="{{url('resources/select2-dist/select2-bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{url('resources/datetimepicker/build/css/bootstrap-datetimepicker.css')}}"/>
@stop

@section('extra_js')
    <script src="{{url('resources/select2-dist/select2.min.js')}}"></script>
    <script src="{{url('resources/Chart.js/Chart.js')}}"></script>
    <script src="{{url('resources/moment/min/moment.min.js')}}"></script>
    <script src="{{url('resources/datetimepicker/src/js/bootstrap-datetimepicker.js')}}"></script>
    <script type="text/javascript" src="{{url('js/analytics.js')}}"></script>
    <script type="text/javascript">
        var $trackingCode = $('#tracking-code').attr('data-tracking-code');
        $(function (){
            $("#select-tracking-codes").select2({
                maximumSelectionSize: 5
            });
            var data = {
                labels: {{json_encode($salesLabelData['labels'])}},
                datasets: [
                    {
                        label: "Weekly Sales",
                        fillColor: "rgba(0,220,220,0.2)",
                        strokeColor: "rgb(0,153,255)",
                        pointColor: "rgb(85,220,164)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "rgb(85,220,164)",
                        pointHighlightStroke: "rgb(85,220,164)",
                        data: {{json_encode($salesLabelData['data'])}}
                    }
                ]

            };

            $('#start-date').datetimepicker({format: 'MM/DD/YYYY'});
            $('#end-date').datetimepicker({format: 'MM/DD/YYYY'});
            $("#start-date").on("dp.change",function (e) {
                $('#end-date').data("DateTimePicker").minDate(e.date);
            });
            $("#end-date").on("dp.change",function (e) {
                $('#start-date').data("DateTimePicker").maxDate(e.date);
            });

            $("#start-date").on("click",function (e) {
                $('#start-date').data("DateTimePicker").show();
            });
            $("#end-date").on("click",function (e) {
                $('#end-date').data("DateTimePicker").show();
            });

            // Get context with jQuery - using jQuery's .get() method.
            var ctx = $("#myChart").get(0).getContext("2d");
            var myLineChart = new Chart(ctx).Line(data,{
                bezierCurve: false
            });


            $('#btn-update-chart').on('click', function (){
                var $trackingCodes = [];
                $('#select-tracking-codes :selected').each(function(i, selected){
                    $trackingCodes.push($(selected).val());
                });

                var $startDate = $('#startDate').val();
                var $endDate = $('#endDate').val();
                $.post('/dashboard/trackingcodes/'+ $trackingCode +'/stats/compare', {'trackingCodes' : $trackingCodes.join(','),'startDate': $startDate, 'endDate': $endDate }, function (responseData){
                    myLineChart.destroy();
                    data.labels = responseData.label;
                    data.datasets = responseData.dataSets;
                    myLineChart = new Chart(ctx).Line(data,{
                        bezierCurve: false
                    });

                    //console.log(responseData.dataSets);
                    $('#chartLegend').html('');
                    for (var $i in responseData.dataSets){
                        $('#chartLegend').append('<div><span style="background-color: '+ responseData.dataSets[$i].pointColor +'">---</span> '+ responseData.dataSets[$i].label +'</div>')
                    }

                },'json');
            });

        });
    </script>
@stop
