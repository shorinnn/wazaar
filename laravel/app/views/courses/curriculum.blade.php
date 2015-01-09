@extends('layouts.default')
@section('content')	
<style>
    #modules-list > li{
        border:1px solid gray;
        background-color:silver;
        padding:10px;
    }
    
    .lessons > li{
        background-color: white;
        padding:10px;
        border-bottom: 1px solid gray;
    }
    .inline-block{
        display:inline-block;
    }
</style>
<h1>{{$course->name}}</h1>    
<div>
    <div class="col-lg-6">
        By the end of this course, your students will be able to...
        @foreach( json2Array($course->what_will_you_achieve) as $skill)
            <p>{{ $skill }}</p>
        @endforeach
    </div>
    <div class="col-lg-6">
        This is for those who...
        @foreach( json2Array($course->who_is_this_for) as $for)
            <p>{{ $for }}</p>
        @endforeach
    </div>
</div>
<h3>Plan out your curriculum</h3>
<h4>Outline your modules and lessons that your students will go through.</h4>
<ul id="modules-list">
    @foreach($course->modules()->orderBy('order','ASC')->get() as $module)
        {{ View::make('courses.modules.module')->with(compact('module')) }}
    @endforeach
</ul>

<form method='post' class='ajax-form' id="modules-form" data-callback='addModule'
      action='{{action('ModulesController@store')}}'>
    <input type='hidden' name='_token' value='{{ csrf_token() }}' />
    <input type='hidden' name='course_id' value='{{ $course->id }}' />
    <button type='submit' class='btn btn-primary'>Add Module</button>
</form>


@stop