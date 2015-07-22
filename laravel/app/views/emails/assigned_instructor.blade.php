<p>{{$assigned->first_name }} 様</p>

<p>{{$instructor->first_name}} 様から</p>

<p>{{ $course->name }} に講師とてご招待されていますので、<br />
下記のリンクをクリックしてご承認をお願い致します。<br />
<a href="{{ action('CoursesController@edit', $course->slug) }}">{{ action('CoursesController@edit', $course->slug) }}</a><br />
お手続き何卒よろしくお願い致します。<br />
ワザール事務局</p>