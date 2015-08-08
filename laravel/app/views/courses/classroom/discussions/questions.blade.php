<style>
    .question-entry:nth-child(even){
        background-color:rgb(239, 239, 239);
    }
</style>
<div class='lesson-questions'>
    <p class='blade-location'>courses.classroom.discussions.questions</p>
    <h1>Questions</h1>
    
    <div class='question-holder'>
        @foreach($lesson->discussions()->orderBy('created_at','desc')->get() as $discussion)
            {{ View::make('courses.classroom.discussions.question')->with( compact('discussion') ) }}
        @endforeach
    </div>
</div>