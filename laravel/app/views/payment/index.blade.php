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
                <h1 class='icon'>Payment</h1>
                <p>You are about to enroll in...</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">

                    <div class="object small-box small-box-one">
                        <div class="img-container">
                            <img src="https://wazaardev.s3.amazonaws.com/course_preview/54905d56385ce.png" class="img-responsive" alt="">
                        </div>
                        <div class="next_" style="position: relative; ">
                           <div style="color:#fff; padding: 15px 0 0 10px;">Course Name Here</div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-4"><strong>Price</strong></div>
                            <div class="col-md-6">10,000</div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-4"><strong>Tax(8%)</strong></div>
                            <div class="col-md-6">800</div>
                        </div>
                        <hr/>
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a href="#"><span class="badge pull-right"><span class="glyphicon glyphicon-usd"></span>4200</span> Total</a>
                            </li>
                        </ul>
                    </div>

                    <hr/>




                </div>

                <div class="col-md-6">
                    <h4>Payment Method</h4>
                    <hr/>
                    <div class="credit-card-wrapper">
                        <form action="">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                                    Credit Card
                                </label>
                            </div>

                            <div class="container">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    Payment Details
                                                </h3>
                                                
                                            </div>
                                            <div class="panel-body">
                                                <form role="form">
                                                    <div class="form-group">
                                                        <label for="cardNumber">
                                                            CARD NUMBER</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="cardNumber" placeholder="Valid Card Number"
                                                                   required autofocus />
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-7 col-md-7">
                                                            <div class="form-group">
                                                                <label for="expityMonth">
                                                                    EXPIRY DATE</label>
                                                                <div class="col-xs-6 col-lg-6 pl-ziro">
                                                                    <input type="text" class="form-control" id="expityMonth" placeholder="MM" required />
                                                                </div>
                                                                <div class="col-xs-6 col-lg-6 pl-ziro">
                                                                    <input type="text" class="form-control" id="expityYear" placeholder="YY" required /></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-5 col-md-5 pull-right">
                                                            <div class="form-group">
                                                                <label for="cvCode">
                                                                    CV CODE</label>
                                                                <input type="password" class="form-control" id="cvCode" placeholder="CV" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <br/>
                                        <a href="http://www.jquery2dotnet.com" class="btn btn-success btn-lg btn-block" role="button">Pay</a>
                                    </div>
                                </div>
                            </div>

                        </form>


                    </div>

                    <div class="bank-transfer">

                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

