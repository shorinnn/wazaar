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
        <div class="row verify-email email-verified">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
            	<span class="step-number">1</span>
                <h3>Email verified!</h3>
            </div>
        	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
            </div>
        </div>
        <div class="row invite-friends">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<span class="step-number">2</span>  
                <h3>Invite friends and collegues</h3>
                <p class="regular-paragraph">Copy your personal link to share it!</p>          
            </div>
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 share-link-form">
            	<form>
                	<input type="url" name="share-link" placeholder="http://" disabled>
                    <button class="blue-button large-blue-button" disabled>COPY</button>
                </form>
            </div>
        	<div class="col-lg-12 approval-notice">
            We must approve your 2-tier account, which can take up to 3 days. Come back later to get your link.
            </div>
        </div>
    </div>
</section>

@stop