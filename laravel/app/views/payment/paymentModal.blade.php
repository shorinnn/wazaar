<div id="modal-payment" class="modal fade payment-modal" tabindex="-1" role="dialog" aria-labelledby="courseCheckoutModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content checkout-modal">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
                <div class="profile-image"></div>
                <p class="intro-paragraph description" id="itemName"></p>
                <span class="price">¥ <span id="itemPrice"></span></span>
            </div>
            <div class="modal-body clearfix">
                <div class="bootbox-body">
                    <section>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                            <div class="">
                                <div class="row no-margin">
                                    <div>
                                        <form>
                                            <div class="cards-wrap clearfix">
                                        <span class="cc-card-button radio-style-2">
                                            <input type="radio" checked="checked" name="credit-card-id" id="card-1">
                                            <label class="small-radio-2" for="card-1"></label>
                                        </span>
                                                <div class="card-details">
                                                    <h4>Mastercard ending 7569</h4>
                                                    <p class="regular-paragraph">Expires 12/16</p>
                                                </div>
                                        <span class="card-logo mastercard">

                                        </span>
                                            </div>
                                            <div class="cards-wrap clearfix">
                                        <span class="cc-card-button radio-style-2">
                                            <input type="radio" name="credit-card-id" id="card-2">
                                            <label class="small-radio-2" for="card-2"></label>
                                        </span>
                                                <div class="card-details">
                                                    <h4>Visa ending 7569</h4>
                                                    <p class="regular-paragraph">Expires 12/16</p>
                                                </div>
                                        <span class="card-logo visa">

                                        </span>
                                            </div>
                                            <div class="clearfix new-card">
                                        <span class="cc-card-button radio-style-2">
                                            <input type="radio" name="credit-card-id" id="card-2">
                                            <label class="small-radio-2" for="card-2"></label>
                                        </span>
                                                <div class="card-details">
                                                    <h4 class="add-new-card">Add new credit card</h4>
                                                </div>
                                                <span class="card-logo hide"></span>
                                                <div class="clear new-cc-form">
                                                    <div class="clear">
                                                        <label>Credit Card number</label>
                                                        <input type="text" placeholder="0000 0000 0000 0000">
                                                    </div>
                                                    <div class="clear">
                                                        <div class="left ccv-code">
                                                            <label>CCV Code <span class="ccv-tip" data-toggle="tooltip" data-placement="top"
                                                                                  title="Tip on top">?</span></label>
                                                            <input type="text" placeholder="">
                                                        </div>
                                                        <div class="right expiry-date">
                                                            <label>Expiry date</label>
                                                            <input type="date" placeholder="MM / YY">
                                                        </div>
                                                    </div>
                                                    <div class="clear">
                                                        <label>Name on the card</label>
                                                        <input type="text" class="no-margin" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="button text-center">
                                                <button type="submit" class="blue-button large-button pay-button"><i class="fa fa-lock"></i>Pay ¥7,200</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
{{--
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
--}}