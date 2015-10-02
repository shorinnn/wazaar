<table class="table table-striped">
    <thead>
    <th>Date</th>
    <th>LTC Registrations</th>
    <th>Affiliate Registrations</th>
    </thead>

    <tbody>
    @foreach($sales as $sale)
        <tr>
            <td>{{$sale->date}}</td>
            <td>{{$sale->sales_count}}</td>
            <td>{{$sale->sales_total}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

{{$sales->links()}}