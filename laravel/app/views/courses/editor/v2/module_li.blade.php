<li class="shr-editor-module-{{$module->id}}">
    <a class='shr-editor-module-{{$module->id}}-copy-name' href="#">{{ $module->name }}</a>
    <ol class='drag-lesson'>
        @foreach($module->lessons()->orderBy('order','asc')->get() as $lesson)
            {{ View::make('courses.editor.v2.lesson_li')->with( compact('lesson') ) }}
        @endforeach
    </ol>
</li>