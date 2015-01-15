<li id="lesson-{{$lesson->id}}">
    {{ trans('general.lesson') }} <span class="lesson-order">{{ $lesson->order }}</span> - 
    <input type="hidden" class="lesson-order ajax-updatable" value="{{$lesson->order}}"
           data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}' data-name='order' /> 
    
    <input type="text" class="ajax-updatable" value="{{$lesson->name}}"
           data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}' data-name='name'  />
    <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
    
    <button type="button" class="btn btn-primary slide-toggler" data-target=".lesson-options-{{$lesson->id}}">
        <i class="fa fa-pencil-square-o" data-target=".lesson-options-{{$lesson->id}}"></i>
    </button>
    
    {{ Form::open(array('action' => ['LessonsController@destroy', $lesson->module->id, $lesson->id], 'method' => 'delete', 
                'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#lesson-'.$lesson->id )) }}
            <button type="submit" name="delete-lesson-{{ $lesson->id }}" class="btn btn-danger btn-mini delete-button" data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i></button>
    {{ Form::close() }}
    <i class="sortable-handle fa fa-bars"></i> 
    
    <div class="lesson-options lesson-options-{{$lesson->id}} row">
        <div class="col-lg-3">
            <a href='#' class='load-remote' data-target='.action-panel-{{$lesson->id}}'
               data-url='{{action('BlocksController@video', [$lesson->id] )}}' data-callback='enableLessonRTE'>
                <i class="fa fa-film"></i>
                <p>{{ trans('general.video') }}</p>
            </a>
        </div>
        <div class="col-lg-3">
            <a href='#' class='load-remote' data-target='.action-panel-{{$lesson->id}}' 
               data-url='{{action('BlocksController@text', [$lesson->id] )}}' data-callback='enableLessonRTE'>
                <i class="fa fa-file-text-o"></i>
                <p>{{ trans('crud/labels.edit_text') }}</p>
            </a>
        </div>
        <div class="col-lg-3">
            <a href='#' class='load-remote' data-target='.action-panel-{{$lesson->id}}' 
               data-url='{{action('BlocksController@files', [$lesson->id] )}}' data-callback='enableBlockFileUploader'>
                <i class="fa fa-file-o"></i>
                <p>{{ trans('general.add_file') }}</p>
            </a>
        </div>
        <div class="col-lg-3">
            <a href='#' class='load-remote' data-target='.action-panel-{{$lesson->id}}' 
               data-url='{{action('LessonsController@details', [$lesson->module->id, $lesson->id] )}}'>
                <i class="fa fa-cog"></i> 
                <p>{{ trans('general.details') }}</p>
            </a>
        </div>
        <div class="col-lg-12 action-panel-{{$lesson->id}}">
        </div>
    </div>
</li>