@if( $testimonial->thumbs() > 0)
    @if($testimonial->thumbs_up > $testimonial->thumbs_down)
    <h4 class="testimonial-{{$testimonial->id}} text-center">
        <i class="fa fa-thumbs-o-up"></i> <span class='thumbs-up-label'>{{$testimonial->thumbs_up}}</span>
        of <span class='thumbs-total-label'>{{$testimonial->thumbs()}}</span> found this review very helpful
    </h4>
    @else
        <h4 class="testimonial-{{$testimonial->id}} text-center">
            <i class="fa fa-thumbs-o-down"></i> 
            <span class='thumbs-down-label'>{{$testimonial->thumbs_down}}</span>
            of  <span class='thumbs-total-label'>{{$testimonial->thumbs()}}</span> found this review not helpful
        </h4>
    @endif
@else
    <h4 class="testimonial-{{$testimonial->id}}-placeholder text-center"><i class="fa fa-question-circle"></i> Be the first to rate this review</h4>
    <h4 class="testimonial-{{$testimonial->id}} text-center hidden">
        <i class="fa fa-thumbs-o-down"></i> <span class='thumbs-down-label'>{{$testimonial->thumbs_down}}</span>
        <i class="fa fa-thumbs-o-up"></i> <span class='thumbs-up-label'>{{$testimonial->thumbs_up}}</span>
        of  <span class='thumbs-total-label'>{{$testimonial->thumbs()}}</span> found this review <span class='not-very'>very</span> helpful
    </h4>
@endif

<p>
     {{{ $testimonial->content }}}
 </p>
 <span class="name">
     {{ $testimonial->student->first_name }}
     {{ $testimonial->student->last_name }}
 </span>
 <h4 class="text-center">was this review helpful?</h4>
 <div class="text-center">
     <form class='inline-block ajax-form' action='{{action('TestimonialsController@rate')}}'
           data-callback='ratedTestimonial' data-thumb='up' data-total='{{$testimonial->thumbs()}}' 
         data-up="{{$testimonial->thumbs_up}}" data-down="{{$testimonial->thumbs_down}}" data-testimonial-id='{{$testimonial->id}}'>
         <button type='submit' class="btn btn-success"  data-testimonial-id='{{$testimonial->id}}'>
             <i class="fa fa-thumbs-o-up"></i> Yes
         </button>
         <input type="hidden" name="rating" value="positive" />
         <input type="hidden" name="testimonial_id" value="{{$testimonial->id}}" />
     </form>
     
     <form class='inline-block ajax-form' action='{{action('TestimonialsController@rate')}}'
           data-callback='ratedTestimonial' data-thumb='down' data-total='{{$testimonial->thumbs()}}' 
         data-up="{{$testimonial->thumbs_up}}" data-down="{{$testimonial->thumbs_down}}" data-testimonial-id='{{$testimonial->id}}'>
         <button type='submit' class="btn btn-danger"  data-testimonial-id='{{$testimonial->id}}'>
             <i class="fa fa-thumbs-o-down"></i> No
         </button>
         <input type="hidden" name="rating" value="negative" />
         <input type="hidden" name="testimonial_id" value="{{$testimonial->id}}" />
     </form>
 </div>
 <hr />