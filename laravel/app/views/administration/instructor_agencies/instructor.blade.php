@foreach($instructors as $instructor)
    <a target="_blank" href="{{ action( 'MembersController@show', $instructor->id ) }}">{{$instructor->email}}</a>
@endforeach