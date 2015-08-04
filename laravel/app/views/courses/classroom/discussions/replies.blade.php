<!--<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 no-padding">-->
<div class="no-padding">
            	<div class="discussion-sidebar">
                    <div class="discussion-sidebar-header">
                    	<h2>{{ $discussion->title }}</h2>
                        <span class="close-tab" onclick="toggleRightBar()"><i class="fa fa-times"></i></span>
                    </div>
<!--                    <div class="questioner">
                    	<div class="questioner-info">
                            <div class="avatar">
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                            </div>
                            <span class="name block">Mac Chinedu</span>
                            <span class="role">Web Developer</span>
                            <div class="question clear">
                                <p class="regular-paragraph">
                                    I'm looking for any kind of resource, including those that are highly technical, those directed to 
                                    experienced UI/UX designers, and just interesting philosophical works that inform awesome modern/current 
                                    web UIs/UXs (like Quora's!).
                                </p>
                            </div>
                        </div>
                    </div>-->
                    <div class="replies-holder">
                        @foreach($discussion->replies()->orderBy('created_at','Desc')->orderBy('upvotes','desc')->get() as $reply)
                            {{ View::make('courses.classroom.discussions.reply')->with( compact('reply', 'course') ) }}
                        @endforeach
                    </div>

                    <div class="discussion-sidebar-footer">
                        <div class="avatar">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                        </div>
                            {{ Form::open( ['action' => 'DiscussionRepliesController@store', 'class'=>'ajax-form', 'data-callback'=>'addToList', 
                                        'data-destination' => '.replies-holder', 'data-prepend' => 'true' ] ) }}
                                <textarea name="content" class="form-control" placeholder="Write you answer"></textarea>
                                <input type="hidden" name="lesson_discussion_id" value="{{$discussion->id}}" />
                                <button class="submit-for-approval blue-button extra-large-button">Post</button>
                            {{ Form::close() }}

                    </div>
                </div>
            </div>
