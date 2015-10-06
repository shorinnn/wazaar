
<table class="table table-striped">
    <thead>
    <th>Rank</th>
    <th>Name</th>
    <th>Email</th>
    <th>Total Sales</th>
    <th># Sales</th>
    <th></th>
    </thead>

    <tbody>
    @foreach($affiliates as $key => $affiliate)
        <tr>
            <td>{{$key + 1 + $addThisToRank}}</td>
            <td>{{$affiliate->full_name}}</td>
            <td>{{$affiliate->email}}</td>
            <td>{{$affiliate->total_sales}}</td>
            <td>{{$affiliate->sales_count}}</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>

{{$affiliates->links()}}