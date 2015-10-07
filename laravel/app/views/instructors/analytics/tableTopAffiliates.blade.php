<table class="table table-striped">
    <thead>
    <th>{{trans('analytics.rank')}}</th>
    <th>{{trans('analytics.name')}}</th>
    <th>{{trans('analytics.email')}}</th>
    <th>{{trans('analytics.salesTotal')}}</th>
    <th>{{trans('analytics.salesCount')}}</th>
    
    </thead>

    <tbody>
        @foreach($affiliates as $key => $affiliate)
            <tr>
                <td>{{$key + 1 + $addThisToRank}}</td>
                <td>{{$affiliate->full_name}}</td>
                <td>{{ str_replace('#waa#-','', $affiliate->email) }}</td>
                <td>¥{{number_format($affiliate->total_sales,0)}}</td>
                <td>{{$affiliate->sales_count}}</td>

            </tr>
        @endforeach
    </tbody>
</table>

