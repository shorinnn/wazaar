<div id='uploaded-file-{{$file->id}}' style='padding:5px'>
    <div class='row'>
        <div class='col-lg-9'>
            <input type='text' class='form-control ajax-updatable' data-url='{{action('GiftsFileController@update', [$file->id] )}}'
                  data-name='name'  placeholder='{{ trans('courses/promote.new-gift') }}' value='{{ $file->name }}' style='width:88%' />
            <a href='{{ $file->presignedUrl() }}' target='_blank' title='{{ trans('courses/student_dash.download') }}'>
                <i class='fa fa-download'></i>
            </a>
        </div>
        <div class='col-lg-3'>            
            {{ Form::open(array('action' => ['GiftsFileController@destroy', $file->id], 'method' => 'delete', 
                        'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#uploaded-file-'.$file->id )) }}
                    <button type="submit" name="delete-file-{{$file->id}}" class="delete-button btn btn-link" 
                            data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i>Delete</button>
            {{ Form::close() }}
        </div>
    </div>
</div>