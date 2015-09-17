<!-- Lesson Review Modal -->
<div class="modal fade review-modal" tabindex="-1" role="dialog" aria-labelledby="lessonReviewModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content wazaar-modal">
        <div class="modal-header clearfix">
            <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
            <div class="profile-image">
                <img 
                    @if($course->course_preview_image_id != null)
                        src="{{ cloudfrontUrl( $course->previewImage->url ) }}"
                    @endif
                class="img-responsive" />
            </div>
            <p class="intro-paragraph description">{{ $course->name }}</p>
        </div>
        <div class="modal-body clearfix"> 
            <div class="bootbox-body">
                <section>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                        <div class="">
                            <div class="row no-margin">
                            	<div>
                                    <h2>{{ trans('courses/general.reviews-modal.would-you-recommend') }}</h2>
                                    <div class="yes-no-buttons clearfix">
                                    	<button class="yes-button"><i class="fa fa-thumbs-o-up"></i>{{ trans('courses/general.reviews-modal.yes') }}</button>
                                    	<button class="no-button"><i class="fa fa-thumbs-o-down"></i>{{ trans('courses/general.reviews-modal.no') }}</button>
                                    </div>
                                    <div class="positive-review-wrap clearfix hide">
                                    	{{ Form::open(['action' => 'TestimonialsController@store', 'method' => 'POST',
                                                'class' => 'ajax-form', 'data-callback' => 'courseReviewPosted'] ) }}
                                        	<div class="clearfix">
                                            	<label>{{ trans('courses/general.reviews-modal.what-do-you-like-about-it') }}</label>
                                                <textarea name='content'></textarea>
                                                <input type='hidden' name='rating' value='positive' />
                                                <input type='hidden' name='id' value='{{ $course->id }}' />
                                            </div>
                                            <div class="review-buttons-wrap clearfix">
                                                <a class="later white-button button left" onclick="cancelReviewsModal()">{{ trans('courses/general.reviews-modal.later') }}</a>
                                                <button type='submit' class="blue-button large-button button right no-margin">{{ trans('courses/general.reviews-modal.submit-review') }}</button>
                                            </div>
                                        {{ Form::close() }}
                                    </div>
                                    <div class="negative-review-wrap clearfix hide">
                                        {{ Form::open(['action' => 'TestimonialsController@store', 'method' => 'POST', 'class' => 'ajax-form', 
                                                    'data-callback' => 'courseReviewPosted' ] ) }}
                                        	<div class="clearfix">
                                            	<label>{{ trans('courses/general.reviews-modal.what-is-bad-about-it') }}</label>
                                                <textarea name='content'></textarea>
                                                <input type='hidden' name='rating' value='negative' />
                                                <input type='hidden' name='id' value='{{ $course->id }}' />
                                            </div>
                                            <div class="review-buttons-wrap clearfix">
                                            	<a class="later white-button button left" onclick="cancelReviewsModal()">{{ trans('courses/general.reviews-modal.later') }}</a>
                                                <button type='submit' class="blue-button large-button button right no-margin">{{ trans('courses/general.reviews-modal.submit-review') }}</button>
                                            </div>
                                        {{ Form::close() }}
                                    </div>
                                    <div class="long-later-button">
                                    	<a class="white-button block full-width" onclick="cancelReviewsModal()">{{ trans('courses/general.reviews-modal.later') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> 
            </div>
        </div>
    </div>  
  </div>
</div>

