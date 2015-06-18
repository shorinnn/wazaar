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
                        <img src="registered-mark.png" alt="" class="inline-block">
                        <span class="block">Congratulations <!-- <span class="name">Saulius,</span></span> -->
                        <span class="block">you have verified your email!</span>
                    </h2>
                </div>
            </div>
            <div class="row verify-email email-verified">
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <span class="step-number">1</span>
                    <h3>Email verified!</h3>
                    <p class="regular-paragraph">We have sent verification link to your email {{ Auth::user()->email }}!</p>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <a href="#" class="blue-button large-button">VERIFY EMAIL</a>
                </div>
            </div>
            <div class="row invite-friends 
                 @if( Auth::user()->is_second_tier_instructor == 'yes' && Auth::user()->sti_approved=='no')
                     approval-pending
                 @endif
                 ">
                
                @if( Auth::user()->is_second_tier_instructor=='yes' )
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <span class="step-number">2</span>            
                        <h3>Invite friends and collegues</h3>
                        <p class="regular-paragraph">Copy your personal link to share it!</p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 share-link-form clearfix">
                            <input type="url" name="share-link" placeholder="http://" 
                                   @if(Auth::user()->sti_approved=='no') 
                                       disabled>
                                   @else
                                       class='clipboardable tooltiplable' data-clipboard-text="{{ Config::get('app.url') }}/lp1/index.php?stpi={{ Auth::user()->id }}"
                                       value="{{ Config::get('app.url') }}/lp1/index.php?stpi={{ Auth::user()->id }}">
                                   @endif
                                   
                                    @if(Auth::user()->sti_approved=='no') 
                                        <button class="blue-button large-button" disabled>
                                    @else
                                        <button class="blue-button large-button clipboardable tooltipable" 
                                                data-clipboard-text="{{ Config::get('app.url') }}/lp1/index.php?stpi={{ Auth::user()->id }}">
                                    @endif
                                   COPY</button>
                                    
                            <input type="url" name="share-link" placeholder="http://" 
                                   @if(Auth::user()->sti_approved=='no') 
                                       disabled>
                                   @else
                                       class='clipboardable tooltiplable' data-clipboard-text="{{ Config::get('app.url') }}/lp2/index.php?stpi={{ Auth::user()->id }}"
                                       value="{{ Config::get('app.url') }}/lp2/index.php?stpi={{ Auth::user()->id }}">
                                   @endif
                                   
                                    @if(Auth::user()->sti_approved=='no') 
                                        <button class="blue-button large-button" disabled>
                                    @else
                                        <button class="blue-button large-button clipboardable tooltipable" 
                                                data-clipboard-text="{{ Config::get('app.url') }}/lp2/index.php?stpi={{ Auth::user()->id }}">
                                    @endif
                                   COPY</button>
                    </div>
                @else
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <span class="step-number">2</span>            
                        <h3>Start</h3>
                        <p class="regular-paragraph">Browsing Courses</p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 share-link-form clearfix">
                        <a href='{{action("SiteController@index")}}' class="blue-button large-button" disabled>GO!</a>
                    </div>
                @endif
                <div class="col-lg-12 approval-notice clearfix clear">
                    We must approve your 2-tier account, which can take up to 3 days. Come back later to get your link.
                </div>
            </div>
        </div>
    </section>

@stop