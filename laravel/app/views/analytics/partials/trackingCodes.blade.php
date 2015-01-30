@foreach($trackingCodes['data'] as $key => $code)
    <li>
        <a href="#">
            <span>{{$key+1}}.</span>
            {{$code['tracking_code']}}
            <em>{{$code['count']}}</em>
        </a>
    </li>
@endforeach