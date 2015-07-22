<div class="shr-editor shr-editor-module-{{$module->id}}">
    {{ Form::model( $module, ['action' => ['ModulesController@update', $module->course->id, $module->id], 'method' => 'PUT', 'class' => 'ajax-form' ] ) }}
        <div class="row module-data">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                <span class="module-name">Module <span data-id="{{$module->id}}" class="module-order">{{$module->order}}</span></span>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <!--<input type="text" name="module-name" placeholder="Enter module title">-->
                <h2><input type="text" name="name" value="{{ $module->name }}" /> <button class="edit-icon"><i class="fa fa-pencil"></i></button></h2>
    <!--            <p class="regular-paragraph description-text">In this module, you will become familiar with the course, your 
                    instructor, your classmates, and our learning environment. Then, you will learn how new digital 
                    tools are enabling customers to take a more active role in developing and branding the products 
                    they consume. <button class="edit-icon"><i class="fa fa-pencil"></i></button>
                </p>-->
                <textarea name="description" placeholder="Enter description...">{{ $module->description }}</textarea>
            </div>
        </div>
        <div class="row footer-buttons">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!--<a href="#" class="green-button large-button">Save changes</a>-->
                <button type="submit" class="green-button large-button">Save changes</button>
                <!--<a href="#" class="default-button large-button">Cancel</a>-->
                <button type="reset" class="default-button large-button">Cancel</button>
                
                
                <a href="{{ action('ModulesController@destroy', [ $module->course->id, $module->id]) }}" class="delete-lesson right link-to-remote-confirm"
                   data-url="{{ action('ModulesController@destroy', [ $module->course->id, $module->id]) }}" data-callback = 'deleteCurriculumItem' 
                   data-delete = '.shr-editor-module-{{ $module->id }}' data-message="{{ trans('crud/labels.you-sure-want-delete') }}">
                    <i class="fa fa-trash-o" data-callback = 'deleteCurriculumItem' data-delete = '.shr-editor-module-{{ $module->id }}'
                       data-message="{{ trans('crud/labels.you-sure-want-delete') }}" 
                       data-url="{{ action('ModulesController@destroy', [ $module->course->id, $module->id]) }}" ></i> Delete this module
                </a>
                
                
<!--                {{ Form::open(array('action' => ['ModulesController@destroy', $module->course->id, $module->id], 'method' => 'delete', 
                        'class' => 'ajax-form inline-block', 'data-callback' => 'deleteCurriculumItem', 'data-delete' => '.shr-editor-module-'.$module->id )) }}
                        <button type="submit" name="delete-module-{{$module->id}}" class="delete-button delete-lesson right" data-message="{{ trans('crud/labels.you-sure-want-delete') }}">
                            <i class="fa fa-trash-o"></i> Delete this module
                        </button>
                {{ Form::close() }}-->
            </div>
        </div>
    {{ Form::close() }}
    <div class="lesson-container">
        @foreach($module->lessons as $lesson)
            {{ View::make('courses.editor.v2.lesson')->with( compact('lesson') ) }}
        @endforeach
    </div>
    <div class="text-center">
        <a href="#" class="add-new-lesson">ADD NEW LESSON</a>
    </div>
</div>