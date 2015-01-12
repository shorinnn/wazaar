@extends('layouts.default')
@section('content')	
<style>
    .ui-select{
        position:relative;
    }
</style>
<div class="container create-course">
<div class="row">
	<div class="col-md-12">
        <h1>Creating a course
        	<small>The world is yours to conquer.</small>
		</h1>      
        <div id='step1'>
            <form method='post' class='ajax-form' id="create-form" data-callback='prepareCourseDetails' 
                  action='{{action('CoursesController@store')}}' data-parsley-validate>
                <h2>Enter Course Name</h2>
                <input type='hidden' name='_token' value='{{csrf_token()}}' />
                <input type='text' name='name' id='name' required /><br />
                <button type='submit' class='btn btn-primary'>Create Course</button>
            </form>
        </div>
    <form method='post' class='ajax-form' id='edit-course-details-form' data-callback='followRedirect' data-parsley-validate >
        <div id='step2' class='#'>
	        <h2>What category is your course in?</h2>
            <div class="ui-select">
            {{ Form::select('course_category_id', $categories, null,  
                        ['onChange'=>'populateDropdown(this)', 'data-target'=>'#course_subcategory_id', 
                        'data-url'=> action('CoursesCategoriesController@subcategories'), 'required']) }}
            </div>
            <h2>What sub-category?</h2>
            	<div class="ui-select">
                    <select class="ui-select" name='course_subcategory_id' id='course_subcategory_id' required>
                        <option value=''>Select category...</option>
                    </select><br />
                </div>
                <button class='btn btn-primary' type="button" onclick='unhide("#step3")'>Next Step</button>
        </div>
        
            <input type='hidden' name='_token' value='{{csrf_token()}}' />
            <input type='hidden' name='_method' value='PUT' />
            <h1>Set your course objectives
               <small>This helps you with creating a great course that people will talk about and love</small>
            </h1>        
            <div id='step3' class='#'>
                 <h2>Course Level</h2>
                 <div class="course-level btn-group clearfix" data-toggle="buttons">
                     @foreach($difficulties as $key=>$difficulty)
                     	<label class="btn btn-primary">
                         	<input type='radio' name='course_difficulty_id' id="option{{$key}}" autocomplete="off" value='{{$key}}' required /> {{$difficulty}}
                        </label>
                     @endforeach
        		 </div>
                 <div class="what-you-will-achieve">
                     <h2>By the end of the course your students will be able to...</h2>
                     <p class="tip">Make it results based</p>
                     <div>
                         <input type='text' name='what_will_you_achieve[]' class="clonable" required />
                         <span>1</span>
                         <!--<a href="#" class="style-one"></a>-->
                     </div>
<!--                     <div>
                         <input type='text' name='what_will_you_achieve[]' class="clonable" />
                         <span>2</span>
                         <a href="#" class="style-two"></a>
                     </div>-->
                     <a href="#" class="help-tip">Help</a>
        		 </div>
                 <div class="who-its-for">
                     <h2>This course is for your student if your student is...</h2>
                     <p>
                     te irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                     Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. 
                     ed ut perspiciatis unde omnis iste natus  error sit.
                     </p>
                     <div>
                         <input type='text' name='who_is_this_for[]'  class="clonable" required /><br />
                         <span>1</span>
                         <!--<a href="#" class="style-one"></a>-->
                     </div>
<!--                     <div>
                         <input type='text' name='who_is_this_for[]'  class="clonable" /><br />
                         <span>2</span>
                         <a href="#" class="style-two"></a>
                     </div>-->
                     <a href="#" class="help-tip">Help</a>
<!--                     <div>
                         <input type='text' name='who_is_this_for[]'  class="clonable its-for-you" / placeholder="This course if for you if you are..."><br />
                     </div>-->
                     <button type="submit" class='btn btn-primary clear start-creating'>Start Creating Lessons</button>
                 </div>
            </div>
        </form>
		<div class="steps-meter">
        	<p class="active" data-target='#step1'><span class="step-one"></span><em>Step 1</em></p>
        	<p data-target='#step2'><span class="step-two"></span><em>Step 2</em></p>
        	<p data-target='#step3'><span class="step-three"></span><em>Step 3</em></p>
        </div>
    </div>
</div>
</div>

@stop