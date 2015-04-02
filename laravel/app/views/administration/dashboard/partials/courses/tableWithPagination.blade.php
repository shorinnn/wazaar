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
            <td>{{( ($pageNumber-1) * Config::get('wazaar.PAGINATION')) + ($index + 1)}}</td>
            <td><a href="{{url('courses/' . $course->slug)}}" target="_blank"> {{$course->course_name}}</a></td>
            <td><a href="{{url('dashboard/admin/category/' . $course->course_category_id . '/' . $freeCourse)}}">{{$course->category_name}}</a></td>
            <td>{{$course->sales_count}}</td>
            <td>¥{{number_format($course->total_sales)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="pagination-top-courses">
    {{$courses->appends(Input::except('_token'))->links()}}
</div>