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
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="header clearfix">
                        <h1>{{trans('analytics.trackingCode')}}: {{$trackingCode}} ({{$course->name}})</h1>
                    </div>
                </div>
            </div>

            <div class="row top-activities">

                <div class="col-md-4 col-sm-6 sol-xs-12">
                    <div>
                        <div class="dropdown-wrapper">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" id="btnGroupDrop4" type="button">
                                {{trans('analytics.topTrackingCodes')}} <span id="header-tracking-codes-frequency">{{trans('analytics.today')}}</span></button>
                            <ul id="activities-dropdown" aria-labelledby="btnGroupDrop4" role="menu" class="dropdown-menu tracking-code-hits-dropdown">
                                <li>
                                    <a class="active" href="#" onclick="Analytics.trackingCodeStats('daily',{{$course->id}},'{{$trackingCode}}', this); return false;">{{trans('analytics.today')}}</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.trackingCodeStats('week',{{$course->id}},'{{$trackingCode}}', this); return false;">{{trans('analytics.thisWeek')}}</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.trackingCodeStats('month',{{$course->id}},'{{$trackingCode}}', this); return false;">{{trans('analytics.thisMonth')}}</a>
                                </li>
                                <li>
                                    <a class="#" href="#" onclick="Analytics.trackingCodeStats('alltime',{{$course->id}},'{{$trackingCode}}', this); return false;">{{trans('analytics.alltime')}}</a>
                                </li>
                            </ul>
                        </div>
                        <ul id="wrapper-tracking-code-stats">
                            {{$hitsSalesView}}
                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section('extra_js')
    <script type="text/javascript" src="{{url('js/analytics.js')}}"></script>
@stop