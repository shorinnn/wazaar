@extends('layouts.default')
@section('extra_css')
    <style type="text/css">
        .panel-title {display: inline;font-weight: bold;}
        .checkbox.pull-right { margin: 0; }
        .pl-ziro { padding-left: 0px; }
    </style>
@stop
@section('content')
    <div class="container payment-page course-editor">
        <div class="row">
            <div class="col-md-12">
                <h1 class='icon'>{{trans('payment.payment')}}</h1>
                <p>You are about to enroll in...</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    {{$productPartial}}
                    <hr/>
                </div>

                <div class="col-md-6">
                    <h4>Payment Method</h4>
                    <hr/>
                    <div class="credit-card-wrapper">
                        @if (count($errors) > 0)
                            <ul>
                                @foreach($errors as $err)
                                    <li class="alert alert-danger">{{$err}}</li>
                                @endforeach
                            </ul>
                        @endif
                        {{Form::open(['url' => url('payment')])}}

                            <div class="radio">
                                <label>
                                    {{Form::radio('paymentOption','cc',true)}}
                                    {{trans('payment.creditCard')}}
                                </label>
                            </div>

                            <div class="container">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    {{trans('payment.paymentDetails')}}
                                                </h3>
                                            </div>
                                            <div class="panel-body">
                                                <form role="form">
                                                    <div class="form-group">
                                                        {{Form::label('cardNumber',trans('payment.cardNumber'))}}
                                                        <div class="input-group">
                                                            {{Form::text('cardNumber','',['class' => 'form-control'])}}
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-7 col-md-7">
                                                            <div class="form-group">
                                                                {{Form::label('expiryMonth',trans('payment.expiryDate'))}}
                                                                <div class="col-xs-6 col-lg-6 pl-ziro">
                                                                    {{Form::text('expiryMonth','',['class' => 'form-control', 'placeholder' => trans('payment.MM'), 'required'])}}
                                                                </div>
                                                                <div class="col-xs-6 col-lg-6 pl-ziro">
                                                                    {{Form::text('expiryYear','',['class' => 'form-control', 'placeholder' => trans('payment.YY'), 'required'])}}
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-xs-5 col-md-5 pull-right">
                                                            <div class="form-group">
                                                                {{Form::label('cvc', trans('payment.cvCode'))}}
                                                                {{Form::password('cvc',['class' => 'form-control', 'required'])}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <br/>
                                        <button class="btn btn-success btn-lg btn-block" role="button">{{trans('payment.pay')}}</button>
                                    </div>
                                </div>
                            </div>

                        </form>


                    </div>

                    <div class="bank-transfer-wrapper">

                    </div>

                </div>
            </div>
        </div>
    </div>
@stop