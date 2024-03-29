<!--@if( $testimonial->thumbs() > 0)
    @if($testimonial->thumbs_up > $testimonial->thumbs_down)
    <h4 class="testimonial-{{$testimonial->id}} text-center">
        <i class="fa fa-thumbs-o-up"></i> <span class='thumbs-up-label'>{{$testimonial->thumbs_up}}</span>
        of <span class='thumbs-total-label'>{{$testimonial->thumbs()}}</span> {{trans('courses/general.found-this-review-very-helpful')}}
    </h4>
    @else
        <h4 class="testimonial-{{$testimonial->id}} text-center">
            <i class="fa fa-thumbs-o-down"></i> 
            <span class='thumbs-down-label'>{{$testimonial->thumbs_down}}</span>
            of  <span class='thumbs-total-label'>{{$testimonial->thumbs()}}</span> {{trans('courses/general.found-this-review-not-helpful')}}
        </h4>
    @endif
@else
    <h4 class="testimonial-{{$testimonial->id}}-placeholder text-center"><i class="fa fa-question-circle"></i> {{trans('courses/general.be-the-first-to-rate-this-review')}}</h4>
    <h4 class="testimonial-{{$testimonial->id}} text-center hidden">
        <i class="fa fa-thumbs-o-down"></i> <span class='thumbs-down-label'>{{$testimonial->thumbs_down}}</span>
        <i class="fa fa-thumbs-o-up"></i> <span class='thumbs-up-label'>{{$testimonial->thumbs_up}}</span>
        {{trans('courses/general.of')}}  <span class='thumbs-total-label'>{{$testimonial->thumbs()}}</span> 
        {{trans('courses/general.found-this-review')}}
        <span class='not-very'>{{trans('courses/general.very')}}</span> 
        {{trans('courses/general.helpful')}}
    </h4>
@endif-->
  <div class="reviews clearfix">
  	<div class="row no-margin">
          <div class="user-thumb col-xs-12 col-sm-2 col-md-2 col-lg-2">
          	  <div class="img-wrap">
                      <!--
                @if( $testimonial->student->profile != null && trim($testimonial->student->profile->photo)!='')
                    <img src='{{ $testimonial->student->profile->photo }}' class="img-responsive" />
                @elseif( trim($testimonial->student->photo) != '')
                    <img src='{{ $testimonial->student->photo }}' class="img-responsive" />
                @else
                    <img src="{{cloudfrontUrl("//s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg")}}" class="img-responsive" />
                @endif-->
                    <img src="https://s3-us-west-2.amazonaws.com/wazaar-demo/profile_pictures/avatar-placeholder.jpg" class="img-responsive" />
              </div>
              <span>
              {{ $testimonial->student->last_name }}
              {{ $testimonial->student->first_name }}
              </span>
             
              
            <em class="recommendation
                @if($testimonial->rating=='positive')
                 recommends">
                    <em class="recommended">{{ trans("courses/general.recommends") }}</em>
                @else
                 not-recommend">
                    <em class="unrecommended">{{ trans("courses/general.does_not_recommend") }}</em>
                @endif
            </em>
          </div>
          <div class="user-review col-xs-12 col-sm-10 col-md-10 col-lg-10">
              <p class="regular-paragraph expandable-content">
                {{{ $testimonial->content }}}
              </p>
              <div class="fadeout-text"></div>
             
              
              <!--<span class="view-more-reviews expandable-button show-more" data-less-text='Less' data-more-text='More'>{{ trans("courses/general.more") }}--> 
              <!--</span>-->
              
                    @if(Auth::check())
                          <form method='post' class=' ajax-form @if( $testimonial->ratedBy( Auth::user() ) && $testimonial->current_user_rating->rating == 'positive' )
                                helful-review-form
                                @endif' action='{{action('TestimonialsController@rate')}}'
                              data-callback='ratedTestimonial' 
                              @if( $testimonial->ratedBy( Auth::user() ) && $testimonial->current_user_rating->rating == 'positive' )
                                  data-thumb='down' 
                              @else
                                  data-thumb='up' 
                              @endif
                              data-total='{{$testimonial->thumbs()}}' 
                              data-up="{{$testimonial->thumbs_up}}" 
                              data-down="{{$testimonial->thumbs_down}}" data-testimonial-id='{{$testimonial->id}}'
                                    @if( $testimonial->ratedBy( Auth::user() ) )
                                        data-rated='{{$testimonial->current_user_rating->rating}}'
                                    @endif
                                    >
							<div class="helpful-button-wrap clearfix">
                                <button type='submit' name="rate-yes" class="helpful-button"  data-testimonial-id='{{$testimonial->id}}'>
                                    <i class="fa fa-thumbs-o-up"></i> 
                                    @if( $testimonial->ratedBy( Auth::user() ) && $testimonial->current_user_rating->rating == 'positive' )
                                        {{ trans("courses/general.found_helpful") }}
                                    @else
                                        {{ trans("courses/general.helpful") }}
                                    @endif
                                </button>
                                <input type="hidden" name="rating" 
                                    @if( $testimonial->ratedBy( Auth::user() ) && $testimonial->current_user_rating->rating == 'positive' )
                                        value="negative" 
                                    @else
                                        value="positive"
                                    @endif
                                />
                                <input type="hidden" name="testimonial_id" value="{{$testimonial->id}}" />
                                <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                                <span class="number-of-likes number-of-likes-{{$testimonial->id}}">{{ $testimonial->thumbs_up }}</span>
                            </div>
                        </form>
                    @endif
                    
                    
              
          </div>
      </div>
  </div>

