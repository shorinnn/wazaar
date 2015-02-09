@extends('layouts.default')
@section('content')	

<div class="classrooms-wrapper">
    <section class="classroom-content container">
        <div class="row">
            <div class="col-md-12">
                <h1>Testimonial Here</h1>
                @if($testimonial->id == null)
                    {{ Form::open(['action' => 'TestimonialsController@store', 'id' => 'testimonial-submit-form']) }}
                @else
                    {{ Form::open(['action' => ['TestimonialsController@update', $testimonial->id], 'id' => 'testimonial-submit-form' ]) }}
                    <input type='hidden' name='_method' value='PUT' />
                @endif
                
                    <textarea name='content' class='form-control'>{{ $testimonial->content or '' }}</textarea>
                    @if($testimonial->rating=='negative')
                        <input type='radio' name='rating' value='positive'/>[ Thumbs Up Icon ]
                        <input type='radio' name='rating' value='negative' checked="checked"  />[ Thumbs Down Icon ]
                    @else
                        <input type='radio' name='rating' value='positive' checked="checked" />[ Thumbs Up Icon ]
                        <input type='radio' name='rating' value='negative' />[ Thumbs Down Icon ]
                    @endif
                    
                    <input type='hidden' name='id' value='{{$course->id}}' />
                    <br />
                    <button type='submit' class='btn btn-primary' name=''>{{ trans('crud/labels.submit') }}</button>
                {{ Form::close() }}
                
            </div>

        </div>



    </section>
</div>

@stop
