<div class="shr-editor shr-editor-{{$module->id}}">
    <div class="row module-data">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <span class="module-name">Module1</span>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <!--<input type="text" name="module-name" placeholder="Enter module title">-->
            <h2>{{ $module->name }} <button class="edit-icon"><i class="fa fa-pencil"></i></button></h2>
            <p class="regular-paragraph description-text">In this module, you will become familiar with the course, your 
                instructor, your classmates, and our learning environment. Then, you will learn how new digital 
                tools are enabling customers to take a more active role in developing and branding the products 
                they consume. <button class="edit-icon"><i class="fa fa-pencil"></i></button>
            </p>
            <!--<textarea placeholder="Enter description..."></textarea>-->
        </div>
    </div>
    <div class="row footer-buttons">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a href="#" class="green-button large-button">Save changes</a>
            <a href="#" class="default-button large-button">Cancel</a>
            <a href="#" class="delete-lesson right"><i class="fa fa-trash-o"></i> Delete this module</a>
        </div>
    </div>
    <div class="lesson-container">
        @foreach($module->lessons as $lesson)
            {{ View::make('courses.editor.v2.lesson')->with( compact('lesson') ) }}
        @endforeach
    </div>
    <div class="text-center">
        <a href="#" class="add-new-lesson">ADD NEW LESSON</a>
    </div>
</div>