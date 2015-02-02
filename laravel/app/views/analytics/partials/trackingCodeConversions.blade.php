@foreach($trackingCodeConversions['data'] as $key => $course)
    <li>
        <a href="#">
            <span>{{$key+1}}.</span>
            {{$course['tracking_code']}}
            <em>{{number_format($course['purchases'] / $course['hits'] * 100,2)}}%</em>
        </a>
    </li>
@endforeach