<table class="table table-striped">
    <thead>
        <th>{{trans('analytics.date')}}</th>
        <th>{{trans('analytics.salesCount')}}</th>
        <th>{{trans('analytics.salesTotal')}}</th>
        <th>{{trans('analytics.affiliate_revenue')}}</th>
        <th>{{trans('analytics.ltc_commission')}}</th>
        <th>{{trans('analytics.affiliate_two_tier_fee')}}</th>
    </thead>

    <tbody>
        @foreach($sales as $sale)
            <tr>
                <td>{{$sale->date}}</td>
                <td>{{$sale->sales_count}}</td>
                <td>{{$sale->sales_total}}</td>
                <td>{{$sale->revenue}}</td>
                <td>{{$sale->ltc_earnings}}</td>
                <td>{{$sale->second_tier_earnings}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{$sales->links()}}