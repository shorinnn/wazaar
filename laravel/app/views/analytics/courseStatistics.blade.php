@extends('layouts.default')
@section('content')

    <div class="wrapper">
        <div class="container course-statistics">

            <div class="row">
                <div class="col-md-12">
                    <div class="header clearfix">
                        <h1>{{trans('analytics.courseStats')}} 
                        	<p>{{$course->name}}</p>
                        </h1>
                    </div>
                </div>
            </div>

            <div class="row top-activities">

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="stat-block">
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default">
                                {{trans('analytics.topTrackingCodes')}} <span id="header-tracking-codes-frequency">{{trans('analytics.today')}}</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop4" role="menu" class="dropdown-menu tracking-codes-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="Analytics.trackingSalesCodes('daily',{{$course['id']}}, this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.trackingSalesCodes('week',{{$course['id']}}, this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.trackingSalesCodes('month',{{$course['id']}}, this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.trackingSalesCodes('alltime',{{$course['id']}}, this); return false;">{{trans('analytics.alltime')}}</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-tracking-codes">
                            {{$trackingCodesSalesView}}
                        </ul>

                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div id="sales-today" class="stat-block">
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop3" type="button">
                                {{trans('analytics.sales')}} <span id="header-sales-frequency">{{trans('analytics.today')}}</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop3" role="menu" class="dropdown-menu sales-dropdown">
                                <li>
                                    <a class="active" href="#" onclick="Analytics.sales('daily',{{$course['id']}},'', this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.sales('week',{{$course['id']}},'', this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.sales('month',{{$course['id']}},'', this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.sales('alltime',{{$course['id']}},'', this); return false;">{{trans('analytics.alltime')}}</a>
                                </li>
                            </ul>
                        </div>

                        <div id="wrapper-sales">
                            {{$salesView}}
                        </div>

                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="stat-block">
                        <div class="dropdown-wrapper">
                            <button class="btn btn-default">
                                {{trans('analytics.trackingCodeConverting')}} <span id="header-tracking-code-conversions-frequency">{{trans('analytics.today')}}</span> </button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop6" role="menu" class="dropdown-menu tracking-code-conversions-dropdown">
                                <li>
                                    <a class="active with-today" href="#" onclick="Analytics.trackingCodeConversions('daily',{{$course['id']}}, this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="with-weekly" href="#" onclick="Analytics.trackingCodeConversions('week',{{$course['id']}}, this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="with-monthly" href="#" onclick="Analytics.trackingCodeConversions('month',{{$course['id']}}, this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="with-alltime" href="#" onclick="Analytics.trackingCodeConversions('alltime',{{$course['id']}}, this); return false;">{{trans('analytics.alltime')}}</a>
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
                <div class="col-md-12" id="wrapper-tracking-codes-table">
                    {{$trackingCodesTableView}}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 margin-bottom-10 margin-top-20">
                    <select name="courses" id="select-courses" class="form-control" multiple="multiple" placeholder="Compare with other courses">
                        @foreach($courses as $affCourse)
                        <option value="{{$affCourse->id}}">{{$affCourse->name}}</option>
                        @endforeach
                    </select>
                </div>

            </div>




            <div class="row margin-bottom-20">

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
                        <button class="btn btn-primary" id="btn-update-chart">Update Chart</button>
                    </div>
            </div>



            <div class="row">

            <canvas id="myChart" width="980px" height="400" class="margin-bottom-20"></canvas>


            </div>

            <div id="chartLegend"></div>
        </div>
    </div>

    <div id="course-id" data-course-id="{{$course['id']}}"></div>
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
        var courseId = $('#course-id').attr('data-course-id');
        $(function (){
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

            // Get context with jQuery - using jQuery's .get() method.
            var ctx = $("#myChart").get(0).getContext("2d");
            var myLineChart = new Chart(ctx).Line(data,{
                bezierCurve: false
            });

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


            $("#select-courses").select2({
                maximumSelectionSize: 5
            });


            $('#btn-update-chart').on('click', function (){
                var $courses = [];
                $('#select-courses :selected').each(function(i, selected){
                    $courses.push($(selected).val());
                });

                var $startDate = $('#startDate').val();
                var $endDate = $('#endDate').val();
                $.post('/dashboard/course/'+ courseId +'/stats/compare', {'courseIds' : $courses.join(','),'startDate': $startDate, 'endDate': $endDate }, function (responseData){
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