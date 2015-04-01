<div class='gift text-center gift-{{ $gift->id }}' style="border:1px solid gray; padding:10px; margin:5px; margin-top:15px;">
    
    {{ Form::open(array('action' => ['GiftsController@destroy', $gift->id], 'method' => 'delete', 
                        'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '.gift-'.$gift->id )) }}
                    <button type="submit" name="delete-gift-{{$gift->id}}" class="delete-button btn btn-danger" 
                            data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class='fa fa-trash'></i></button>
    {{ Form::close() }}
            
            
    <p>{{ trans('courses/promote.what-to-say') }}?</p>
    {{ Form::open( ['action' => ['GiftsController@update', $gift->id], 'method' => 'PUT', 'class' => 'ajax-form' ] ) }}
        <textarea name='text' id='gift-textarea-{{$gift->id}}'>{{$gift->text}}</textarea>
    {{ Form::close() }}
    <br />
    
    <div class='upload-area'>
        <form method='post' class='ajax-form clearfix' action='{{action('GiftsFileController@store')}}'>
            <input type='hidden' name='_token' value='{{ csrf_token() }}' />
            <input type='hidden' name='gift' value='{{ $gift->id }}' />
            <div class="fileUpload btn btn-primary">
                <span>{{ trans('courses/promote.add-file') }}</span> 
                <input type='file' name='file' id='file-upload-{{$gift->id}}' data-dropzone='.dropzone-{{$gift->id}}'
               data-progress-bar='.progress-bar-{{$gift->id}}' data-callback='giftFileUploaded' />
            </div>
            <input id="uploadFile" placeholder="Choose File" disabled="disabled" />
        </form>
        <div class="upload-drop-zone dropzone-{{$gift->id}}" id="dropzone">
        </div>

        <div class="progress">
            <div class="progress-bar progress-bar-striped active progress-bar-{{$gift->id}}" role="progressbar" 
                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                <span></span>
            </div>
        </div>
    </div>
    
    <div class='files file-{{$gift->id}} file-upload-{{$gift->id}}'>
        
            @foreach($gift->files as $file)
                {{ View::make('affiliate/promote.partials.file')->with( compact('file') ) }}
            @endforeach
    </div>
    <br />
    <br />
    <p>{{ trans('courses/promote.link') }}</p>
    <div class='tooltipable'>
        <input type='text' class='form-control clipboardable' style='width:90%; float:left'
               value='{{action('CoursesController@show', $course->slug)}}?aid={{Auth::user()->affiliate_id}}&gid={{$gift->encryptedID()}}'
               data-clipboard-text='{{action('CoursesController@show', $course->slug)}}?aid={{Auth::user()->affiliate_id}}&gid={{$gift->encryptedID()}}' />
        <button class='btn btn-primary clipboardable'
                data-clipboard-text='{{action('CoursesController@show', $course->slug)}}?aid={{Auth::user()->affiliate_id}}&gid={{$gift->encryptedID()}}'>
            {{ trans('courses/promote.copy') }}</button>
        <br class='clearfix' />
    </div>
</div>