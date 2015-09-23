@if(count($trackingCodeConversions['data'])>0)
    @foreach($trackingCodeConversions['data'] as $key => $course)
        <li class="clearfix">
                <span>{{$key+1}}.</span>
                <div><a href="{{url('dashboard/course/'. $course['product_id'] .'/trackingcode/'. $course['tracking_code'] .'/stats')}}">{{$course['tracking_code']}}</a></div>
                @if ($course['hits'] > 0)
                    <em>{{number_format($course['purchases'] / $course['hits'] * 100)}}%</em>
                @else
                    <em>0%</em>
                @endif
        </li>
    @endforeach
@else
    <div class="clearfix no-data-found">
        <center class="gray">{{trans('analytics.noTrackingCodeConversion')}} 
            {{ strtolower( AnalyticsHelper::frequencyReadable($frequency) ) }}</center>
    </div>
@endif