<ul style="padding-left: 20px">
    @foreach(PaymentHelper::getPaymentMethods() as $payment)
        <li>
                <div>
                    <input type="radio" name="radioPaymentOption" value="{{$payment->response['card_id']}}" />
                    <i class="fa fa-{{PaymentHelper::getCCIcon($payment->response['card'])}}"></i> {{$payment->response['card']}}
                    <a href="#" class="remove-card" data-payment-log-id="{{$payment->id}}"><i class="fa fa-times"></i></a>
                </div>
                <div style="margin-left: 20px">Card Number: ***********{{$payment->response['last4']}}</div>
                <div style="margin-left: 20px">Expiry: {{$payment->response['exp_month']}}/{{$payment->response['exp_year']}}</div>
        </li>
    @endforeach
</ul>