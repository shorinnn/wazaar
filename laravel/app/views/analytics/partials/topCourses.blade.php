@foreach($topCourses['data'] as $key => $course)
    <li>
        <a href="#">
            <span>{{$key+1}}.</span>
            <a href="{{url('dashboard/course/'. $course['id'] .'/stats')}}">{{$course['name']}}</a>
            <em>¥{{number_format($course['total_purchase'],2)}}</em>
        </a>
    </li>
@endforeach