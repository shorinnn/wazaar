        <!--<div class="col-xs-6 col-sm-4 col-md-4 radio-checkbox radio-checked">
        	<div class="clearfix">
                @if(get_class($img)=='CoursePreviewImage')
                        {{ Form::radio('course_preview_image_id', $img->id, null, ['id' => "img-$img->id"] ) }}
                @else
                        {{ Form::radio('course_banner_image_id', $img->id, null, ['id' => "img-$img->id"] ) }}
                @endif
                <label class="small-radio" for="img-{{$img->id}}"></label>
                <img src="{{$img->url}}" height="94" width="167" />
                <div class="select-border
                     @if( get_class($img)=='CoursePreviewImage' && $img->id == $course->course_preview_image_id )
                     display-border
                     @endif
                     "></div>
            </div>
        </div>-->
        	
                <li class="col-xs-4 col-sm-4 col-md-3 col-lg-3 radio-checkbox radio-checked image-thumb-box">
                    <a href="#">
                    	<div class="thumb-container relative">
                			<img src="{{$img->url}}" height="94" width="167" />
                        </div>
                        <div class="clearfix" style="position: absolute; height: 102%; width: 100%; top: 0;">
                            @if(get_class($img)=='CoursePreviewImage')
                                    {{ Form::radio('course_preview_image_id', $img->id, null, ['id' => "img-$img->id"] ) }}
                            @else
                                    {{ Form::radio('course_banner_image_id', $img->id, null, ['id' => "img-$img->id"] ) }}
                            @endif
                            <label class="small-radio" for="img-{{$img->id}}"></label>
                            <em></em>
                            <i class="wa-check"></i>
                        </div>

                        
                    </a>
                </li>
