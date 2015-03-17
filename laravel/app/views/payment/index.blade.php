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
                    {{Form::open(['url' => url('payment')])}}
                        <h4>Payment Method</h4>
                        <hr/>
                        @if (count($errors) > 0)
                            <h5>Errors!</h5>
                            <ul>
                                @foreach($errors as $err)
                                    <li><i class="glyphicon glyphicon-remove"></i> {{$err}}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (!$renderForm)
                            <div class="alert alert-danger" role="alert">{{trans('payment.cannotPurchase')}}</div>
                        @else
                            @include('payment.panels.payeeInformation')
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Payment Method</h3>
                                </div>
                                <div class="panel-body">
                                    @include('payment.panels.creditcard')
                                </div>

                            </div>
                            <div class="bank-transfer-wrapper">

                            </div>
                            <button type="submit" class="btn btn-success btn-lg btn-block" role="button">{{trans('payment.pay')}}</button>
                            <a class="btn btn-danger btn-lg btn-block" href="{{url('courses/cancel-purchase')}}">{{trans('payment.cancel')}}</a>
                        @endif

                    {{Form::close()}}

                    <div>&nbsp;</div>




                </div>
            </div>
        </div>
    </div>
@stop