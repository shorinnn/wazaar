        <div class="col-xs-6 col-sm-4 col-md-3 radio-checkbox radio-checked">
        	<div class="clearfix">
                @if(get_class($img)=='CoursePreviewImage')
                        {{ Form::radio('course_preview_image_id', $img->id, null, ['id' => "img-$img->id"] ) }}
                @else
                        {{ Form::radio('course_banner_image_id', $img->id, null, ['id' => "img-$img->id"] ) }}
                @endif
                <label class="small-radio" for="img-{{$img->id}}"></label>
                <img src="{{$img->url}}" height="120" width="120" />
                <div class="select-border
                     @if( get_class($img)=='CoursePreviewImage' && $img->id == $course->course_preview_image_id )
                     display-border
                     @endif
                     "></div>
            </div>
        </div>
