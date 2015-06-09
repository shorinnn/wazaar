@if(count($courseConversions['data'])>0)
    @foreach($courseConversions['data'] as $key => $course)
        <li>
            <a href="#">
                <span>{{$key+1}}.</span>

                <a href="{{url('dashboard/course/'. $course['product_id'] .'/stats')}}">{{$course['name']}}</a>

                <em>
                    @if ($course['purchases'] == 0 OR $course['hits'] == 0)
                        0
                    @else
                        {{number_format($course['purchases'] / $course['hits'] * 100,2)}}
                    @endif
                        %</em>
            </a>
        </li>
    @endforeach
@else
    <div class="clearfix no-data-found">
        <center class="gray">{{trans('analytics.noCourseConversion')}} 
            {{strtolower ( AnalyticsHelper::frequencyReadable($frequency) ) }}</center>
    </div>
@endif