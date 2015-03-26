
<div class="table-wrapper table-responsive">
<table class="table table-bordered table-striped">
    <thead>
    <th>Tracking Code</th>
    <th>Sales (¥)</th>
    <th>Clicks</th>
    <th># of Sales</th>
    <th>Conversion</th>
    </thead>
    <tbody>
    @foreach($trackingCodes['data'] as $code)
        <tr>
            <td>{{$code['tracking_code']}}</td>
            <td>{{$code['purchases_total']}}</td>
            <td>{{$code['hits']}}</td>
            <td>{{$code['purchases']}}</td>
            <td>{{number_format($code['purchases']/$code['hits']*100)}}%</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>