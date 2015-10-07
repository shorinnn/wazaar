<table class="table table-striped">
    <thead>
    <th>{{trans('analytics.date')}}</th>
    <th>{{trans('analytics.revenue')}}</th>
    <th>{{trans('analytics.tax')}}</th>
    <th>{{trans('analytics.totalSignUps')}}</th>
    <th>{{trans('analytics.totalSignUpsAffs')}}</th>
    <th>{{trans('analytics.totalSignupsAll')}}</th>
    <th></th>

    </thead>

    <tbody>
    @foreach($siteStats as $stat)
        <tr>
            <td>{{$stat->the_date}}</td>
            <td>¥{{number_format($stat->revenue,0)}}</td>
            <td>¥{{number_format($stat->tax,0)}}</td>
            <td>{{$stat->students_instructors_count}}</td>
            <td>{{$stat->affiliates_count}}</td>
            <td>{{$stat->students_instructors_count + $stat->affiliates_count}}</td>
            <td><a href=""><i class="fa fa-arrow-right"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>


{{$paginator->links()}}

