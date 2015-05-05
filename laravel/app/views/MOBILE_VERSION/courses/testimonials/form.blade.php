@extends('layouts.default')
@section('content')	

<div class="classrooms-wrapper">
    <section class="classroom-content container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ trans('general.testimonial') }}</h1>
                @if($testimonial->id == null)
                    {{ Form::open(['action' => 'TestimonialsController@store', 'id' => 'testimonial-submit-form']) }}
                @else
                    {{ Form::open(['action' => ['TestimonialsController@update', $testimonial->id], 'id' => 'testimonial-submit-form' ]) }}
                    <input type='hidden' name='_method' value='PUT' />
                @endif
                
                    <textarea name='content' class='form-control'>{{ $testimonial->content or '' }}</textarea>
                    @if($testimonial->rating=='negative')
                        <input type='radio' name='rating' value='positive'/><i class="fa fa-thumbs-o-up"></i>
                        <input type='radio' name='rating' value='negative' checked="checked"  /><i class="fa fa-thumbs-o-down"></i>
                    @else
                        <input type='radio' name='rating' value='positive' checked="checked" /><i class="fa fa-thumbs-o-up"></i>
                        <input type='radio' name='rating' value='negative' /><i class="fa fa-thumbs-o-down"></i>
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
