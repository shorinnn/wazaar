<table class="table table-striped">
    <thead>
    <th>Rank</th>
    <th>Course Name</th>
    <th>Course Category</th>
    <th># Sales</th>
    <th>Revenue</th>
    <th>Instructor Name</th>
    <th>Instructor Email</th>
    <th></th>
    </thead>

    <tbody>
    @foreach($courses as $key => $course)
        <tr>
            <td>{{$key + 1 + $addThisToRank}}</td>
            <td>{{$course->course_name}}</td>
            <td>{{$course->category_name}}</td>
            <td>{{$course->sales_count}}</td>
            <td>¥{{$course->total_sales}}</td>
            <td>{{$course->instructor_first_name}} {{$course->instructor_last_name}}</td>
            <td>{{$course->instructor_email}}</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>

{{$courses->links()}}