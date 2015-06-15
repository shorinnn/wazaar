<style>
    .lesson-no-video{
        display:none;
    }
</style>
<li id="lesson-{{$lesson->id}}">
<!--<div class="progress">
      <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
        <span class="sr-only">60% Complete</span>
      </div>
    </div>-->                        
	<div class="new-lesson
                 @if($lesson->blocks()->where('type','video')->where( 'content','!=','' )->count() > 0)
                    green
                 @else
                 	gray
                 @endif
        clearfix">
        <span>{{ trans('general.lesson') }} 
        	<span class="lesson-order">{{ $lesson->order }}</span> 
        </span>
        <input type="hidden" class="lesson-order ajax-updatable" value="{{$lesson->order}}"
               data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}' data-name='order' /> 
        
        <input type="text" class="ajax-updatable" value="{{$lesson->name}}"
               data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}'
               placeholder="{{trans('courses/create.enter-lesson-name')}}" data-name='name'  />
        <div class="buttons"> 
            <!--<i class="sortable-handle fa fa-bars"></i>-->   
            <a target="_blank" href="{{ action('ClassroomController@lesson',[
                'course' => $lesson->module->course->slug,
                'module' => $lesson->module->slug,
                'slug' => $lesson->slug
            ])}}">
            <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
            </a>
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
            <div class="clearfix lesson-options-buttons
                 @if($lesson->blocks()->where('type','video')->where( 'content','!=','' )->count() == 0)
                    lesson-no-video
                 @endif
                 ">
                <div class="buttons video active">
                    <!--<div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">60% Complete</span>
                      </div>
                    </div>--> 
                    <em class="processing">Processing</em>                                                                  
                    <a href='#' id="video-link-{{$lesson->id}}" class='load-remote-cache a-add-video
                       @if($lesson->blocks()->where('type','video')->count() > 0)
                        done
                       @endif
                       ' data-target='.action-panel-{{$lesson->id}} .video'
                       data-url='{{action('BlocksController@video', [$lesson->id] )}}' data-callback='enableVideoOption'>
                        <!--<i class="fa fa-film"></i>
                        <p>{{ trans('general.video') }}</p>-->
                        <span></span>                                   
                    </a>
                    <div id="video-thumb-container"
                       @if($lesson->blocks()->where('type','video')->count() > 0)
                        style='display:block'
                       @endif
                       >


                       @if(
                            $lesson->blocks()->where('type','video')->where('content','>','0')->count() > 0
                            && @$lesson->blocks()->where('type','video')->where('content','>','0')->first()->video()
                        )
                    	<P>{{@$lesson->blocks()->where('type','video')->where('content','>','0')->first()->video()->formats[0]->duration }}</P>
                        <a href='#' class='fa fa-eye' onclick="videoModal.show(this, event)" data-filename="{{$lesson->blocks()->where('type','video')->where('content','>','0')->first()->video()->original_filename}}" data-video-url="{{@$lesson->blocks()->where('type','video')->where('content','>','0')->first()->video()->formats[0]->video_url }}"></a>
                        <img src='{{@$lesson->blocks()->where('type','video')->where('content','>','0')->first()->video()->formats[0]->thumbnail }}'/>
                       @endif
                    </div>
                    
                </div>
                <div class="buttons text">
                    <a href='#' class='load-remote-cache
                       @if($lesson->blocks()->where('type','text')->count() > 0 && 
                       strip_tags( $lesson->blocks()->where('type','text')->first()->content)  != '')
                        done
                       @endif
                       ' data-target='.action-panel-{{$lesson->id}} .text' 
                       data-url='{{action('BlocksController@text', [$lesson->id] )}}' data-callback='enableLessonRTE'>
                        <!--<i class="fa fa-file-text-o"></i>
                        <p>{{ trans('crud/labels.edit_text') }}</p>-->
                        <span></span>                                   
                    </a>
                </div>
                <div class="buttons file">
                    <a href='#' class='load-remote-cache
                       @if($lesson->blocks()->where('type','file')->count() > 0)
                        done
                       @endif
                       ' data-target='.action-panel-{{$lesson->id}} .files' 
                       data-url='{{action('BlocksController@files', [$lesson->id] )}}' data-callback='enableBlockFileUploader'>
                        <!--<i class="fa fa-file-o"></i>
                        <p>{{ trans('general.add_file') }}</p>-->
                        <span></span>                                   
                    </a>
                </div>
                <div class="buttons setting">
                    <a href='#' class='load-remote-cache
                       @if($lesson->description!='' || $lesson->price>0 || $lesson->published=='yes')
                        done
                       @endif
                       ' data-target='.action-panel-{{$lesson->id}} .details' 
                       data-url='{{action('LessonsController@details', [$lesson->module->id, $lesson->id] )}}' data-callback='enableSettingOption'>
                        <!--<i class="fa fa-cog"></i> 
                        <p>{{ trans('general.details') }}</p>-->
                        <span></span>                                   
                    </a>
                </div>
                <div class="buttons publish">
                    <p>{{ trans('general.published') }}</p> 
                    <div class="switch-buttons">
                        <label class="switch">
                          <input type="checkbox" class="switch-input ajax-updatable"  value='{{ trans('courses/curriculum.yes') }}'
                                 data-checked-val='{{ trans('courses/curriculum.yes') }}' data-unchecked-val='{{ trans('courses/curriculum.no') }}'
                                 data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}'
                                      data-name='published'
                                 @if($lesson->published=='yes')
                                     checked="checked"
                                 @endif
                                 />
                          <span data-off="{{ trans('courses/curriculum.no') }}" data-on="{{ trans('courses/curriculum.yes') }}" class="switch-label"></span>
                          <span class="switch-handle"></span>
                        </label>
                    </div>
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

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Video title</h4>
          </div>
          <div class="modal-body" id="uploadedVideoPlayer">
          </div>
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