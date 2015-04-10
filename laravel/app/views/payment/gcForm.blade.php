@extends('layouts.default')
@section('content')
    <div class="container payment-page course-editor">
        <div class="row">
            <div class="col-md-12">
                <h1 class='icon'>{{trans('payment.payment')}}</h1>
                <p>Please enter your payment information below</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <iframe onload="this.width=screen.width;this.height=screen.height;" src="{{$paymentRequest->gc_form_action}}" frameBorder="0">Browser not compatible.</iframe>
            </div>
        </div>
    </div>
@stop