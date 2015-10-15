<li class="shr-lesson-{{$lesson->id}}">
    <a href="#" data-id='{{ $lesson->id }}' class='lesson-{{$lesson->id}}-copy-name scroll-to-element lesson-li' data-target='div.shr-lesson-{{$lesson->id}}'>
        @if( trim($lesson->name) !='' )
            {{ $lesson->name }}
        @else
            {{trans('courses/create.enter-lesson-name')}}
        @endif
    </a>
</li>