<!-- <p>
     {{{ $testimonial->content }}}
 </p>
 <span class="name">
     {{ $testimonial->student->first_name }}
     {{ $testimonial->student->last_name }}
 </span>
 @if( Auth::check() )
        <h4 class="text-center">{{trans('courses/general.was-this-review-helpful')}}?</h4>
        <div class="text-center">
            <form method='post' class='inline-block ajax-form' action='{{action('TestimonialsController@rate')}}'
                  data-callback='ratedTestimonial' data-thumb='up' data-total='{{$testimonial->thumbs()}}' 
                data-up="{{$testimonial->thumbs_up}}" data-down="{{$testimonial->thumbs_down}}" data-testimonial-id='{{$testimonial->id}}'
                        @if( $testimonial->ratedBy( Auth::user() ) )
                            data-rated='{{$testimonial->current_user_rating->rating}}'
                        @endif
                        >
                        
                <button type='submit' name="rate-yes" class="btn btn-success"  data-testimonial-id='{{$testimonial->id}}'>
                    <i class="fa fa-thumbs-o-up"></i> {{trans('courses/general.yes')}}
                    @if( $testimonial->ratedBy( Auth::user() ) && $testimonial->current_user_rating->rating == 'positive' )
                        <i class="fa fa-check-circle-o"></i>
                    @endif
                </button>
                <input type="hidden" name="rating" value="positive" />
                <input type="hidden" name="testimonial_id" value="{{$testimonial->id}}" />
                <input type='hidden' name='_token' value='{{ csrf_token() }}' />
            </form>

            <form method='post' class='inline-block ajax-form' action='{{action('TestimonialsController@rate')}}'
                  data-callback='ratedTestimonial' data-thumb='down' data-total='{{$testimonial->thumbs()}}' 
                data-up="{{$testimonial->thumbs_up}}" data-down="{{$testimonial->thumbs_down}}" data-testimonial-id='{{$testimonial->id}}'
                        @if( $testimonial->ratedBy( Auth::user() ) )
                            data-rated='{{ $testimonial->current_user_rating->rating }}'
                        @endif
                        >
                <button type='submit'  name="rate-no" class="btn btn-danger"  data-testimonial-id='{{$testimonial->id}}'>
                    <i class="fa fa-thumbs-o-down"></i> {{trans('courses/general.no')}}
                    @if( $testimonial->ratedBy( Auth::user() ) && $testimonial->current_user_rating->rating == 'negative' )
                        <i class="fa fa-check-circle-o"></i>
                    @endif
                </button>
                <input type="hidden" name="rating" value="negative" />
                <input type="hidden" name="testimonial_id" value="{{$testimonial->id}}" />
                <input type='hidden' name='_token' value='{{ csrf_token() }}' />
            </form>
        </div>
 @endif
 <hr />
 
 -->