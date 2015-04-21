<div class="video-thumbs">
    <ul class="list-unstyled video-list-thumbs row radio-buttons clearfix">
        @if ($videos->count() > 0)
            @foreach($videos as $video)
                <li class="col-lg-4 col-sm-4 col-xs-6 radio-checkbox radio-checked">
                    <a href="#" title="{{$video->original_filename}}">
                        <img src="{{$video->formats[0]->thumbnail}}" alt="{{$video->original_filename}}" class="img-responsive" height="130px" />
                        <h2>
                            <input type="radio" class="radio-video-id" name="radioVideoId" id="radio-video-{{$video->id}}" value="{{$video->id}}">
                            <label for="radio-video-{{$video->id}}" class="small-radio"></label>
                            <span class="file-name">{{$video->original_filename}}</span>
                        </h2>

                        <span class="duration">{{$video->formats[0]->duration}}</span>
                    </a>
                </li>
            @endforeach
        @else

        @endif

    </ul>
    <div class="videos-lookup-pagination-wrapper">
        {{$videos->appends(Input::only('filter'))->links()}}
    </div>
</div>
