@if(count($trackingCodeConversions['data'])>0)
    @foreach($trackingCodeConversions['data'] as $key => $course)
        <li>
            <a href="#">
                <span>{{$key+1}}.</span>
                <a href="{{url('dashboard/course/'. $course['product_id'] .'/trackingcode/'. $course['tracking_code'] .'/stats')}}">{{$course['tracking_code']}}</a>
                <em>{{number_format($course['purchases'] / $course['hits'] * 100,2)}}%</em>
            </a>
        </li>
    @endforeach
@else
    <div class="margin-top-15">
        <center class="gray">{{trans('analytics.noTrackingCodeConversion')}} {{AnalyticsHelper::frequencyReadable($frequency)}}</center>
    </div>
@endif