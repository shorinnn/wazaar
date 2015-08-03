@extends('layouts.default')

@section('page_title')
    Accept Terms - 
@stop

@section('content')	

<section class="container text-center">
{{ Form::open( ['InstructorsController@doAcceptTerms' ] ) }}
<div class="checkbox-buttons">
                <div class="checkbox-item text-center">
                  <div class="checkbox-checkbox checkbox-checked">
                    <input id="checkbox-1" autocomplete="off" type="checkbox" name='accept' value='1' />                        
                    <label for="checkbox-1" class="small-checkbox left terms-checkbox">
                    </label>
                        <span>{{ trans('general.i-agree') }}</span>
                  </div>  
                </div>
            </div><br />
    <button type='submit' class='blue-button large-button'>{{ trans('general.accept') }}</button>
{{ Form::close() }}
</section>

@stop