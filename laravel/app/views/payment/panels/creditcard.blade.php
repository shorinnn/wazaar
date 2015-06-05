{{--<div class="credit-card-wrapper">
    <div class="radio">
        <label>
            {{Form::radio('paymentOption','cc',true)}}
            {{trans('payment.creditCard')}}
        </label>
    </div>


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {{trans('payment.paymentDetails')}}
                        </h3>
                    </div>
                    <div class="panel-body">

                        @foreach(Config::get('globalcollect.creditCardCompanies') as $productId => $label)
                        <div class="radio">
                            <label>
                                <input type="radio" name="paymentProductId" value="{{$productId}}" class="radio-credit-card" />
                                {{$label}}
                            </label>
                        </div>
                        @endforeach
                        --BODY USED TO BE HERE--
                    </div>
                </div>
                <br/>
</div>--}}
{{--<div class="form-group">
    {{Form::label('cardNumber',trans('payment.cardNumber'))}}
    <div class="input-group">
        {{Form::text('cardNumber','',['class' => 'form-control'])}}
        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
    </div>
</div>
<div class="row">
    <div class="col-xs-7 col-md-7">
        <div class="form-group">
            {{Form::label('expiryDate',trans('payment.expiryDate'))}}
            <div class="col-xs-4 col-lg-4 pl-ziro">
                {{Form::text('expiryDate','',['class' => 'form-control', 'placeholder' => trans('payment.MM'), 'required'])}}
            </div>
            <div class="col-xs-4 col-lg-4 pl-ziro">
                {{Form::text('expiryDate','',['class' => 'form-control', 'placeholder' => trans('payment.YY'), 'required'])}}
            </div>

        </div>
    </div>
    <div class="col-xs-5 col-md-5 pull-right">
        <div class="form-group">
            {{Form::label('cvc', trans('payment.cvCode'))}}
            {{Form::password('cvc',['class' => 'form-control', 'required'])}}
        </div>
    </div>
</div>--}}


    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                {{Form::label('cardNumber',trans('payment.cardNumber'))}}
                <div class="input-group">
                    {{Form::text('cardNumber','',['class' => 'form-control'])}}
                    <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-7 col-md-7">
            <div class="form-group">
                <label for="expMonth">EXPIRATION DATE</label>
                <div class="col-xs-6 col-lg-6 pl-ziro">
                    <input type="text" class="form-control" name="expMonth" placeholder="MM" required data-stripe="exp_month" />
                </div>
                <div class="col-xs-6 col-lg-6 pl-ziro">
                    <input type="text" class="form-control" name="expYear" placeholder="YY" required data-stripe="exp_year" />
                </div>
            </div>
        </div>
        <div class="col-xs-5 col-md-5 pull-right">
            <div class="form-group">
                <label for="cvCode">CV CODE</label>
                <input type="password" class="form-control" name="cvCode" placeholder="CV" required data-stripe="cvc" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="couponCode">COUPON CODE</label>
                <input type="text" class="form-control" name="couponCode" />
            </div>
        </div>
    </div>

