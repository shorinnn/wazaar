<table class="table table-striped">
    <thead>
    <th>{{trans('analytics.rank')}}</th>
    <th>{{trans('analytics.courseName')}}</th>
    <th>{{trans('analytics.courseCategory')}}</th>
    <th>{{trans('analytics.salesCount')}}</th>
    <th>{{trans('analytics.salesTotal')}}</th>
    <th>{{trans('analytics.instructorName')}}</th>
    <th>{{trans('analytics.instructorEmail')}}</th>
    <th></th>
    </thead>

    <tbody>
    @foreach($courses as $key => $course)
        <tr>
            <td>{{$key + 1 + $addThisToRank}}</td>
            <td>{{$course->course_name}}</td>
            <td>{{$course->category_name}}</td>
            <td>{{$course->sales_count}}</td>
            <td>¥{{number_format($course->total_sales,0)}}</td>
            <td>{{$course->instructor_first_name}} {{$course->instructor_last_name}}</td>
            <td>{{$course->instructor_email}}</td>
            <td><a href=""><i class="fa fa-arrow-right"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>

{{$courses->links()}}