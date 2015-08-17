<div class="table-responsive analytics-page">


    <div class="top-affiliates-table table-wrapper">
        <div class="table-header clearfix">
            <h1 class="left">{{trans('analytics.trackingCodes')}}</h1>
        </div>

        <div class="table-responsive">

            <table class="table">
                <thead>
                <th>{{trans('analytics.trackingCode')}}</th>
                <th>{{trans('analytics.sales')}} (¥)</th>
                <th>{{trans('analytics.clicks')}}</th>
                <th>{{trans('analytics.salesCount')}}</th>
                <th>{{trans('analytics.conversion')}}</th>
                </thead>
                <tbody>
                @foreach($trackingCodes['data'] as $code)
                    <tr>
                        <td>{{$code['tracking_code']}}</td>
                        <td>{{$code['purchases_total']}}</td>
                        <td>{{$code['hits']}}</td>
                        <td>{{$code['purchases']}}</td>
                        <td class="last-column">{{number_format($code['purchases']/$code['hits']*100)}}%</td>
                    </tr>
                @endforeach
                </tbody>
            </table>


        </div>

    </div>
</div>