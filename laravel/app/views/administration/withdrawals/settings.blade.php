@extends('layouts.default')
@section('content')	
    
@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif

<div class="col-lg-3"></div>
<div class="col-lg-6">
{{ Form::open( ['action' => 'WithdrawalsController@doSettings' ] ) }}
    Cashout Processor Fired On: 
    {{ Form::select('date', $options, $setting->value) }}
    {{ Form::select('hour', $hourOptions, $hour->value) }}
    <hr />
    Refund Window:
    <input type='text' name='refund_window' value='{{$refund->value}}' style='width:70%' /> 
    days
    <hr />
    Cashout Bank Fee:
    $ <input type='text' name='bank_fee' value='{{$bankFee->value}}' style='width:70%' /> 
    <hr />
    
    <div class="row">
    	<div class="col-md-12 well">
            <p><b>Email For No Bank Account Details</b></p>
                <input type='text' name='email_subject' value='{{ $mailSubject->value }}' />
                <textarea name='email_content'>{{ $mailContent->value }}</textarea>
            <small>
            Available tags:<br />
            @last-name@, @first-name@
            </small>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">Update</button>
{{ Form::close() }}

{{ Form::open( ['action'=>'WithdrawalsController@sendBankEmail', 'class'=>'ajax-form', 'data-callback' => 'bankMailSent'] ) }}
    <button type='submit' class='btn btn-danger'>Send No Bank Account Email</button>
{{ Form::close() }}
</div>
<div class="col-lg-3"></div>


@stop

@section('extra_js')
<script>
    function bankMailSent(e){

        $.bootstrapGrowl( _( e.sent+' Emails Sent' ),{align:'center', type:'success'} );
        return false;
    }
</script>
@stop