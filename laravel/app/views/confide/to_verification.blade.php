@extends('layouts.default')
@section('content')

@if (Session::get('notice'))
    <div class="alert">{{ Session::get('notice') }}</div>
@endif
    <section class="container-fluid email-confirmation-pages">
        <div class="container">
            <div class="row congrats-message">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2>
                        Redirecting
                    </h2>
                    <a href='{{ action('UsersController@verificationConfirmation')}}'>Click here if not redirected after 2 seconds...</a>
                </div>
            </div>
        </div>
    </section>

@stop

@section('extra_js')
<script>
    setTimeout(function(){
        window.location = '{{ action('UsersController@verificationConfirmation')}}';
    }, 2000);
</script>
@stop