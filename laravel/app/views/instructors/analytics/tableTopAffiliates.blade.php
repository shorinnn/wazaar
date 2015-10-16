<div class="new_analytics">
    <div class="course-summary-block">
        <table class="table">
            <thead>
            <th>{{trans('analytics.rank')}}</th>
            <th>{{trans('analytics.name')}}</th>
            <th>{{trans('analytics.email')}}</th>
            <th>{{trans('analytics.salesTotal')}}</th>
            <th>{{trans('analytics.salesCount')}}</th>

            </thead>

            <tbody>
                @if(count($affiliates) >= 1)
                    @foreach($affiliates as $key => $affiliate)
                        <tr>
                            <td>{{$key + 1 + $addThisToRank}}</td>
                            <td>{{$affiliate->full_name}}</td>
                            <td>{{ str_replace('#waa#-','', $affiliate->email) }}</td>
                            <td>¥{{number_format($affiliate->total_sales,0)}}</td>
                            <td>{{$affiliate->sales_count}}</td>

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">You have no affiliate sales in this period.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>