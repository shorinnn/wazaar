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
                        @if( Auth::user()->hasRole('Affiliate') )
                        <span class="block">おめでとうございます！ ワザールのアフィリエイターとして登録されました！</span>
                        <span class='block'>大変お手数ですが、もう一つだけ手続きが残っておりますので、よろしくお願いします！ </span>
                        @else
                            <span class="block">{{ trans('acl.congratulations') }} </span>
                            <span class="block">{{ trans('acl.you-registered-on-wazaar') }}</span>
                        @endif
                    </h2>
                </div>
            </div>
            <div class="row verify-email">
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <span class="step-number">1</span>
                    <div>
                        <h3>{{ trans('acl.please-verify-email') }}</h3>
                        <p class="regular-paragraph">{{ trans('acl.we-sent-link', ['email' => Auth::user()->email]) }} </p>
                        @if( !Session::has('success') )
                            <center>
                                {{ Form::open( [ 'action' => 'UsersController@doRegistrationConfirmationResend', 'method' => 'post'] ) }}
                                    <button type='submit' class="btn btn-primary"> {{trans('general.resend-link') }}</button>
                                {{ Form::close() }}
                            </center>
                        @else
                            <p class='alert alert-success'>{{ Session::get('success') }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
<!--                    <a target='_blank' href="http://{{ getDomainFromEmail(Auth::user()->email )}}" class="blue-button large-button">
                        {{ trans('acl.verify-email')}}
                    </a>-->
                </div>
            </div>
            <div class="row invite-friends deactivated">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <span class="step-number">2</span> 
                    <div>
                        @if( Auth::user()->is_second_tier_instructor=='yes' )
                            <h3>{{ trans('acl.invite-publishers') }}</h3>
                            <!--<p>Get personal sharable link</p>-->
                        @else
                            @if(Auth::user()->hasRole('Instructor') )
                                <h3>{{ trans('general.begin_creating_your_course') }}</h3>
                            @elseif(Auth::user()->hasRole('Affiliate') )
                                <h3>商品を検索して、プロモーションをかけましょう！</h3>
                            @else
                                <h3>{{ trans('general.browse-courses') }}</h3>
                            @endif
                            <!--<p>Browsing Courses</p>  -->  
                        @endif
                    </div>       
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                </div>
            </div>
        </div>
    </section>

@stop