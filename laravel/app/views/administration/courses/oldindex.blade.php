@extends('layouts.default')

@section('content')	
<div class="col-lg-10 col-lg-offset-1 course-categories">
	<div class="row">
    	<div class="col-md-12">
            <h1 class='icon'>Courses</h1>
        </div>
    </div>
	<div class="row">
    	<div class="col-md-12">
            <div class="courses-listings-container ajax-content row">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bcourseed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course Name</th>
                                <th>Course Category</th>
                                <th>Course Subcategory</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $i => $course)
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$course->name}}</td>
                                <td>
                                    @if(isset($course->courseCategory->name) && !empty($course->courseCategory->name))
                                        {{$course->courseCategory->name}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($course->courseSubcategory->name) && !empty($course->courseSubcategory->name))
                                        {{$course->courseSubcategory->name}}
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
		</div>
	</div>
</div>

@stop