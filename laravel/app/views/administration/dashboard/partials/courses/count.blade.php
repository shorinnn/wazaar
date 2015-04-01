<h3>Top Courses ({{$freeCourse == 'no' ? 'Paid' : 'Free'}})</h3>
<hr/>
{{Form::open(['action' => 'AdminDashboardController@index'])}}
<div class="row margin-bottom-20">

    <div class="col-md-2">
        <h4 class="date-range-header">Date Range</h4>
    </div>

    <div class='col-md-2'>
        <div class="form-group">
            <div class='input-group date' id='start-date'>
                <input type='text' class="form-control" id="{{$objNames['startDate']}}" name="{{$objNames['startDate']}}" placeholder="{{trans('analytics.alltime')}}" value="{{!empty($startDate) ? $startDate : 'All Time'}}" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
            </div>
        </div>
    </div>

    <div class='col-md-2'>
        <div class="form-group">
            <div class='input-group date' id='end-date'>
                <input type='text' class="form-control" id="{{$objNames['endDate']}}" name="{{$objNames['endDate']}}" placeholder="{{trans('analytics.alltime')}}" value="{{!empty($endDate) ? $endDate : 'All Time'}}"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
            </div>
        </div>
    </div>

    <div class='col-md-3'>
        <div class="form-group">
            {{Form::select($objNames['categoryId'],['']+CourseCategory::all()->lists('name','id'),$categoryId,['class' => 'form-control', 'id' => $objNames['categoryId']])}}
        </div>
    </div>

    <div class="col-md-3">
        <button class="btn btn-primary" id="btn-update-chart">Apply Filter</button>
    </div>
</div>
{{Form::close()}}

<div class="table-and-pagination">
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
    <?php Paginator::setPageName('page_' . $freeCourse); ?>
    {{$courses->appends($appendThis)->links()}}
</div>

