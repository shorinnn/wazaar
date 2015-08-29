var Payment = {
    'form' : $('#modal-payment'),
    'productId' : 0,
    'productType' : 'course',
    'productName' : '',
    'amount' : 0,
    'showForm' : function ($element, $event){
        $event.preventDefault();
        Payment.productId = $($element).attr('data-product-id');
        Payment.productType = $($element).attr('data-product-type');
        Payment.productName = $($element).attr('data-item-name');
        Payment.amount = $($element).attr('data-price');

        $('#itemName').val(Payment.productName);
        $('#itemPrice').val(Payment.amount);
        Payment.form.modal('show');
    },
    'doPay' : function($event){
        $event.preventDefault();
        var $whichPayment = $('input[name=whichPayment]:checked').val();

        if ($whichPayment == 'new'){
            Payment.doNewPayment()
        }
        else{
            Payment.doExistingPayment();
        }


    },
    'doExistingPayment' : function(){
        var $cardId = $('input[name=radioPaymentOption]:checked').val();

        $.post('/payment/process-existing-stripe-payment', {cardId: $cardId,productId: Payment.productId, productType: Payment.productType, amount: Payment.amount},function (){

        });
    },
    'doNewPayment' : function(){
        var $ccName = $('#cardName').val();
        var $ccNumber = $('#cardNumber').val();
        var $ccExpiryMonth = $('#expiryMonth').val();
        var $ccExpiryYear = $('#expiryYear').val()
        var $ccCvv = $('#cvv').val();

        //Validate locally first
        if (!Stripe.card.validateCardNumber($ccNumber)){
            alert('Invalid card');
            return;
        }

        if (!Stripe.card.validateExpiry($ccExpiryMonth, $ccExpiryYear)){
            alert('Invalid expiry');
            return;
        }

        if (!Stripe.card.validateCVC($ccCvv)){
            alert('invalid cvv');
            return;
        }

        Stripe.card.createToken({
            number: $ccNumber,
            cvc: $ccCvv,
            exp_month: $ccExpiryMonth,
            exp_year: $ccExpiryYear
        }, Payment.responseHandler);
    },
    'responseHandler' : function($status,$response){

        if ($response.error) {
            // Show the errors on the form
            $('#payment-errors').html($response.error.message);
        } else {
            // response contains id and card, which contains additional card details
            var token = $response.id;
            $.post('/payment/process-stripe',{token: token, productId: Payment.productId, productType: Payment.productType, amount: Payment.amount}, function ($response){

            },'json');

        }
    }

};

$(function(){
    Stripe.setPublishableKey('pk_test_vJFKFUdO903PH27xZOS3eLMn');

    $('input[name=whichPayment]').on('click', function (){
        if($(this).val() == 'new'){
            $('.existing-card-wrapper').addClass('hidden');
            $('.new-card-wrapper').removeClass('hidden');
        }
        else{
            $('.new-card-wrapper').addClass('hidden');
            $('.existing-card-wrapper').removeClass('hidden');
        }
    });
});
