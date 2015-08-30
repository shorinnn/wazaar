<!-- Modal -->
<div class="modal fade" id="modal-payment" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Payment Form</h4>
            </div>

            <div class="modal-body">

                @if (PaymentHelper::hasExistingPaymentMethods())
                    <div class="payment-options">
                        <input type="radio" name="whichPayment" value="existing" checked /> Select Existing Payment Method
                        <div class="existing-card-wrapper">
                            @include('payment.partials.options')
                        </div>
                    </div>

                    <div class="payment-form">
                        <input type="radio" name="whichPayment" value="new"/>
                        Add New Payment Method
                        <div class="new-card-wrapper hidden">
                            @include('payment.partials.form')
                        </div>
                    </div>
                @else
                    @include('payment.partials.form')
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="btn-close-pay" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="button" class="btn btn-success" id="btn-pay" onclick="Payment.doPay(event);"><i class="fa fa-money"></i> <span class="pay-label">Pay</span></button>
            </div>
        </div>
    </div>
</div>