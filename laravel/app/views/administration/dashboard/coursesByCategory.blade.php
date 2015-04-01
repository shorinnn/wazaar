@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <div class="container affiliate-dashboard dashboard">

            <h3>Top Courses ({{$freeCourse == 'no' ? 'Paid' : 'Free'}})</h3>
            <hr/>
            {{Form::open(['action' => ['AdminDashboardController@topCoursesByCategory', $categoryId, $freeCourse]])}}
            <div class="row margin-bottom-20">

                <div class="col-md-2">
                    <h4 class="date-range-header">Date Range</h4>
                </div>

                <div class='col-md-2'>
                    <div class="form-group">
                        <div class='input-group date' id='start-date'>
                            <input type='text' class="form-control" id="startDate" name="startDate" value="{{!empty($startDate) ? $startDate : ''}}" />
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                        </div>
                    </div>
                </div>

                <div class='col-md-2'>
                    <div class="form-group">
                        <div class='input-group date' id='end-date'>
                            <input type='text' class="form-control" id="endDate" name="endDate" value="{{!empty($endDate) ? $endDate : ''}}"/>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" id="btn-update-chart">Apply Filter</button>
                </div>
            </div>
            {{Form::close()}}
            <table class="table table-striped">
                <tbody>
                <th>Rank</th>
                <th>Course</th>
                <th>Category</th>
                <th>Sales(#)</th>
                <th>Sales(¥)</th>
                </tbody>
                <tbody>
                @foreach($courses as $index => $course)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$course->course_name}}</td>
                        <td><a href="{{url('dashboard/admin/category/' . $course->course_category_id . '/' . $freeCourse)}}">{{$course->category_name}}</a></td>
                        <td>{{$course->sales_count}}</td>
                        <td>¥{{number_format($course->total_sales)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$courses->appends(Input::all())->links()}}

    </div>
</div>

@stop

@section('extra_js')
    <script src="{{url('resources/moment/min/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{url('resources/datetimepicker/src/js/bootstrap-datetimepicker.js')}}"></script>

    <script type="text/javascript">
        $(function(){

            $('#startDate, #tcyStartDate, #tcnStartDate').datetimepicker({format: 'MM/DD/YYYY'});
            $('#endDate, #tcyEndDate, #tcnEndDate').datetimepicker({format: 'MM/DD/YYYY'});



        });
    </script>
@stop