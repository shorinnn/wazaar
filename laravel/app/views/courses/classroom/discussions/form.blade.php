{{ Form::open( ['action' => 'DiscussionsController@store', 'class' =>'ajax-form full-height', 'data-callback'=>'LessonQuestionAddToList', 
                                        'data-destination' => '.question-holder', 'data-prepend' => 'true'  ] ) }}
<div class="no-padding full-height">
    <div class="discussion-sidebar">
        <div class="discussion-sidebar-header">
            <h2>{{ trans('courses/dashboard.ask-question') }}</h2>
            <span class="close-tab" onclick="toggleRightBar()"><i class="fa fa-times"></i></span>
        </div>
        <div class="ask-question-fields margin-top-40 clearfix">
            <div class="row">
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                    <div class="avatar">
                            <img src="{{Auth::user()->commentPicture('Student') }}" alt="" class="img-responsive">
                    </div>
                </div>
                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                    <div class="clearfix">
                        <input type="text" name="title" placeholder="{{ trans('courses/dashboard.what-would-you-like-to-ask') }}">
                    </div>
                    <div>
                        <textarea class="expandable-textarea" name='content' 
                                  placeholder="{{ trans('courses/dashboard.describe-more-details-on-your-subject') }}"></textarea>
                    </div>
                    <input type="hidden" name="lesson_id" value="{{$lesson->id}}" />
<!--                    <center>
                    <textarea name="title" class="form-control" placeholder="Your Question"></textarea>
                        <button class="submit-for-approval blue-button large-button">Post</button>
                    </center>-->
                    
                </div>
            </div>
        </div>
        <div class="clearfix ask-question-fields-footer">
            <div class="buttons">
                <button type='reset' class="large-button default-button cancel" onclick="toggleRightBar()">{{ trans('courses/dashboard.cancel') }}</button>
                <button type='submit' class="large-button blue-button submit-question">{{ trans('courses/dashboard.submit-question') }}</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}