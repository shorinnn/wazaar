@extends('layouts.default')
@section('content')
    <style type="text/css">
        .big-text
        {
            font-size: 20px;
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
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="header clearfix">
                        <h1>{{$trackingCode}} ({{$course->name}})</h1>
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
                            {{$hitsSalesView}}
                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </div>
@stop