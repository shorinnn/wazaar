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