@extends('layouts.default')
@section('content')	

<section class="container">
    <!-- First row begins -->         
    <div class="row first-row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            
            @if( Auth::check() )
                
                <p class='alert alert-info'>{{ trans('instructors/general.click-to-start') }}!</p>
                {{ Form::open(['action' => ["InstructorsController@become"], 'id' => 'become-form']) }}
                    <input type='submit' class='btn btn-primary' value='{{ trans('site/homepage.get-started') }}' />
                {{Form::close()}}
            @else
                <h1>{{ trans('instructors/general.to-become') }}</h1>
                <a href='{{ action('InstructorsController@start', 'new-user') }}'>{{ trans('general.register') }}</a> 
                or
                <a href='{{ action('InstructorsController@start', 'existing-user') }}'>{{ trans('instructors/general.login-and-upgrade') }}</a> 
            @endif
        </div>
    </div>       

    <!-- End of First row -->
</section>

@stop