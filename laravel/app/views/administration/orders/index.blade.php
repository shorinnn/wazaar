@extends('layouts.default')

@section('content')	
<div class="col-lg-10 col-lg-offset-1 course-categories">
	<div class="row">
    	<div class="col-md-12">
            <h1 class='icon'>{{ trans('administration.orders.manage-orders' )}}</h1>
        </div>
    </div>
	<div class="row">
    	<div class="col-md-12">
            <div class="text-center alax-loader hide"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></div>
            <div class="orders-listings-container ajax-content"></div>
		</div>
	</div>
</div>

@stop

@section('extra_js')
<script>
    function loadOrders()
    {
        $('.alax-loader').hide().removeClass('hide').show();
        $.ajax({
            url: '/administration/manage-orders',
            cache: false,
            success: function(result){
                $('.alax-loader').hide();
                $('.orders-listings-container').html(result);
                ajaxifyPagination( null );
            }
        });
    }

    jQuery(document).ready(function($){
        loadOrders();
    });
</script>
@stop