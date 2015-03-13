@if (count($topCourses['data']) > 0)
    @foreach($topCourses['data'] as $key => $course)
        <li>
            <a href="#">
                <span>{{$key+1}}.</span>
                <a href="{{url('dashboard/course/'. $course['id'] .'/stats')}}">{{$course['name']}}</a>
                <em>¥{{number_format($course['total_purchase'],2)}}</em>
            </a>
        </li>
    @endforeach
@else
   <div class="margin-top-15">
       <center class="gray">{{trans('analytics.noTopCourse')}} {{AnalyticsHelper::frequencyReadable($frequency)}}</center>
   </div>
@endif