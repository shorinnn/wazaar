<li class="shr-editor-module-{{$module->id}}">
    <a class='shr-editor-module-{{$module->id}}-copy-name scroll-to-element' href="#" data-target='div.shr-editor-module-{{$module->id}}'>
        {{ $module->name }}</a>
    <ol class='drag-lesson' data-module-id='{{$module->id}}'>
        @foreach($module->lessons()->orderBy('order','asc')->get() as $lesson)
            {{ View::make('courses.editor.v2.lesson_li')->with( compact('lesson') ) }}
        @endforeach
    </ol>
</li>