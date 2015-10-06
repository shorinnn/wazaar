<table class="table table-striped">
    <thead>
    <th>Date</th>
    <th>Revenue</th>
    <th>Instructor/Student Signups</th>
    <th>Affiliate Signups</th>
    <th>Total Signups</th>
    </thead>

    <tbody>
    @foreach($siteStats as $stat)
        <tr>
            <td>{{$stat->the_date}}</td>
            <td>¥{{$stat->revenue}}</td>
            <td>{{$stat->students_instructors_count}}</td>
            <td>{{$stat->affiliates_count}}</td>
            <td>{{$stat->students_instructors_count + $stat->affiliates_count}}</td>
        </tr>
    @endforeach
    </tbody>
</table>


{{$paginator->links()}}

