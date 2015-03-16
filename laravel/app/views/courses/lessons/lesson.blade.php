<li id="lesson-{{$lesson->id}}">
<!--<div class="progress">
      <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
        <span class="sr-only">60% Complete</span>
      </div>
    </div>-->                        
	<div class="new-lesson gray clearfix">
        <span>{{ trans('general.lesson') }} 
        	<span class="lesson-order">{{ $lesson->order }}</span> 
        </span>
        <input type="hidden" class="lesson-order ajax-updatable" value="{{$lesson->order}}"
               data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}' data-name='order' /> 
        
        <input type="text" class="ajax-updatable" value="{{$lesson->name}}"
               data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}' data-name='name'  />
        <div class="buttons"> 
            <!--<i class="sortable-handle fa fa-bars"></i>-->     
            <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
            
            <button type="button" class="btn btn-primary slide-toggler edit-lesson" data-target=".lesson-options-{{$lesson->id}}">
                <i class="fa fa-pencil-square-o" data-target=".lesson-options-{{$lesson->id}}"></i>
            </button>
            <div class="sortable-handle menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            {{ Form::open(array('action' => ['LessonsController@destroy', $lesson->module->id, $lesson->id], 'method' => 'delete', 
                        'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#lesson-'.$lesson->id )) }}
                    <button type="submit" name="delete-lesson-{{$lesson->id}}" class="delete-button" data-message="{{ trans('crud/labels.you-sure-want-delete') }}"></button>
            {{ Form::close() }}
        </div>
        <div class="lesson-options lesson-options-{{$lesson->id}} row">
            <div class="clearfix lesson-options-buttons">
                <div class="buttons video active">
                    <!--<div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">60% Complete</span>
                      </div>
                    </div>--> 
                    <em class="processing">Processing</em>                                                                  
                    <a href='#' id="video-link-{{$lesson->id}}" class='load-remote-cache a-add-video' data-target='.action-panel-{{$lesson->id}} .video'
                       data-url='{{action('BlocksController@video', [$lesson->id] )}}' data-callback='activeLessonOption'>
                        <!--<i class="fa fa-film"></i>
                        <p>{{ trans('general.video') }}</p>-->
                        <span></span>                                   
                    </a>
                    <div id="video-player-container">
                    	<p>10:36</p>
                    </div>
                    
                </div>
                <div class="buttons text">
                    <a href='#' class='load-remote-cache' data-target='.action-panel-{{$lesson->id}} .text' 
                       data-url='{{action('BlocksController@text', [$lesson->id] )}}' data-callback='enableLessonRTE'>
                        <!--<i class="fa fa-file-text-o"></i>
                        <p>{{ trans('crud/labels.edit_text') }}</p>-->
                        <span></span>                                   
                    </a>
                </div>
                <div class="buttons file">
                    <a href='#' class='load-remote-cache' data-target='.action-panel-{{$lesson->id}} .files' 
                       data-url='{{action('BlocksController@files', [$lesson->id] )}}' data-callback='enableBlockFileUploader'>
                        <!--<i class="fa fa-file-o"></i>
                        <p>{{ trans('general.add_file') }}</p>-->
                        <span></span>                                   
                    </a>
                </div>
                <div class="buttons setting">
                    <a href='#' class='load-remote-cache' data-target='.action-panel-{{$lesson->id}} .details' 
                       data-url='{{action('LessonsController@details', [$lesson->module->id, $lesson->id] )}}' data-callback='activeLessonOption'>
                        <!--<i class="fa fa-cog"></i> 
                        <p>{{ trans('general.details') }}</p>-->
                        <span></span>                                   
                    </a>
                </div>
            </div>
                <div class="col-lg-12 action-panel-{{$lesson->id}}">
                    <div class="video"></div>
                    <div class="text"></div>
                    <div class="files"></div>
                    <div class="details"></div>
                </div>
        </div>
    </div> 
    <!--<div class="course-create-options clearfix">
        <div>
            <div class="buttons video active">
                <p>10:36 <em>x</em></p>
                <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                    <span class="sr-only">60% Complete</span>
                  </div>
                </div>  
                <em>Processing</em>                                                                  
                <span></span>
            </div>
            <div class="buttons text">
                <span></span>                                   
            </div>
            <div class="buttons file">
                <span></span>                                    
            </div>
            <div class="buttons setting">
                <span></span>                                    
            </div>
            <div class="buttons edit">
                <span></span>                                    
            </div>
        </div>
    </div>-->
</li>