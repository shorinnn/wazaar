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
{{ Form::open( ['action' => 'WithdrawalsController@doProcessDate' ] ) }}
    Cashout Processor Fired On: 
    {{ Form::select('date', $options, $setting->value) }}
    {{ Form::select('hour', $hourOptions, $hour->value) }}
    <button type="submit" class="btn btn-primary">Update</button>
{{ Form::close() }}
</div>
<div class="col-lg-3"></div>


@stop