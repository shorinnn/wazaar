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
                        <!--<img src="registered-mark.png" alt="" class="inline-block">-->
                        <span class="block">Congratulations <span class="name">Saulius,</span></span>
                        <span class="block">you have registered on Wazaar!</span>
                    </h2>
                </div>
            </div>
            <div class="row verify-email">
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <span class="step-number">1</span>
                    <div>
                        <h3>Please verify your email</h3>
                        <p class="regular-paragraph">We have sent verification link to your email saulius@mail.com!</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <a href="#" class="blue-button large-blue-button">VERIFY EMAIL</a>
                </div>
            </div>
            <div class="row invite-friends deactivated">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <span class="step-number">2</span> 
                    <div>
                        <h3>Invite friends and collegues</h3>
                        <p>Get personal sharable link</p>    
                    </div>       
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                </div>
            </div>
        </div>
    </section>

@stop