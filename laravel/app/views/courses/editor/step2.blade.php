<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 side-overview">
            <h2>{{ trans('courses/create.overview') }}</h2>
            <ol class="drag-module">
                @foreach($course->modules()->orderBy('order','asc')->get() as $module)
                   {{ View::make('courses.editor.v2.module_li')->with( compact('module') )->render() }}
                @endforeach
            </ol>
        </div>
    	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
        	<div class="curriculum-wrapper">
                <div class="module-container">
                    @foreach($course->modules()->orderBy('order','asc')->get() as $module)
                        {{ View::make('courses.editor.v2.module')->with( compact('module') )->render() }}
                    @endforeach
                </div>
                <div class="text-center add-new-module-container">
<!--                    <a href="#" class="add-new-module default-button large-button">ADD NEW MODULE</a>-->
                    <form method='post' class='ajax-form' id="modules-form" data-callback='addModule'
                          action='{{ action('ModulesController@store',[$course->id] )}}'>
                        <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                        <button type='submit' class="add-new-module default-button large-button">{{ trans('crud/labels.add_module') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    enableBlockFileUploader();
    enableCharactersLeft();
    sortablizeMdl();
    sortablizeLsn();
    calculateFileSizes();
    $('body').delegate('.modal', 'show.bs.modal', function () {
        fixModalJerk();
    });
</script>
    
