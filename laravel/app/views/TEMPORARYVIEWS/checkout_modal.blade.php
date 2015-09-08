@extends('layouts.default')
@section('content')

<!-- Small modal -->
<div class="text-center margin-top-40 margin-bottom-40">
	<button type="button" class="large-button blue-button" data-toggle="modal" data-target=".payment-modal">Small modal</button>
</div>
<div class="modal fade payment-modal" tabindex="-1" role="dialog" aria-labelledby="courseCheckoutModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content checkout-modal">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
            <div class="profile-image"></div>
            <p class="intro-paragraph description">売却益20％を狙う金貨・銀貨アンテ ...</p>
            <span class="price">¥ 7,200</span>
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

@stop
@section('extra_js')
<script>

	$(document).ready(function(){ 
		// Switching the active class between selected radio button section on checkout modal	
		$('.checkout-modal input[type="radio"]:checked').parent().parent().addClass("active");
		$('.checkout-modal input[type="radio"]').click(function () {
			$('.checkout-modal input[type="radio"]:not(:checked)').parent().parent().removeClass("active");
			$('.checkout-modal input[type="radio"]:checked').parent().parent().addClass("active");
    	});  
	});

</script>
@stop