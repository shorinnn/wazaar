@extends('layouts.default')
@section('page_title')
    {{ $course->name }} - Dashboard -
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
           
                     
                        <h4>Announcements Tab</h4>
                        <div style="border:1px solid silver; margin:10px;"  class="tab-pane active" id="announcements">   
                            {{ View::make('courses/instructor/dashboard/announcements')->with(compact('course'))->with( compact('announcements') ) }}
                            
                        </div>
                          
                        <h4>Questions Tab</h4>
                        <div style="border:1px solid silver; margin:10px;"  class="tab-pane" id="questions">
                            
                        </div>
                    
                        <h4>Discussions Tab</h4>
                        <div style="border:1px solid silver; margin:10px;" class="tab-pane" id="discussions">
                            {{ View::make('courses/instructor/dashboard/discussions')->with(compact('course')) }}
                        </div>

                    
                </div>
            </div>
        </div>
</div>
@stop
