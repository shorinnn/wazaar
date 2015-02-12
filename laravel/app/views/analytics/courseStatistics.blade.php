@extends('layouts.default')
@section('content')

    <div class="wrapper">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="header clearfix">
                        <h1>Course Statistics : {{$course->name}}</h1>
                    </div>
                </div>
            </div>

            <div class="row top-activities">

                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div>
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop4" type="button">
                                Top Tracking Codes <span id="header-tracking-codes-frequency">Today</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop4" role="menu" class="dropdown-menu tracking-codes-dropdown">
                                <li>
                                    <a class="active" href="#" onclick="Analytics.trackingSalesCodes('daily',{{$course['id']}}, this); return false;">Today</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.trackingSalesCodes('week',{{$course['id']}}, this); return false;">This week</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.trackingSalesCodes('month',{{$course['id']}}, this); return false;">This month</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.trackingSalesCodes('alltime',{{$course['id']}}, this); return false;">All time</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-tracking-codes">
                            {{$trackingCodesSalesView}}
                        </ul>
                        <a href="#" class="view-all">View All</a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div id="sales-today">
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop3" type="button">
                                Sales <span id="header-sales-frequency">Today</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop3" role="menu" class="dropdown-menu sales-dropdown">
                                <li>
                                    <a class="active" href="#" onclick="Analytics.sales('daily',{{$course['id']}}, this); return false;">Today</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.sales('week',{{$course['id']}}, this); return false;">This week</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.sales('month',{{$course['id']}}, this); return false;">This month</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.sales('alltime',{{$course['id']}}, this); return false;">All time</a>
                                </li>
                            </ul>
                        </div>

                        <div id="wrapper-sales">
                            {{$salesView}}
                        </div>

                    </div>
                </div>

                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div>
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop6" type="button">
                                Tracking Code Converting <span id="header-tracking-code-conversions-frequency">Today</span> </button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop6" role="menu" class="dropdown-menu tracking-code-conversions-dropdown">
                                <li>
                                    <a class="active" href="#" onclick="Analytics.trackingCodeConversions('daily',{{$course['id']}}, this); return false;">Today</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.trackingCodeConversions('week',{{$course['id']}}, this); return false;">This week</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.trackingCodeConversions('month',{{$course['id']}}, this); return false;">This month</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.trackingCodeConversions('alltime',{{$course['id']}}, this); return false;">All time</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-tracking-code-conversions">
                            {{$trackingCodeConversionView}}
                        </ul>
                    </div>
                </div>



            </div>


                 <canvas id="myChart" width="980px" height="400"></canvas>
        </div>
    </div>
@stop

@section('extra_js')
    <script src="{{url('resources/Chart.js/Chart.js')}}"></script>
    <script type="text/javascript" src="{{url('js/analytics.js')}}"></script>
    <script type="text/javascript">
        $(function (){

            var data = {
                labels: {{json_encode($salesLabelData['labels'])}},
                datasets: [
                    {
                        label: "Weekly Sales",
                        fillColor: "rgba(0,220,220,0.2)",
                        strokeColor: "rgb(0,153,255",
                        pointColor: "rgb(85,220,164)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "rgb(85,220,164)",
                        pointHighlightStroke: "rgb(85,220,164)",
                        multiTooltipTemplate : "<%= label %> $<%=value%>",
                        data: {{json_encode($salesLabelData['data'])}}
                    }
                ]
            };

            // Get context with jQuery - using jQuery's .get() method.
            var ctx = $("#myChart").get(0).getContext("2d");
            var myLineChart = new Chart(ctx).Line(data);
        });
    </script>
@stop