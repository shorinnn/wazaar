<div class="row-fluid">
    <table class="table table-striped">
        <thead>
        <th>{{trans('analytics.date')}}</th>
        <th>{{trans('analytics.salesCount')}}</th>
        <th>{{trans('analytics.salesTotal')}}</th>
        <th>{{trans('analytics.instructor_commission')}}</th>
        <th>{{trans('analytics.affiliate_revenue')}}</th>
        <th>{{trans('analytics.ltc_commission')}}</th>
        <th>{{trans('analytics.affiliate_two_tier_fee')}}</th>
        <th>{{trans('analytics.wazaar_system_fee')}}</th>
        <th>{{trans('analytics.tax')}}</th>
        </thead>

        <tbody>
        @foreach($stats as $stat)
            <tr>
                <td>{{$stat->date}}</td>
                <td>{{$stat->sales_count}}</td>
                <td>{{$stat->sales_total}}</td>
                <td>{{$stat->instructor_earnings}}</td>
                <td>{{$stat->affiliate_earnings}}</td>
                <td>{{$stat->ltc_affiliate_earnings}}</td>
                <td>{{$stat->second_tier_affiliate_earnings}}</td>
                <td>{{$stat->site_earnings}}</td>
                <td>{{$stat->tax}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


{{$stats->links()}}