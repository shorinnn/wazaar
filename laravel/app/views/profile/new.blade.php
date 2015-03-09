@extends('layouts.default')

@section('page_title')
    Profile - 
@stop

@section('content')
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="well margin-top-15">
                <h3>{{trans('profile.pageTitleNew')}}</h3>
                <hr/>
                   @include('profile.partials.new.step' . $step)
            </div>
        </div>
    </div>
@stop