	<div class="container-fluid new-dashboard instructor-course top-section">
    	<div class="container">
            <div class="row">
                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                    <div class="profile-picture-holder">
                        <img
                            @if($course->course_preview_image_id == null)
                                src="http://placehold.it/350x150&text={{ trans('general.preview-unavailable') }}"
                            @else
                                src="{{ cloudfrontUrl( $course->previewImage->url ) }}"
                            @endif
                            class="img-responsive">
                    </div>
                </div>
                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9">
                	<a href="{{ action( 'StudentController@mycourses' ) }}" class="back-to-courses"><i class="wa-chevron-left"></i>{{ trans('courses/dashboard.back-to-courses') }}</a>
                	<h1>{{ $course->name }}</h1>
                    <p>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard dashboardTabs-header">
    	<div class="container">
        	<div class="row">
            	<div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <ul class="nav nav-pills left" role="tablist">
                        <li role="presentation" class="active">
                        	<a href="#discussions" role="tab" id="teaching-tab" data-toggle="tab" aria-controls="enrolled" aria-expanded="true">246 Discussions</a>
                        </li>
                        <li role="presentation" class="">
                        	<a href="#questions" role="tab" id="enrolled-tab" data-toggle="tab" aria-controls="enrolled" aria-expanded="true">5 Questions</a>
                        </li>
                        <li role="presentation">
                        	<a href="#students" role="tab" id="finished-tab" data-toggle="tab" aria-controls="finished">118 Students</a>
                        </li>
                    </ul>
                    <a href="{{ action('CoursesController@edit', $course->slug) }}" class="right add-new-course large-button blue-button"><i class="fa fa-edit"></i> {{ trans('courses/general.edit') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard instructor-course padding-bottom-30">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding-xs">
                    <div class="tab-content margin-top-25">
                      <div role="tabpanel" class="tab-pane fade in active" id="discussions">
                        <div class="row no-margin">
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 no-margin message-preview-wrap">
                                <div class="row message-header">
                                    <div class="col-xs-3 col-sm-3 col-md-4 col-lg-4">
                                        <h3>Topics</h3>
                                    </div>
                                    <div class="col-xs-9 col-sm-9 col-md-8 col-lg-8">
                                        <form>
                                            <div>
                                                <input type="search" placeholder="Search conversations ..." />
                                                <button><i class="wa-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                @foreach($discussions as $discussion)
                                <a href="#" data-no-prevent-default='1' data-no-push-state="1" class="load-remote toggle-student-message row message-preview right-bar-toggler" data-loading-container=".full-messages"
                                   data-url="{{ action('CoursesController@viewDiscussion', $discussion->id)}}" data-target=".full-messages" data-elem=".full-messages"  data-close=".close-tab">
                                    <div class="">
                                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                            <div class="message">
                                                <h3>{{ Str::limit( $discussion->title, 20) }}</h3>
                                                <p>By <span class="name">{{ $discussion->student->fullName() }}</span> <span class="last-reply">Last reply  {{$discussion->created_at->diffForHumans() }}</span></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            <span class="number-of-replies">47<i class="fa fa-reply"></i></span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                                {{ $discussions->links() }}

                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 full-messages no-padding-left no-padding-right">

                            </div>
                        </div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="questions">...</div>
                      <div role="tabpanel" class="tab-pane fade" id="students">...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

