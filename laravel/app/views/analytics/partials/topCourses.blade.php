@if (count($topCourses['data']) > 0)
    @foreach($topCourses['data'] as $key => $course)
        <li class="clearfix">
                <span>{{$key+1}}.</span>
                <div><a href="{{url('analytics/course/'. $course['id'] .'/stats')}}">{{$course['name']}}</a></div>
                <em>¥{{number_format($course['total_purchase'])}}</em>
        </li>
    @endforeach
@else
   <div class="clearfix no-data-found">
       <center class="gray">{{trans('analytics.noTopCourse')}} 
           {{ strtolower( AnalyticsHelper::frequencyReadable($frequency) ) }}</center>
   </div>
@endif