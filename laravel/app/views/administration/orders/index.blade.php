@extends('layouts.default')

@section('content')	
<style>
    .form-horizontal input,
    .form-horizontal select{
        margin-bottom: 0px;
    }
    .form-horizontal .input-group-btn button{
        height: 38px;
    }
    .course-details{
        padding: 20px 0px;
    }
    .big-red-circle-btn-container{

    }
    .big-red-circle{
        background: #D90000;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 0px;
        color: #fff;
		margin: 30px 0 10px;
    }
	.search-order{
		margin-right:15px;
	}
	.download-csv{
		padding: 11px 24px;
		position: relative;
		top: 1px;
	}
</style>
<div class="col-lg-10 col-lg-offset-1 course-categories">
	<div class="row">
    	<div class="col-md-12">
            <h1 class='icon'>{{ trans('administration.orders.manage-orders' )}}</h1>
        </div>
    </div>
	<div class="row">
    	<div class="col-md-12">
            <h2 class="text-center">{{ trans('administration.orders.search-course' )}}</h2>
            <div class="row">
                <form id="search_form" class="form-horizontal" style="padding-bottom:20px;">
                    <input type="hidden" name="sort_by" id="sort_by" value="{{$sort_by}}">
                    <input type="hidden" name="sort" id="sort" value="{{$sort}}">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.orders.label.name' )}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="course_name" name="course_name" value="{{$course_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.orders.label.category' )}}</label>
                            <div class="col-sm-9">
                                {{Form::select('course_category', $course_categories, $course_category, ['id'=>'course_category', 'class'=>'form-control'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.orders.label.filter' )}}</label>
                            <div class="col-sm-9">
                                {{Form::select('filter', $filters, $filter, ['id'=>'filter', 'class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.orders.label.email' )}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="email" name="email" value="{{$email}}">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr style="margin-top:0px;" />
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.orders.label.sales-amount' )}}</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <div class="input-group-addon">¥</div>
                                            <input type="text" class="form-control text-center" name="sale_amount_low" value="{{$sale_amount_low}}">
                                        </div>
                                    </div>
                                    <span class="pull-left">-</span>
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <div class="input-group-addon">¥</div>
                                            <input type="text" class="form-control text-center" name="sale_amount_high" value="{{$sale_amount_high}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.orders.label.product-price' )}}</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <div class="input-group-addon">¥</div>
                                            <input type="text" class="form-control text-center" name="product_price_low" value="{{$product_price_low}}">
                                        </div>
                                    </div>
                                    <span class="pull-left">-</span>
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <div class="input-group-addon">¥</div>
                                            <input type="text" class="form-control text-center" name="product_price_high" value="{{$product_price_high}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.orders.label.date' )}}</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="alert alert-danger hide date-warning"></div>
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <input type="text" id="start-date" class="form-control text-center" readonly="readonly" name="purchase_date_low" value="{{$purchase_date_low}}">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" id="start-date-btn" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <span class="pull-left">-</span>
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <input type="text" id="end-date" class="form-control text-center" readonly="readonly" name="purchase_date_high" value="{{$purchase_date_high}}">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" id="end-date-btn" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xs-1 col-sm-1 hide clear_date_btn">
                                        <a href="#" class="btn btn-default btn-xs"><i class="fa fa-remove"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.orders.label.transaction-id' )}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="transaction_id" name="transaction_id" value="{{$transaction_id}}">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr style="margin-top:0px;" />
                    {{-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.orders.label.course-id' )}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="course_id" name="course_id" value="{{$course_id}}">
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-xs-12 text-center">
                        <button type="button" class="blue-button large-button search-order" onclick="searchOrder();">{{ trans('administration.orders.search' )}} <i class="fa fa-search"></i></button>
                    	<button type="button" class="green-button large-button clearfix download-csv" onclick="downloadCsv();"><i class="fa fa-download"></i> {{ trans('administration.orders.download-csv' )}}</button>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="clearfix"></div>                
            
            <div class="container">
                <div class="panel panel-default no-padding">
                    <div class="orders-totals-container">
                        <div class="table-stats-wrapper">
                            <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="no-padding">
                    <div class="orders-listings-container ajax-content"></div>
                    <div class="text-center alax-loader hide"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></div>
                </div>
            </div>
		</div>
	</div>
    <div id="order-modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="details-container">
                        <img src="{{url('images/ajax-loader.gif')}}" class="img-responsive" style="margin:10px auto;" />
                    </div>
                    <div class="text-center">
                        <button type="button" class="blue-button large-button" data-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('extra_extra_js')
<script>
    function viewModalDetails(el)
    {
        var $modal = $('#order-modal').modal();
        var id = $(el).data('id');
        var url = '/administration/manage-orders/'+id;

        $.ajax({
            url: url,
            cache: false,
            success: function(result){
                $modal.find('.details-container').html(result);
            }
        });
        $modal.on('hidden.bs.modal', function(){
            $modal.find('.details-container').html('<img src="{{url('images/ajax-loader.gif')}}" class="img-responsive" style="margin:10px auto;" />');
        });
    }

    function downloadCsv()
    {
        var url = '/administration/manage-orders?';
        var data = $('#search_form').serialize();
        url = url + data + '&download=true';
        // console.log(url)
        window.location.href = url;
    }
    function addSorterIndicator()
    {
        $('a.sorter').each(function(){
            if($(this).data('sort-by') == $('#sort_by').val())
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
        var data = $('#search_form').serialize()

        url = url + data;

        $('.orders-listings-container').html( '<a href="#" data-callback="ajaxifyPagination" data-target=".orders-listings-container" data-url="'+url+'" class="load-remote orders-listings-ajax-link">loading</a>' );

        url = url + '&total=true';
        $('.orders-totals-container').html( '<a href="#" data-callback="ajaxifyPagination" data-target=".orders-totals-container" data-url="'+url+'" class="load-remote orders-totals-ajax-link">loading</a>' );
        
        $('.orders-totals-ajax-link').click();
        $('.orders-listings-ajax-link').click();
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
            $('#sort_by').val($(this).data('sort-by'))
            // loadOrders();

            var url = '/administration/manage-orders?';
            var data = $('#search_form').serialize()
            url = url + data;

            $('.ajax-content').html( '<a href="#" data-callback="ajaxifyPagination" data-target=".ajax-content" data-url="'+url+'" class="load-remote course-desc-ajax-link">loading</a>' );
            $('.course-desc-ajax-link').click();
        })
    }
    function loadOrders()
    {
        var url = '/administration/manage-orders?';
        var data = $('#search_form').serialize()

        url = url + data;

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

        url = url + '&total=true';
        $.ajax({
            url: url,
            cache: false,
            success: function(result){
                $('.orders-totals-container').html(result);
            }
        });
    }
    jQuery(document).ready(function($){
        loadOrders();

        var today = moment();
        var startDateVal = $('#start-date').val();
        var endDateVal = $('#end-date').val();
        
        if(startDateVal == '' || endDateVal == ''){
            var startDate = today.format('YYYY-MM-DD');
            var endDate = today.add(1, 'day').format('YYYY-MM-DD');
            $('#start-date-btn').data('date', startDate)
            $('#end-date-btn').data('date', endDate)
        } else {
            $('.clear_date_btn').hide().removeClass('hide').show();
            var startDate = startDateVal;
            var endDate = startDateVal;
            $('#start-date-btn').data('date', startDateVal)
            $('#end-date-btn').data('date', endDateVal)
        }

        $('#start-date-btn').datepicker({
            format: 'yyyy-mm-dd'
        })
            .on('changeDate', function(ev){
                startDate = new Date(ev.date);
                $('#start-date').val($('#start-date-btn').data('date'));
                
                if($('#end-date').val() != ''){
                    tomorrow = moment($('#start-date').val()).add(1, 'day');
                    if (ev.date.valueOf() > endDate.valueOf()){
                        $('.date-warning').hide().removeClass('hide').show().text('The start date can not be greater then the end date');
                        setTimeout(function(){
                            $('.date-warning').hide().text('');
                        }, 2000);
                        $('#end-date').val(tomorrow.format('YYYY-MM-DD'));
                        $('#end-date-btn').datepicker('setValue', tomorrow.format('YYYY-MM-DD'))
                    }
                }

                $('#start-date-btn').datepicker('hide');
                $('.clear_date_btn').hide().removeClass('hide').show();
            });
        $('#end-date-btn').datepicker({
            format: 'yyyy-mm-dd'
        })
            .on('changeDate', function(ev){
                endDate = new Date(ev.date);
                $('#end-date').val($('#end-date-btn').data('date'));
                if($('#start-date').val() != ''){
                    yesterday = moment($('#end-date').val()).subtract(1, 'day');
                    if (ev.date.valueOf() < startDate.valueOf()){
                        $('.date-warning').hide().removeClass('hide').show().text('The end date can not be less then the start date');
                        setTimeout(function(){
                            $('.date-warning').hide().text('');
                        }, 2000);
                        $('#start-date').val(yesterday.format('YYYY-MM-DD'));
                        $('#start-date-btn').datepicker('setValue', yesterday.format('YYYY-MM-DD'))
                    }
                }
                $('#end-date-btn').datepicker('hide');
                $('.clear_date_btn').hide().removeClass('hide').show();
            });

        $('.clear_date_btn').click(function(e){
            e.preventDefault();
            $('#start-date').val('');
            $('#end-date').val('');
            $(this).hide();
        })
        // console.log($('#search_form').serialize())
    });
</script>
@stop