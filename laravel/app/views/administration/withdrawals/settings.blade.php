@extends('layouts.default')
@section('content')	
    
@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif

<style>
    .settings-label{
        line-height: 38px;
    }
    .back-to-payment:hover{
        color: #0099ff;
    }
    .misc-buttons form{
        display: inline-block;
        vertical-align: top;
        margin-bottom: 5px;
        margin-right: 2%;
    }
    .misc-buttons form:last-of-type{
        margin-right: 0;
    }
    @media (max-width:767px){
        .settings-label{
            float: left;
        }
    }
</style>
<div class="container-fluid">
    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-10 col-lg-push-1">
            <a href='{{action('WithdrawalsController@index')}}' class="margin-top-40 block back-to-payment"><i class='fa fa-arrow-left'></i> Back To Payments</a>
            {{ Form::open( ['action' => 'WithdrawalsController@doSettings' ] ) }}
            <div class="row margin-top-40">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
                    <label class="settings-label">Cashout Processor Fired On:</label>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            {{ Form::select('date', $options, $setting->value) }}
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            {{ Form::select('hour', $hourOptions, $hour->value) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
                    <label class="settings-label">Refund Window (days) :</label>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <input type='text' name='refund_window' value='{{$refund->value}}'/>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
                    <label class="settings-label">Cashout Bank Fee (<span class="success-color"> $ </span>) :</label>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                   <input type='text' name='bank_fee' value='{{$bankFee->value}}'/>
                </div>
            </div>

            <div class="row margin-bottom-20">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
                    <label class="settings-label">Email For No Bank Account Details:</label>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                   <input type='text' name='email_subject' value='{{ $mailSubject->value }}' />
                   <textarea name='email_content' class="no-margin">{{ $mailContent->value }}</textarea>
                   <small class="margin-top-10 inline-block">Available tags: @last-name@, @first-name@</small>
                </div>
            </div>

            <div class="row margin-bottom-20">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <button type="submit" class="blue-button large-button margin-bottom-20">Update</button>
                </div>
            </div>

        {{ Form::close() }}

            <div class="row margin-bottom-30">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 misc-buttons">
                    {{ Form::open( ['action'=>'WithdrawalsController@sendBankEmail', 'class'=>'ajax-form', 'data-callback' => 'bankMailSent'] ) }}
                        <button type='submit' class='small-button red-button'>Send No Bank Account Email</button>
                    {{ Form::close() }}
                    <form method="post" class="csvForm" action='{{action('WithdrawalsController@index')}}' >
                        <input type="submit" class="small-button green-button" value="Download Bank Details CSV" />
                    </form>
                    <form method="post" class="csvForm" action="{{action('WithdrawalsController@allCashoutList')}}">
                        <input type="submit" class="small-button blue-button" value="All Cashout List" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('extra_js')
<script>
    function bankMailSent(e){

        $.bootstrapGrowl( _( e.sent+' Emails Sent' ),{align:'center', type:'success'} );
        return false;
    }
    
    $('body').delegate('.csvForm', 'submit', function(){
        setTimeout(function(){
           $('input').removeAttr('disabled');
           console.log('re-enabled');
        }, 1000);
    });
</script>
@stop