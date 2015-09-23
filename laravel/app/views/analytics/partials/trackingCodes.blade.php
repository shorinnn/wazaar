@if(count($trackingCodes['data'])>0)
    @foreach($trackingCodes['data'] as $key => $code)
        <li class="clearfix">
                <span>{{$key+1}}.</span>
                <div><a href="{{url('dashboard/course/'. $code['course_id'] .'/trackingcode/'. $code['tracking_code'] .'/stats')}}">{{$code['tracking_code']}}</a></div>
                <em>{{$code['count']}}</em>
        </li>
    @endforeach
    @if (count($trackingCodes['data']) == 10)
        <li><a href="{{url('dashboard/trackingcodes/all')}}" class="view-all">{{trans('analytics.viewAll')}}</a></li>
    @endif
@else
    <div class="clearfix no-data-found">
        <center class="gray">{{trans('analytics.noTrackingCode')}} 
            {{ strtolower( AnalyticsHelper::frequencyReadable($frequency) ) }}</center>
    </div>
@endif