    <div class="row">
        <div class="col-md-12">
            <div class="users-comments" id='ask-teacher'>
                <div class="clearfix">
                    @foreach($course->questions as $question)
                    {{ View::make('courses/instructor/dashboard/question')->with( compact('question') ) }}

                    @endforeach
                </div>
                 <div class="text-center load-remote" data-target='#questions' data-load-method="fade">
                    {{ $course->questions->appends( ['paginate'=>'questions'] )->links() }}
                </div>
            </div>                        
        </div>
    </div>