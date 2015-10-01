<table class="table table-striped">
    <thead>
        <th>Date</th>
        <th>No. of Sales</th>
        <th>Total Sales</th>
        <th>Affiliate Revenue</th>
        <th>LTC Commission</th>
        <th>2nd Tier Affiliate Commission</th>
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
