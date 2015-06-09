 <tr id='row-{{$i}}' data-id='{{$video->id}}' data-row-cur-val='{{$i}}'>
    <td>{{ $i }}</td>
    <td>
        <select class='select2' name='video[{{$video->id}}]'>
            <option value='0'>{{ trans('frontpage-videos.random') }}</option>
            @foreach($courses as $course)
                <option
                    @if($course->id == $video->course_id)
                        selected='selected'
                    @endif
                    value='{{$course->id}}'>{{$course->name}}</option>
            @endforeach
        </select>
    </td>
    <td>
        @if($video->type=='big')
        *{{ trans('frontpage-videos.big') }}
        @endif
    </td>
</tr>