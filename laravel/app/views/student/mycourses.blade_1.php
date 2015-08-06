@extends('layouts.default')

@section('page_title')
    Dashboard - 
@stop

@section('content')

<section class="student-teacher-dashboard-wrapper">
	<div class="container">
        <div class='row'>
            <div class='col-md-12'>
            	<div class="student-teacher-dashboard-container">
                <h1> {{trans('site/homepage.my-courses')}} </h1>
                @if($student->courses()->count() == 0 )
                    <p>{{ trans('courses/general.you-have-no-courses') }}</p>
                @else
                    <!--<p>Here are your courses:</p>-->
                    @foreach($student->courses() as $course)
                    <div class="row-1">
                        <div class="course-progress">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active progress-bar-banner" role="progressbar" 
                                     aria-valuenow="{{ $student->courseProgress($course) }}" aria-valuemin="0" 
                                     aria-valuemax="100" style="width: {{ $student->courseProgress($course) }}%;">
                                    <span>{{ $student->courseProgress($course) }}%</span>
                                </div>
                            </div>
                            <p class="completed">{{trans('general.completed')}}</p>
                        </div>
                        <div class="dashboard-content">
                        	<header class="clearfix">
                            	<div class="title">
                        			<h3>{{$course->name}}
                                    	<span>{{$course->courseCategory->name}} <em></em> {{$course->courseSubcategory->name}}</span>
                                    </h3>
                            		
                                </div>
                                <div class="data">
                                	<span class="joined">{{trans('general.joined')}}: 
                                            <em>{{
                                                date('d-m-Y', strtotime($course->sales()->where('student_id',Auth::user()->id)->first()->created_at) ) }} </em></span>
                                    <span class="current-lesson">{{trans('general.current-lesson')}}: 
                                        <?php 
                                            $lastLesson = $student->currentLesson($course);
                                        ?>
                                        @if( $lastLesson == null )
                                        <em>{{trans('general.not-started')}}</em>
                                        @else
                                            {{ $lastLesson->name }}
                                        @endif
                                    </span>
                                </div>
                            </header>
                            <figure>
                                <img
                            	@if($course->course_preview_image_id == null)
                                    src="http://placehold.it/350x150&text={{ trans('general.preview-unavailable') }}"
                                @else
                                    src="{{ cloudfrontUrl( $course->previewImage->url ) }}"
                                @endif
                                 class="img-responsive" alt="">
                            </figure>
                            <section class="clearfix">
                            	<div class="icons clearfix">
                                    <span href="#" class="questions">
                                        <i>{{ $student->sentMessages()->where('course_id', $course->id)->where('type','ask_teacher')->count() }}</i>
                                    </span>
                                    <span class="comments"><i>{{ $course->comments->count() + $course->lessonComments()->count() }}</i></span>
                                    <!--<a href="#" class="edit"></a>-->
                                </div>
                                <p class="description">
                                    {{ $course->description }}
                                </p>
                                <div class="buttons">
    		                        <a href='{{ action("ClassroomController@dashboard", $course->slug )}}' class="go-to-dashboard">{{trans('general.go-to-dashboard')}}</a>
                                        @if( $lastLesson != null )
                                        <a href="{{ action('ClassroomController@lesson',
                                                    [ 'course' => $course->slug, 'module' => $lastLesson->module->slug, 'lesson' => $lastLesson->slug ])}}" class="continue-last-lesson">{{trans('general.continue-last-lesson')}}</a>                            
                                        @endif
                                </div>
                            </section>
                        </div>
                    </div>
                    @endforeach
                @endif
                </div>
            </div>

        </div>
    </div>
</section>
@stop