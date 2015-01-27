<h1>Oy {{$follower->first_name or $follower->email}}</h1>! 
<p>A new course titled 
    <a href="{{ action('CoursesController@show', $course->slug) }}">{{$course->name}}</a>
has been published by your fav intructor
{{$instructor->first_name}} {{$instructor->last_name}}.</p>

<p><a href="{{ action('CoursesController@show', $course->slug) }}">Go Check it out!</a></p>

<p>{{action('CoursesController@show', $course->slug)}}</p>