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
                        <img src="images/registered-mark.png" alt="" class="inline-block" />
                        <span class="block">{{ trans('acl.congratulations') }} </span>
                          <!--  <span class="name">Saulius,</span></span> -->
                        <span class="block">{{ trans('acl.you-verified-email')}}</span>
                    </h2>
                </div>
            </div>
            <div class="row verify-email email-verified">
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <span class="step-number">1</span>
                    <h3>{{ trans('acl.email-verified') }}</h3>
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
                        <h3>{{ trans('acl.invite-publishers') }}</h3>
                        <p class="regular-paragraph">{{ trans('acl.your-publisher-links') }}</p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 share-link-form clearfix">
                            <input type="url" name="share-link" placeholder="http://" 
                                   @if(Auth::user()->sti_approved=='no') 
                                       disabled>
                                   @else
                                       class='clipboardable tooltiplable' data-clipboard-text="{{ Config::get('app.url') }}/lp1/index.php?stpi={{ Auth::user()->id }}"
                                       value="{{ Config::get('app.url') }}/lp1/index.php?stpi={{ Auth::user()->id }}">
                                   @endif
                                   
                                   <div class='tooltipable pull-right' title='{{ trans('general.copy-to-clipboard') }}'>
                                            @if(Auth::user()->sti_approved=='no') 
                                                <button class="blue-button large-button" disabled>
                                            @else
                                                <button class="blue-button large-button clipboardable" 
                                                        data-clipboard-text="{{ Config::get('app.url') }}/lp1/index.php?stpi={{ Auth::user()->id }}">
                                            @endif
                                           {{ trans('general.COPY') }}</button>
                                    </div>
                                    
                            <input type="url" name="share-link" placeholder="http://" 
                                   @if(Auth::user()->sti_approved=='no') 
                                       disabled>
                                   @else
                                       class='clipboardable tooltiplable' data-clipboard-text="{{ Config::get('app.url') }}/lp2/index.php?stpi={{ Auth::user()->id }}"
                                       value="{{ Config::get('app.url') }}/lp2/index.php?stpi={{ Auth::user()->id }}">
                                   @endif
                                   
                                   <div class='tooltipable pull-right' title='{{ trans('general.copy-to-clipboard') }}'>
                                            @if(Auth::user()->sti_approved=='no') 
                                                <button class="blue-button large-button" disabled>
                                            @else
                                                <button class="blue-button large-button clipboardable" 
                                                        data-clipboard-text="{{ Config::get('app.url') }}/lp2/index.php?stpi={{ Auth::user()->id }}">
                                            @endif
                                           {{ trans('general.COPY') }}</button>
                                    </div>
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
                    {{ trans('acl.we-must-approve-2tier')}}
                </div>
            </div>
        </div>
    </section>

@stop