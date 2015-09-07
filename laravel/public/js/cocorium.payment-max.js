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

        if ($whichPayment == 'existing'){
            Payment.doExistingPayment();
        }
        else{
            Payment.doNewPayment()
        }


    },
    'doExistingPayment' : function(){
        var $cardId = $('input[name=radioPaymentOption]:checked').val();
        $('#btn-pay').attr('disabled','disabled');
        $.post('/payment/process-existing-stripe-payment', {cardId: $cardId,productId: Payment.productId, productType: Payment.productType, amount: Payment.amount},function ($response){
            if ($response.success == 1){
                alert('Payment successful');
                window.location.reload();
            }
        },'json');
    },
    'doNewPayment' : function(){
        $('#btn-pay').attr('disabled','disabled');
        var $ccName = $('#cardName').val();
        var $ccNumber = $('#cardNumber').val();
        var $ccExpiryMonth = $('#expiryMonth').val();
        var $ccExpiryYear = $('#expiryYear').val()
        var $ccCvv = $('#cvv').val();

        //Validate locally first

    }
};

$(function(){
    //Choose Existing Card or Add New event handler
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
    //Remove existing card event handler
    $('.remove-card').on('click', function($e){
        $e.preventDefault();
        var $elem = $(this);
        var $id = $elem.attr('data-payment-log-id');
        bootbox.confirm(_('Are you sure?'), function ($response){
            if ($response){
                $.post('/payment/remove-payment-log',{id: $id}, function($response){
                    $elem.parent().parent().remove();
                },'json');
            }
        });

    });
});
