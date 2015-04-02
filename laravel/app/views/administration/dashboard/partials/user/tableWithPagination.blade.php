<table class="table table-striped">
    <tbody>
    <th>Rank</th>
    <th>Username</th>
    <th>Full Name</th>
    <th>Sales(#)</th>
    <th>Sales(¥)</th>
    </tbody>
    <tbody>
    @foreach($topAffiliates as $index => $aff)
        <tr>
            <td>{{( ($pageNumber-1) * Config::get('wazaar.PAGINATION')) + ($index + 1)}}</td>
            <td>{{$aff->username}}</td>
            <td>{{$aff->full_name}}</td>
            <td>{{$aff->sales_count}}</td>
            <td>¥{{number_format($aff->total_sales)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="pagination-top-affiliates">
    {{$topAffiliates->appends(Input::only('taStartDate','taEndDate','affiliateId','sortOrder'))->links()}}
</div>