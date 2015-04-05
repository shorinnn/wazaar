@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <div class="container">
            <h3>Tracking Codes</h3>
            <div class="row margin-bottom-20">
                <table class="table table-striped">
                    <thead>
                        <th>Tracking Code</th>
                        <th>Course</th>
                        <th>Sales #</th>
                    </thead>

                    <tbody>
                        @foreach($trackingCodes['data'] as $code)
                        <tr>
                            <td>{{$code['tracking_code']}}</td>
                            <td>{{$code['course_name']}}</td>
                            <td>{{$code['count']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop