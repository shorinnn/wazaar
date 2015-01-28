@foreach($topCourses['data'] as $key => $course)
    <li>
        <a href="#">
            <span>{{$key+1}}.</span>
            {{$course['name']}}
            <em>¥{{number_format($course['total_purchase'],2)}}</em>
        </a>
    </li>
@endforeach