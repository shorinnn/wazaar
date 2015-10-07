<table class="table table-striped">
    <thead>
    <th width="10%">{{trans('analytics.date')}}</th>
    <th>{{trans('analytics.salesTotal')}}</th>
    <th>{{trans('analytics.salesCount')}}</th>
    <th>{{trans('analytics.wazaarRevenue')}}</th>
    <th>{{trans('analytics.instructor_commission')}}</th>
    <th>{{trans('analytics.affiliate_revenue')}}</th>
    <th>{{trans('analytics.ltc_sales')}}</th>
    <th>{{trans('analytics.affiliate_two_tier_fee')}}</th>
    <th>{{trans('analytics.publisher_two_tier_commission')}}</th>
    <th></th>
    </thead>

    <tbody>
    @foreach($sales as $sale)
        <tr>
            <td>{{$sale->date}}</td>
            <td>¥{{number_format($sale->sales_total,0)}}</td>
            <td>{{$sale->sales_count}}</td>
            <td>¥{{number_format($sale->site_earnings,0)}}</td>
            <td>¥{{number_format($sale->instructor_earnings,0)}}</td>
            <td>¥{{number_format($sale->affiliate_earnings,0)}}</td>
            <td>¥{{number_format($sale->ltc_affiliate_earnings,0)}}</td>
            <td>¥{{number_format($sale->second_tier_affiliate_earnings,0)}}</td>
            <td>¥{{number_format($sale->second_tier_instructor_earnings,0)}}</td>
            <td><a href=""><i class="fa fa-arrow-right"></i></a> </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{$sales->links()}}