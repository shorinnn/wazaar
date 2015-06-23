@extends('layouts.default')
@section('content')	

<section class="container text-center">
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
</section>

@stop