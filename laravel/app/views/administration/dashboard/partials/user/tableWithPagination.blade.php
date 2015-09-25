<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Rank</th>
            <th>Username</th>
            <th>Full name</th>
            <th class="text-right">Sales (#)</th>
            <th class="text-right last-column sorting-active relative"> Sales (¥)</th>
        </tr>
        </thead>
        <tbody>


        @foreach($topAffiliates as $index => $aff)
        <tr>
            <th scope="row">{{( ($pageNumber-1) * Config::get('wazaar.PAGINATION')) + ($index + 1)}}</th>
            <td class="link">{{$aff->username}}</td>
            <td>{{$aff->full_name}}	</td>
            <td class="text-right">{{$aff->sales_count}}</td>
            <td class="text-right last-column">  ¥ {{$aff->sales_count}}</td>
        </tr>
        @endforeach

        </tbody>
    </table>
</div>
<div class="table-pagination pagination-top-affiliates clearfix">
    {{$topAffiliates->appends(Input::only('taStartDate','taEndDate','affiliateId','sortOrder'))->links()}}
</div>