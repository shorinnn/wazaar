List of new discussions posted on your courses:<br />
@foreach($discussions as $discussion)
<a href="#">{{$discussion->title}}</a><br />
@endforeach