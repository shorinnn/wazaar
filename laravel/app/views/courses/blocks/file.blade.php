<div class='uploaded-file' id='uploaded-file-{{$block->id}}'>
    <input type='text' class='ajax-updatable' data-url='{{action('BlocksController@update', [$block->lesson->id, $block->id] )}}'
          data-name='name'  value='{{ trim($block->name)=='' ? trans('general.new_file') : $block->name }}' />
    
    
        <div class="buttons"> 
            <!--<i class="sortable-handle fa fa-bars"></i>-->     
            <!--<a href="{{$block->content}}" target="_blank"><button class="btn btn-primary"><i class="fa fa-eye"></i></button></a>-->
            <a href="{{ action('ClassroomController@resource', PseudoCrypt::hash($block->id) ) }}" target="_blank"><button class="btn btn-primary"><i class="fa fa-eye"></i></button></a>
            
            {{ Form::open(array('action' => ['BlocksController@destroy', $block->lesson->id, $block->id], 'method' => 'delete', 
                        'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#uploaded-file-'.$block->id )) }}
                    <button type="submit" class="btn btn-danger btn-mini delete-button" data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i></button>
            {{ Form::close() }}
        </div>
    
</div>