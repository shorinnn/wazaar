@foreach($affiliates as $affiliate)
    <a target="_blank" href="{{ action( 'MembersController@show', $affiliate->id ) }}">{{$affiliate->email}}</a>
@endforeach