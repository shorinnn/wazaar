@foreach($courseConversions['data'] as $key => $course)
    <li>
        <a href="#">
            <span>{{$key+1}}.</span>

            <a href="{{url('dashboard/course/'. $course['product_id'] .'/stats')}}">{{$course['name']}}</a>
            <em>{{number_format($course['purchases'] / $course['hits'] * 100,2)}}%</em>
        </a>
    </li>
@endforeach