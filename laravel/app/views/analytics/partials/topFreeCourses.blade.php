@if (count($topCourses['data']) > 0)
    @foreach($topCourses['data'] as $key => $course)
        <li>
            <a href="#">
                <span>{{$key+1}}.</span>
                <a href="{{url('analytics/course/'. $course['id'] .'/stats')}}">{{$course['name']}}</a>
                <em>{{number_format($course['total_count'])}}</em>
            </a>
        </li>
    @endforeach
@else
   <div class="clearfix no-data-found">
       <center class="gray">{{trans('analytics.noTopFreeCourse')}}
           {{ strtolower( AnalyticsHelper::frequencyReadable($frequency) ) }}</center>
   </div>
@endif