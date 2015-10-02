<div class="row-fluid">
    <table class="table table-striped">
        <thead>
        <th>Date</th>
        <th>No. of Sales</th>
        <th>Total Sales</th>
        <th>Instructor Revenue</th>
        <th>Affiliate Revenue</th>
        <th>LTC Commission</th>
        <th>2nd Tier Affiliate Commission</th>
        <th>Wazaar Revenue</th>
        <th>Tax</th>
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