<table class="table table-striped">
    <thead>
    <th>Date</th>
    <th>Total Revenue</th>
    <th># Sales</th>
    <th>Wazaar Revenue</th>
    <th>Instructor Revenue</th>
    <th>Affiliate Revenue</th>
    <th>LTC Revenue</th>
    <th>2 Tier Affiliate Revenue</th>
    <th>2 Tier Instructor Revenue</th>
    <th></th>
    </thead>

    <tbody>
    @foreach($sales as $sale)
        <tr>
            <td>{{$sale->date}}</td>
            <td>{{$sale->sales_total}}</td>
            <td>{{$sale->sales_count}}</td>
            <td>{{$sale->site_earnings}}</td>
            <td>{{$sale->instructor_earnings}}</td>
            <td>{{$sale->affiliate_earnings}}</td>
            <td>{{$sale->ltc_affiliate_earnings}}</td>
            <td>{{$sale->second_tier_affiliate_earnings}}</td>
            <td>{{$sale->second_tier_instructor_earnings}}</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>

{{$sales->links()}}