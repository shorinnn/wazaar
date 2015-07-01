@extends('layouts.default')

@section('page_title')
    Accept Terms - 
@stop

@section('content')	

<section class="container text-center">
    <div style='border:1px solid silver; padding:10px; margin:20px; height:400px; overflow-y: scroll'>
        @include('instructors.terms')
        
        {{ Form::open( ['InstructorsController@doAcceptTerms' ] ) }}
        <div class="checkbox-buttons">
                        <div class="checkbox-item text-center">
                          <div class="checkbox-checkbox checkbox-checked">
                            <input id="checkbox-1" autocomplete="off" type="checkbox" name='accept' value='1' />                        
                            <label for="checkbox-1" class="small-checkbox">
                            </label>
                                {{ trans('general.i-agree') }}
                          </div>  
                        </div>
                    </div><br />
            <button type='submit' class='btn btn-primary'>{{ trans('general.accept') }}</button>
        {{ Form::close() }}
    </div>
</section>

@stop