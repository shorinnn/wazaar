@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <div class="container">
            <h3>Tracking Codes</h3>
            <div class="row margin-bottom-20">
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Tracking Code</th>
                        <th>Course</th>
                        <th>Sales #</th>
                    </thead>

                    <tbody>
                        @foreach($trackingCodes['data'] as $code)
                        <tr>
                            <td><a href="{{url('dashboard/course/' . $code['course_id'] . '/trackingcode/' . $code['tracking_code'] . '/stats')}}">{{$code['tracking_code']}}</a></td>
                            <td><a href="{{url('dashboard/course/' . $code['course_id'] . '/stats')}}">{{$code['course_name']}}</a></td>
                            <td>{{$code['count']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop