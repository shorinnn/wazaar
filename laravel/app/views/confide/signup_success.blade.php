@extends('layouts.default')
@section('content')

@if (Session::get('notice'))
    <div class="alert">{{ Session::get('notice') }}</div>
@endif
<section class="container-fluid email-confirmation-pages">
	<div class="container">
    	<div class="row congrats-message">
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            
            </div>
        </div>
        <div class="row verify-email">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
            	<span class="step-number">1</span>
                <h3>Please verify your email</h3>
                <p>We have sent verification link to your email saulius@mail.com!</p>
            </div>
        	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
            	<a href="#" class="blue-button large-blue-button">VERIFY EMAIL</a>
            </div>
        </div>
        <div class="row invite-friends">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<span class="step-number">2</span>            
            </div>
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<span class="step-number">2</span>            
            </div>
        </div>
    </div>
</section>

@stop