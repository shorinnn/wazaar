<span id="lesson-{{$lesson->id}}">                     
	<div class="new-lesson
                 @if($lesson->blocks()->where('type','video')->where( 'content','!=','' )->count() > 0 || trim($lesson->external_video_url) != '')
                    green
                 @else
                 	gray
                 @endif
        clearfix"> 
        <div class="buttons">
        </div>
        <div class="lesson-options lesson-options-{{$lesson->id}} row">
            <div class="clearfix lesson-options-buttons">
                <div class="buttons video active">
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
                        style='display:block
                            @if($lesson->external_video_url !='')
                                ;background-color:black
                               @endif
                               '
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
    
</span>