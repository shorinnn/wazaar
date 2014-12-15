@extends('layouts.default')
@section('content')	

<section class="container">
    <!-- First row begins -->         
    <div class="row first-row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            @if (Session::get('error'))
                <div class="alert alert-error alert-danger"><span>ERROR</span>{{{ Session::get('error') }}}</div>
            @endif
            @if (Session::get('success'))
                <div class="alert alert-success">{{{ Session::get('success') }}}</div>
            @endif
            <h1 class='well'>Instructor dash right here bro!</h1>
        </div>
    </div>       

    <!-- End of First row -->
</section>

@stop