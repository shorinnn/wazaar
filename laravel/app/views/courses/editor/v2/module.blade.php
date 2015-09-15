<div class="shr-editor-module shr-editor-module-{{$module->id}} 
     @if( $module->name != '')
         module-minimized
     @endif
     ">
    <div class="module-zone">
        {{ Form::model( $module, ['action' => ['ModulesController@update', $module->course->id, $module->id], 'method' => 'PUT', 'class' => 'ajax-form', 
                    'data-callback' => 'minimizeAfterSave', 'data-elem' => ".shr-editor-module-".$module->id] ) }}
            <div class="row module-data no-margin toggle-minimize" data-class='module-minimized' 
                 data-toggle-icon=".toggle-module-id{{$module->id}}" data-target='div.shr-editor-module-{{$module->id}}'>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <span class="module-name">
                        {{ trans('general.module') }} 
                        <span data-id="{{$module->id}}" class="module-order">{{$module->order}}</span></span>
                </div>
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                    <!--<input type="text" name="module-name" placeholder="Enter module title">-->
                    <h2>
                        <span class='minimized-elem shr-editor-module-{{$module->id}}-copy-name'>{{$module->name}}</span>
                        <input class='type-in-elements' data-elements='.shr-editor-module-{{$module->id}}-copy-name' type="text" 
                               placeholder="{{trans('courses/create.enter-module-name')}}" name="name" value="{{ $module->name }}" /> 
                        <a data-class='module-minimized' 
                           data-target='div.shr-editor-module-{{$module->id}}' 
                           class="edit-icon toggle-minimize">
                            <i class="fa fa-pencil
                               @if( $module->name == '')
                                   fa-compress
                               @endif toggle-module-id{{$module->id}}"  
                               data-class='module-minimized' 
                               data-target='div.shr-editor-module-{{$module->id}}' ></i>
                        </a>
                    </h2>
        <!--            <p class="regular-paragraph description-text">In this module, you will become familiar with the course, your 
                        instructor, your classmates, and our learning environment. Then, you will learn how new digital 
                        tools are enabling customers to take a more active role in developing and branding the products 
                        they consume. <button class="edit-icon"><i class="fa fa-pencil"></i></button>
                    </p>-->
                    <div class="textarea-wrap">
                        <textarea name="description" placeholder="{{trans('courses/create.enter-description')}}" class="type-in-elements"
                                  data-elements='.minimized-desc-{{$module->id}}' >{{ $module->description }}</textarea>
                    </div>
                    <div class="minimized-description minimized-elem minimized-desc-{{$module->id}}">{{ $module->description }}</div>
                </div>
            </div>
            <div class="row footer-buttons no-margin">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <button type="submit" class="green-button large-button">{{ trans('courses/general.saving-button') }}</button>
                    <button type="reset" class="default-button large-button toggle-minimize" data-class='module-minimized' 
                 data-toggle-icon=".toggle-module-id{{$module->id}}" data-target='div.shr-editor-module-{{$module->id}}'>{{ trans('courses/create.cancel') }} </button>
                    
                    <a href="{{ action('ModulesController@destroy', [ $module->course->id, $module->id]) }}" class="delete-lesson right link-to-remote-confirm"
                       data-url="{{ action('ModulesController@destroy', [ $module->course->id, $module->id]) }}" data-callback = 'deleteCurriculumItem' 
                       data-delete = '.shr-editor-module-{{ $module->id }}' data-message="{{ trans('crud/labels.you-sure-want-delete') }}">
                        <i class="fa fa-trash-o" data-callback = 'deleteCurriculumItem' data-delete = '.shr-editor-module-{{ $module->id }}'
                           data-message="{{ trans('crud/labels.you-sure-want-delete') }}" 
                           data-url="{{ action('ModulesController@destroy', [ $module->course->id, $module->id]) }}" ></i> 
                        {{ trans('courses/create.delete-this-module') }}
                    </a>
                </div>
            </div>
        {{ Form::close() }}
    </div>
    <div class="lesson-container">
        @foreach($module->lessons()->orderBy('order','asc')->get() as $lesson)
            {{ View::make('courses.editor.v2.lesson')->with( compact('lesson') )->render() }}
        @endforeach
    </div>
    <div class="text-center">
        <!--<a href="#" class="add-new-lesson">ADD NEW LESSON</a>-->
         <form method='post' class='ajax-form' id="modules-form" data-callback='addLesson'
          action='{{action('LessonsController@store', $module->id)}}'>
            <input type='hidden' name='_token' value='{{ csrf_token() }}' />
            <button type='submit' class='add-new-lesson' style='width:100%; display:block'>{{ trans('crud/labels.add_lesson') }}</button>
        </form>
    </div>
</div>