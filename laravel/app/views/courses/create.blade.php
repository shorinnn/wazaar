@extends('layouts.default')
@section('content')	

<h1>Creating a course</h1>      
The world is yours to conquer.

<div id='step1'>
    <form method='post' class='ajax-form' data-callback='prepareCourseDetails' action='{{action('CoursesController@store')}}'>
        <h1>Enter Course Name</h1>
        <input type='hidden' name='_token' value='{{csrf_token()}}' />
        <input type='text' name='name' id='name' /><br />
        <button type='submit' class='btn btn-primary'>Create Course</button>
    </form>
</div>
<form method='post' class='ajax-form' id='edit-course-details-form'>
    <input type='hidden' name='_method' value='PUT' />
    <div id='step2' class='hidden'>
        <h1>What category is your course in?</h1>
        {{ Form::select('course_category_id', $categories, null,  
                    ['onChange'=>'populateDropdown(this)', 'data-target'=>'#course_subcategory_id', 'data-url'=> action('CoursesCategoriesController@subcategories')]) }}
        <h1>What sub-category?</h1>
        <select name='course_subcategory_id' id='course_subcategory_id'><option value='0'>Select category...</option></select><br />
        <button class='btn btn-primary' onclick='unhide("#step3")'>Next Step</button>
    </div>

    <div id='step3' class='hidden'>
         <h1>Set your course objectives</h1>
         This helps you with creating a great course that people will talk about and love
         <h3>Course Level</h3>
         @foreach($difficulties as $key=>$difficulty)
             <input type='radio' name='course_difficulty_id' value='{{$key}}' /> {{$difficulty}}
         @endforeach

         <h3>By the end of the course your students will be able to...</h3>
         <input type='text' name='what_will_you_achieve[]' />

         <h3>This course is for your student if your student is...</h3>
         <input type='text' name='who_is_this_for[]' /><br />
         <button class='btn btn-primary'>Start Creating Lessons</button>
    </div>
</form>
<script type="text/javascript">
    var _globalObj = {{ json_encode(array('_token'=> csrf_token())) }}
</script>
@stop