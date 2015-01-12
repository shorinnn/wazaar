<div id='uploaded-file-{{$block->id}}'>
    <a href="{{$block->content}}" target="_blank">File {{$block->id}}</a>
    
    {{ Form::open(array('action' => ['BlocksController@destroy', $block->lesson->id, $block->id], 'method' => 'delete', 
                'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#uploaded-file-'.$block->id )) }}
            <button type="submit" class="btn btn-danger btn-mini delete-button" data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i></button>
    {{ Form::close() }}
    
</div>