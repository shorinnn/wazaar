@foreach($courseConversions['data'] as $key => $course)
    <li>
        <a href="#">
            <span>{{$key+1}}.</span>
            {{$course['name']}}
            <em>{{number_format($course['purchases'] / $course['hits'] * 100,2)}}%</em>
        </a>
    </li>
@endforeach