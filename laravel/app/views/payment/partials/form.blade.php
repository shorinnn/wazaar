<div class="alert alert-error hidden" id="payment-errors"></div>
<form class="form-horizontal" role="form">
    <fieldset>
        {{--<div class="form-group">
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
        </div>--}}
        <div class="form-group">
            <label class="col-sm-4 control-label" for="card-holder-name">Name on Card</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="cardName" id="cardName" placeholder="Card Holder's Name">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="card-number">Card Number</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="cardNumber" id="cardNumber" placeholder="Debit/Credit Card Number">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="expiry-month">Expiration Date</label>
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-xs-4">
                        <select class="form-control col-sm-2" name="expiryMonth" id="expiryMonth">
                            <option>Month</option>
                            <option value="01">Jan (01)</option>
                            <option value="02">Feb (02)</option>
                            <option value="03">Mar (03)</option>
                            <option value="04">Apr (04)</option>
                            <option value="05">May (05)</option>
                            <option value="06">June (06)</option>
                            <option value="07">July (07)</option>
                            <option value="08">Aug (08)</option>
                            <option value="09">Sep (09)</option>
                            <option value="10">Oct (10)</option>
                            <option value="11">Nov (11)</option>
                            <option value="12">Dec (12)</option>
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <select class="form-control" id="expiryYear" name="expiryYear">
                            @for($i = date('Y'); $i< date('Y') + 16; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="cvv">Card CVV</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="cvv" id="cvv" placeholder="Security Code">
            </div>
        </div>
    </fieldset>
</form>