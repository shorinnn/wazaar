@extends('layouts.default')
@section('extra_css')
    <style type="text/css">
        .panel-title {display: inline;font-weight: bold;}
        .checkbox.pull-right { margin: 0; }
        .pl-ziro { padding-left: 0px; }
    </style>
@stop
@section('content')

    <section class="container-fluid checkout-page">
        <div class="container">
            <div class="row">
                <div class="col-md-1 col-lg-1 hidden-xs hidden-sm"></div>
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 customer-info">
                    @if (count(@$errors) > 0)
                        <h1>{{trans('general.errors')}}!</h1>
                        <ul>
                            @foreach($errors as $err)
                                <li><i class="glyphicon glyphicon-remove"></i> {{$err}}</li>
                            @endforeach
                        </ul>
                    @endif

                    <h1>
                        <span class="step-number">1</span>
                        Your Billing Info
                    </h1>
                    {{Form::open(['url' => url('payment'), 'id' => 'form-payment'])}}
                        <div class="row margin-top-20">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>first name</label>
                                <input type="text" name="firstName" class="margin-bottom-10" value="{{$student->profile->first_name}}">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>last name</label>
                                <input type="text" name="lastName" value="{{$student->profile->last_name}}">
                            </div>
                        </div>
                        <div class="row margin-top-30">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="Email Address" class="margin-bottom-10 form-control" value="{{$student->email}}">
                            </div>
                        </div>
                        <div class="row margin-top-30">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label>Address</label>
                                <input type="text" name="address1" placeholder="Address line 1" class="margin-bottom-10" value="{{$student->profile->address_1}}">
                                <input type="text" name="address2" placeholder="Address line 2" value="{{ $student->profile->address_2 }} "/>
                            </div>
                        </div>
                        <div class="row margin-top-30">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label>City</label>
                                <input type="text" name="city" placeholder="City" class="margin-bottom-10 form-control" value="{{$student->profile->city}}">
                            </div>
                        </div>
                        <div class="row margin-top-30">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>postal code</label>
                                <input type="text" name="zip" class="margin-bottom-10"  value="{{$student->profile->zip}}">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>country</label>
                                <select name="country">
                                    <option>Select country</option>
                                    <option value="JP" selected>Japan</option>
                                </select>
                            </div>
                        </div>
                        <h1>
                            <span class="step-number">2</span>
                            Credit Card Info
                        </h1>
                        <div class="row margin-top-20">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label>Credit Card number</label>
                                <input type="text" name="cardNumber" placeholder="0000 0000 0000 0000">
                            </div>
                        </div>
                        <div class="row margin-top-30">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>CVV Code</label>
                                <input type="text" name="cardCVV" class="margin-bottom-10">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Expiry date</label>
                                <input type="text" name="cardExpiry" placeholder="MM / YY">
                            </div>
                        </div>
                        <div class="row margin-top-30">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label>Name on the card</label>
                                <input type="text" name="cardName">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <button class="blue-button large-button place-your-order hidden-xs hidden-sm">Place your order</button>
                            </div>
                        </div>
                    {{Form::close()}}
                </div>
                <div class="col-md-1 col-lg-1 hidden-xs hidden-sm"></div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 product-info">
                    <h1>
                        {{trans('payment.youAreToEnroll')}}:
                    </h1>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 course-name">
                            <div class="row">
                                <div class="col-xs-5 col-sm-3 col-md-5 col-lg-5">

                                        <img src="{{@$product->previewImage->url}}" class="img-responsive" alt="">

                                </div>
                                <div class="col-xs-7 col-sm-9 col-md-7 col-lg-7 no-padding">
                                    <div>
                                        <p class="regular-paragraph">{{$product->name}}</p>
                                        <span class="regular-paragraph">{{$product->allModules->count()}} modules</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row product-price">
                        <span class="regular-paragraph">Price:</span>
                        <p>¥ {{number_format($amountToPay)}}</p>
                        <a href="#" class="blue-button extra-large-button place-your-order">Place your order</a>
                        <small class="regular-paragraph">By clicking the "Place your order" button, you agree to these
                            <a href="#">Terms of Service.</a>
                        </small>
                        <em class="regular-paragraph"><i class="fa fa-lock"></i>Secure Connection</em>
                    </div>
                </div>
            </div>
        </div>
    </section>


























    {{-- <div class="container payment-page course-editor">
        <div class="row">
            <div class="col-md-12">
                <h1 class='icon'>{{trans('payment.payment')}}</h1>
                <p>{{trans('payment.youAreToEnroll')}}...</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    {{$productPartial}}
                    <hr/>
                </div>

                <div class="col-md-6">
                    {{Form::open(['url' => url('payment'), 'id' => 'form-payment'])}}
                        <h4>Payment Method</h4>
                        <hr/>
                        @if (count($errors) > 0)
                            <h5>{{trans('general.errors')}}!</h5>
                            <ul>
                                @foreach($errors as $err)
                                    <li><i class="glyphicon glyphicon-remove"></i> {{$err}}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="ajax-errors hidden">
                            <h5>{{trans('general.errors')}}!</h5>
                            <ul>
                                <li></li>
                            </ul>
                        </div>

                        @if (!$renderForm)
                            <div class="alert alert-danger" role="alert">{{trans('payment.cannotPurchase')}}</div>
                        @else
                            @include('payment.panels.payeeInformation')
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{trans('payment.paymentDetails')}}</h3>
                                </div>
                                <div class="panel-body" id="panel-credit-card">
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
    </div> --}}
@stop

@section('extra_js')
    <script type="text/javascript">
        $(function(){

        });
    </script>
@stop