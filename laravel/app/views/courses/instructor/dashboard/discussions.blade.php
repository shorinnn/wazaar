    <div class="row">
        <div class="col-md-12">
            <div class="users-comments" id='ask-teacher'>
                <div class="clearfix">
                    @foreach($course->comments as $comment)
                    {{ View::make('courses/instructor/dashboard/discussion')->with( compact('comment') ) }}

                    @endforeach
                </div>
                 <div class="text-center load-remote" data-target='#discussions' data-load-method="fade">
                    {{ $course->comments->appends( ['paginate'=>'discussions'] )->links() }}
                </div>
            </div>                        
        </div>
    </div>