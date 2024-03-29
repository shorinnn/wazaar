<li id="uploaded-file-{{$file->id}}">
    <span class="file-name">
        @if( strpos( $file->mime, 'image')!== false )
        <i class="fa fa-file-image-o"></i> 
        @elseif( strpos( $file->mime, 'pdf' ) !== false )
        <i class="fa fa-file-pdf-o"></i> 
        @else
        <i class='fa fa-file-text'></i>
        @endif

        {{ $file->name }}
    </span>
    @if($file->size=='')
        <span class="file-size calculate-file-size calculate-file-size-{{$file->id}}" data-id='{{$file->id}}'>calculating...</span>
    @else
        <span class="file-size" data-id='{{$file->id}}'>{{ $file->size() }}</span>
    @endif

   <!-- {{ Form::open(array('action' => ['BlocksController@destroy', $file->lesson->id, $file->id], 'method' => 'delete', 
                                    'class' => 'delete-file ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#uploaded-file-'.$file->id )) }}
    <button type="submit" class="btn btn-danger btn-mini delete-button" data-message="{{ trans('crud/labels.you-sure-want-delete') }}">
        <i class="fa fa-trash-o"></i>
    </button>
    {{ Form::close() }}-->

    <!--<a href="#" class="delete-file"><i class="fa fa-trash-o"></i></a>-->
     <a href="{{ action('BlocksController@destroy', [ $file->lesson->id, $file->id]) }}" class="delete-file right link-to-remote-confirm"
                   data-url="{{ action('BlocksController@destroy', [ $file->lesson->id, $file->id]) }}" data-callback = 'deleteAttachment' 
                   data-lesson='{{$file->lesson->id}}'
                   data-delete = '#uploaded-file-{{$file->id}}' data-message="{{ trans('crud/labels.you-sure-want-delete') }}">
         
                    <i class="fa fa-trash-o" data-callback = 'deleteAttachment'  data-delete = '#uploaded-file-{{$file->id}}'
                       data-lesson='{{$file->lesson->id}}'
                       data-message="{{ trans('crud/labels.you-sure-want-delete') }}" 
                       data-url="{{ action('BlocksController@destroy', [ $file->lesson->id, $file->id]) }}" ></i>
                </a>
    <a href="{{ action('ClassroomController@resource', PseudoCrypt::hash($file->id) ) }}" target="_blank" class="upload-new-file">
        <i class="fa fa-download"></i>
    </a>
</li>