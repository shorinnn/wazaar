@extends('layouts.default')
@section('content')
    <div class="container-fluid new-dashboard student-messages">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 message-preview-wrap">
                	<div class="row message-header">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <h3>Messages</h3>
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            <form>
                                <div>
                                    <input type="search" placeholder="Search conversations ..." />
                                    <button><i class="wa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @foreach($discussions as $discussion)
                    <a href="#" data-no-prevent-default='1' data-no-push-state="1" class="load-remote"  data-loading-container=".full-messages"
                       data-url="{{ action('CoursesController@viewDiscussion', $discussion->id)}}" data-target=".full-messages"> 
                        <div class="row message-preview">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="avatar">
                                    @if( $discussion->lesson->module->course->instructor_id == $discussion->student_id 
                                    || $discussion->lesson->module->course->assigned_instructor_id == $discussion->student_id )
                                        <img src="{{ $discussion->student->commentPicture('Instructor') }}" alt="" class="img-responsive">
                                    @else
                                        <img src="{{ $discussion->student->commentPicture('Student') }}" alt="" class="img-responsive">
                                    @endif
                                    
                                </div>
                            </div>
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                    <div class="message">
                                    <h4>{{ $discussion->student->fullName() }}</h4>
                                    <p class="regular-paragraph" style="font-weight: bold">{{ Str::limit( $discussion->title, 20) }}</p>
                                    <p class="regular-paragraph">{{ Str::limit( $discussion->content, 100) }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                    {{ $discussions->links() }}
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 full-messages">

                </div>
            </div>
        </div>    
    </div>
@stop
