<div class="video-thumbs clearfix">
    <ul class="list-unstyled video-list-thumbs row no-margin clearfix">
        @if ($videos->count() > 0)
            @foreach($videos as $video)
                <li class="col-xs-6 col-sm-4 col-md-3 col-lg-3 radio-checkbox radio-checked video-thumb-box" id="li-video-{{$video->id}}">
                    <a href="#" title="{{$video->original_filename}}">
                    	<div class="thumb-container relative">
                        	<img src="{{$video->formats[0]->thumbnail}}" alt="{{$video->original_filename}}" class="img-responsive" />
                            <span class="duration">{{$video->formats[0]->duration}}</span>
                        </div>
                        <div>
                            <input type="radio" class="radio-video-id" name="radioVideoId" id="radio-video-{{$video->id}}" value="{{$video->id}}">
                            <label for="radio-video-{{$video->id}}" class="small-radio"></label>
                            <em></em>
                            <span class="file-name">{{$video->trimmed_original_filename}}</span>
                            <i class="wa-check"></i>
                        </div>

                        
                    </a>
                </li>
            @endforeach
        @else

        @endif

    </ul>
    <div class="videos-lookup-pagination-wrapper">
        {{--$videos->appends(Input::only('filter'))->links()--}}
    </div>
</div>
