<ul class="list-unstyled video-list-thumbs row">
    @if ($videos->count() > 0)
        @foreach($videos->get() as $video)
            <li class="col-lg-3 col-sm-4 col-xs-6">
                <a href="#" title="{{$video->original_filename}}">
                    <img src="{{$video->formats[0]->thumbnail}}" alt="{{$video->original_filename}}" class="img-responsive" height="130px" />
                    <h2><input type="radio" class="radio-video-id" name="radioVideoId" value="{{$video->id}}"> {{$video->original_filename}}</h2>


                    <span class="duration">{{$video->formats[0]->duration}}</span>
                </a>
            </li>
        @endforeach
    @else

    @endif

</ul>