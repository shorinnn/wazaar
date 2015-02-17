@foreach($trackingCodes['data'] as $key => $code)
    <li>
        <a href="#">
            <span>{{$key+1}}.</span>
            <a href="{{url('dashboard/course/'. $code['course_id'] .'/trackingcode/'. $code['tracking_code'] .'/stats')}}">{{$code['tracking_code']}}</a>
            <em>{{$code['count']}}</em>
        </a>
    </li>
@endforeach