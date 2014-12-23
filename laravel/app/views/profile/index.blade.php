@extends('layouts.default')
@section('content')
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="well margin-top-15">
                <h3>{{trans('profile.pageTitle')}}</h3>
                <hr/>

                @if ($isProfileNew)
                    @include('profile.partials.new.step' . $step)
                @else

                @endif

            </div>
        </div>
    </div>
@stop