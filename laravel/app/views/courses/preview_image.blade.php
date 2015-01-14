<div class="col-lg-3">
    @if(get_class($img)=='CoursePreviewImage')
        {{ Form::radio('course_preview_image_id', $img->id, null, ['id' => "img-$img->id"] ) }}
    @else
        {{ Form::radio('course_banner_image_id', $img->id, null, ['id' => "img-$img->id"] ) }}
    @endif
    <label for="img-{{$img->id}}">
        <img src="{{$img->url}}" height="100" />
    </label>
</div>