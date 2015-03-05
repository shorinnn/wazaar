@extends('layouts.default')
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
                    
                    <div role="tabpanel">

                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist" id='myTab'>
                        <li role="presentation" class="active"><a href="#announcements" aria-controls="announcements" role="tab" data-toggle="tab">Announcements</a></li>
                        <li role="presentation"><a href="#questions" aria-controls="questions" role="tab" data-toggle="tab">Questions</a></li>
                        <li role="presentation"><a href="#" aria-controls="?" role="tab" data-toggle="tab">?</a></li>
                        <li role="presentation"><a href="#" aria-controls="?" role="tab" data-toggle="tab">?</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="announcements">   
                            
                            {{ View::make('courses/instructor/dashboard/announcements')->with(compact('course'))->with( compact('announcements') ) }}
                            
                        </div>
                          
                        <div role="tabpanel" class="tab-pane" id="questions">...</div>
                        <div role="tabpanel" class="tab-pane" id="?">...</div>
                        <div role="tabpanel" class="tab-pane" id="?">...</div>
                      </div>

                    </div>
                    
                    
                </div>
            </div>
        </div>
</div>
@stop
