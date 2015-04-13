<div class="credit-card-wrapper">
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
                                        <div class="col-xs-8 col-lg-8 pl-ziro">
                                            {{Form::text('expiryDate','',['class' => 'form-control', 'placeholder' => trans('payment.MMYY'), 'required'])}}
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

                    </div>
                </div>
                <br/>






</div>