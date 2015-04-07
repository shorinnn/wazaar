@extends('layouts.default')
@section('page_title')
    {{ $course->name }} - {{ trans('courses/dashboard.dashboard') }} -
@stop
@section('content')	
    <div class="container course-editor">
    	<div class="row">
        	<div class="col-md-12">
            	<h1 class='icon'>{{$course->name}}</h1>   
            </div>
        </div>
       
        <div class="row">
        	<div class="col-md-12">
            	<div class="plan-your-curriculum">
           
                     
                        <h4>{{ trans('courses/dashboard.announcements-tab') }}</h4>
                        <div style="border:1px solid silver; margin:10px;"  class="tab-pane active" id="announcements">   
                            {{ View::make('courses/instructor/dashboard/announcements')->with(compact('course'))->with( compact('announcements') ) }}
                            
                        </div>
                          
                        <h4>{{ trans('courses/dashboard.questions-tab') }}</h4>
                        <div style="border:1px solid silver; margin:10px;"  class="tab-pane" id="questions">
                            {{ View::make('courses/instructor/dashboard/questions')->with(compact('course')) }}
                        </div>
                    
                        <h4>{{ trans('courses/dashboard.discussions-tab') }}</h4>
                        <div style="border:1px solid silver; margin:10px;" class="tab-pane" id="discussions">
                            {{ View::make('courses/instructor/dashboard/discussions')->with(compact('course')) }}
                        </div>

                    
                </div>
            </div>
        </div>
        
    <div class="modal fade" id="reply-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('conversations/general.reply') }}</h4>
            </div>
            <div class="modal-body clearfix">

                <form method="post" action="{{ action( 'CoursesController@reply' ) }}" class="ajax-form"
                      id='reply-form'
                      data-callback='instructorReplied'>
                    <textarea class='form-control' name="reply" id="reply-form-reply"></textarea>
                    <input type="hidden" name="id" id="reply-form-id" />
                    <input type="hidden" name="type" id="reply-form-type" />
                    <button type='submit' class="btn btn-primary">{{ trans('conversations/general.reply') }}</button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        
</div>
@stop
