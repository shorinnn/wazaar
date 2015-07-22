<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-2 side-overview">
            <h2>Overview</h2>
            <ol>
                @foreach($course->modules as $module)
                    <li class="shr-editor-module-{{$module->id}}">
                        <a href="#">{{ $module->name }}</a>
                        <ol>
                            @foreach($module->lessons as $lesson)
                                <li><a href="#">{{ $lesson->name }}</a></li>
                            @endforeach
                        </ol>
                    </li>
                @endforeach
            </ol>
        </div>
    	<div class="hidden-xs hidden-sm hidden-md col-lg-1"></div>
    	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
        	<div class="curriculum-wrapper">
                <div class="module-container">
                    @foreach($course->modules as $module)
                        {{ View::make('courses.editor.v2.module')->with( compact('module') ) }}
                    @endforeach
                </div>
                <div class="text-center add-new-module-container">
                    <a href="#" class="add-new-module default-button large-button">ADD NEW MODULE</a>
                </div>
            </div>
        </div>
    	<div class="hidden-xs hidden-sm hidden-md col-lg-2"></div>
    </div>
</div>