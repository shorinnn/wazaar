<li id="uploaded-file-{{$file->id}}">
    <a href="{{ action('ClassroomController@resource', PseudoCrypt::hash($file->id) ) }}" target="_blank" class="upload-new-file" onclick="event.stopPropagation()">
        @if( strpos( $file->mime, 'image')!== false )
        <i class="fa fa-file-image-o"></i> 
        @elseif( strpos( $file->mime, 'pdf' ) !== false )
        <i class="fa fa-file-pdf-o"></i> 
        @else
        <i class='fa fa-file-text'></i>
        @endif

        {{ $file->name }}
    </a>  
    @if($file->size=='')
        <span class="file-size calculate-file-size calculate-file-size-{{$file->id}}" data-id='{{$file->id}}'>calculating...</span>
    @else
        <span class="file-size" data-id='{{$file->id}}'>{{ $file->size() }}</span>
    @endif
    
</li>