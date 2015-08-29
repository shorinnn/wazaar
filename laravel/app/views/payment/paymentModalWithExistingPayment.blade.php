<!-- Modal -->
<div class="modal fade" id="modal-payment" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Payment Form</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-error hidden" id="payment-errors"></div>
                <form class="form-horizontal" role="form">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="card-holder-name">Item Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="itemName" disabled id="itemName"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="card-holder-name">Price</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="itemPrice" disabled id="itemPrice"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="card-number">Card Number</label>
                            <div class="col-sm-8">
                                **********1234
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="expiry-month">Expiration Date</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-xs-4">
                                        02/17
                                    </div>

                                </div>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="button" class="btn btn-success" id="btn-pay" onclick="Payment.doPay(event);"><i class="fa fa-money"></i> Pay</button>
            </div>
        </div>
    </div>
</div>