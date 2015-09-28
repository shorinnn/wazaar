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
            <form id="manage-order-form">
                <input type="hidden" name="sort-by" id="sort-by" value="{{$sort_by}}">
                <input type="hidden" name="sort" id="sort" value="{{$sort}}">
                <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" id="search" placeholder="{{ trans('administration.orders.search-placeholder' )}}" value="{{$search}}">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" style="height:38px;" onclick="searchOrder();"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>                
                <div class="orders-listings-container ajax-content"></div>
            </form>
            <div class="text-center alax-loader hide"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></div>
		</div>
	</div>
</div>

@stop

@section('extra_js')
<script>
    function addSorterIndicator()
    {
        console.log('asdasdasd')
        $('a.sorter').each(function(){
            if($(this).data('sort-by') == $('#sort-by').val())
            {
                $(this).addClass('active')
                if($('#sort').val() == 'asc'){
                    $(this).children('i.fa').removeClass('fa-caret-down').addClass('fa-caret-up')
                } else {
                    $(this).children('i.fa').addClass('fa-caret-down').removeClass('fa-caret-up')
                }
            } else {
                $(this).removeClass('active')
                $(this).children('i.fa').removeClass('fa-caret-down').removeClass('fa-caret-up')
            }
        })
        triggerSorter();
    }

    function searchOrder()
    {
        var url = '/administration/manage-orders?';
        var data = Array('sort_by='+$('#sort-by').val(),'sort='+$('#sort').val(),'search='+$('#search').val());
        url = url + data.join('&');

        $('.ajax-content').html( '<a href="#" data-callback="ajaxifyPagination" data-callback-2="scrollToElement" data-target=".ajax-content" data-url="'+url+'" class="load-remote course-desc-ajax-link">loading</a>' );
        $('.course-desc-ajax-link').click();
    }
    function triggerSorter()
    {
        $('a.sorter').click(function(e){
            e.preventDefault();
            if($(this).hasClass('active')){
                if($(this).data('sort') == 'asc'){
                    $(this).data('sort', 'desc')
                } else {
                    $(this).data('sort', 'asc')
                }
            } else {
                $('a.sorter').removeClass('active').data('sort', '');
                $(this).addClass('active').data('sort', 'asc');
            }
            $('#sort').val($(this).data('sort'))
            $('#sort-by').val($(this).data('sort-by'))
            // loadOrders();

            var url = '/administration/manage-orders?';
            var data = Array('sort_by='+$('#sort-by').val(),'sort='+$('#sort').val(),'search='+$('#search').val());
            url = url + data.join('&');

            $('.ajax-content').html( '<a href="#" data-callback="ajaxifyPagination" data-callback-2="scrollToElement" data-target=".ajax-content" data-url="'+url+'" class="load-remote course-desc-ajax-link">loading</a>' );
            $('.course-desc-ajax-link').click();
        })
    }
    function loadOrders()
    {
        var url = '/administration/manage-orders?';
        var data = Array('sort_by='+$('#sort-by').val(),'sort='+$('#sort').val(),'search='+$('#search').val())
        // console.log(data);

        url = url + data.join('&');

        $('.alax-loader').hide().removeClass('hide').show();
        $.ajax({
            url: url,
            cache: false,
            success: function(result){
                $('.alax-loader').hide();
                $('.orders-listings-container').html(result);
                triggerSorter();
                ajaxifyPagination( null );
                addSorterIndicator();
            }
        });
    }
    jQuery(document).ready(function($){
        loadOrders();
    });
</script>
@stop