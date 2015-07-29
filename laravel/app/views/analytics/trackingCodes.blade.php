@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <div class="container">
            <h3>Tracking Codes</h3>
            <div class="row margin-bottom-20 analytics-page">
                <table class="table" id="table-tracking-codes">
                    <thead>
                        <th>Tracking Code</th>
                        <th>Course</th>
                        <th>Clicks</th>
                        <th>Sales</th>
                        <th>Conversion</th>
                    </thead>

                    <tbody>
                        @foreach($trackingCodes['data'] as $code)
                        <tr>
                            <td><a href="{{url('dashboard/course/' . $code['course_id'] . '/trackingcode/' . $code['tracking_code'] . '/stats')}}">{{$code['tracking_code']}}</a></td>
                            <td><a href="{{url('dashboard/course/' . $code['course_id'] . '/stats')}}">{{$code['course_name']}}</a></td>
                            <td>{{$code['count']}}</td>
                            <td>{{$code['purchase_total']}}</td>
                            <td>{{number_format($code['purchase_count'] / $code['count'] * 100,2)}}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('extra_css')

    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/1.10.6/integration/bootstrap/3/dataTables.bootstrap.css"/>
@stop

@section('extra_js')
    <script type="text/javascript" src="{{url('plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.6/integration/bootstrap/3/dataTables.bootstrap.js"></script>

    <script type="text/javascript">
        $(function(){
            $('#table-tracking-codes').DataTable();
        });
    </script>
@stop