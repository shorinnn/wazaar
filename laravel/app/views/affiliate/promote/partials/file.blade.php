<div id='uploaded-file-{{$file->id}}' style='border:1px solid gray; padding:5px'>
    <div class='row'>
        <div class='col-lg-7'>
            <input type='text' class='form-control ajax-updatable' data-url='{{action('GiftsFileController@update', [$file->id] )}}'
                  data-name='name'  placeholder='{{ trans('courses/promote.new-gift') }}' value='{{ $file->name }}' />
        </div>
        <div class='col-lg-5'>
            <a class='btn btn-primary' href='{{$file->url}}' class='btn btn-primary' target='_blank'>
                {{ trans('courses/student_dash.download') }}
            </a>
            
            {{ Form::open(array('action' => ['GiftsFileController@destroy', $file->id], 'method' => 'delete', 
                        'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#uploaded-file-'.$file->id )) }}
                    <button type="submit" name="delete-file-{{$file->id}}" class="delete-button btn btn-danger" 
                            data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class='fa fa-trash'></i></button>
            {{ Form::close() }}
        </div>
    </div>
</div>