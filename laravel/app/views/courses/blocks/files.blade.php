<p class="tip"> {{ trans('courses/create.upload-files-tip') }}</p>

<form method='post' class='ajax-form clearfix' action='{{action('BlocksController@files', $lesson_id)}}'>
    <input type='hidden' name='_token' value='{{ csrf_token() }}' />
    <div class="fileUpload btn btn-primary">
        <span>{{ trans('administration.browse') }}</span>
        <input type='file' name='file' id='file-upload-{{$lesson_id}}' data-dropzone='.dropzone-{{$lesson_id}}'
       data-progress-bar='.progress-bar-{{$lesson_id}}' data-callback='blockFileUploaded'
       data-add-callback='limitLessonFiles' data-max-upload='{{ Config::get('custom.maximum_lesson_files') }}'
       data-max-upload-error="{{trans('courses/general.max_upload_error')}}" />
    </div>
    <input id="uploadFile" placeholder="{{ trans('courses/curriculum.choose-file') }}" disabled="disabled" />
</form>
<div class="upload-drop-zone dropzone-{{$lesson_id}}" id="dropzone">
    {{ trans('courses/curriculum.just-drag-and-drop-files-here') }}
</div>
<div class="progress">
    <div class="progress-bar progress-bar-striped active progress-bar-{{$lesson_id}}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
        <span></span>
    </div>
</div>
@foreach($lesson->blocks()->where('type','file')->get() as $block)
    {{ View::make('courses.blocks.file')->with(compact('block')) }}
@endforeach