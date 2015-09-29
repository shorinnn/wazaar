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
</style>
<div class="col-lg-10 col-lg-offset-1 course-categories">
	<div class="row">
    	<div class="col-md-12">
            <h1 class='icon'>{{ trans('administration.orders.manage-orders' )}}</h1>
        </div>
    </div>
	<div class="row">
    	<div class="col-md-12">
            <h2 class="text-center">Search Course</h2>
            <div class="row">
                <form id="search_form" class="form-horizontal" style="padding-bottom:20px;">
                    <input type="hidden" name="sort_by" id="sort_by" value="{{$sort_by}}">
                    <input type="hidden" name="sort" id="sort" value="{{$sort}}">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="course_name" name="course_name" value="{{$course_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Category</label>
                            <div class="col-sm-9">
                                {{Form::select('course_category', $course_categories, $course_category, ['id'=>'course_category', 'class'=>'form-control'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-9">
                                {{Form::select('course_status', $course_statuses, $course_status, ['id'=>'course_status', 'class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="email" name="email" value="{{$email}}">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr style="margin-top:0px;" />
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sales Amount</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <div class="input-group-addon">¥</div>
                                            <input type="text" class="form-control text-center" name="sale_amount_low" value="{{$sale_amount_low}}">
                                            <div class="input-group-addon">.00</div>
                                        </div>
                                    </div>
                                    <span class="pull-left">-</span>
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <div class="input-group-addon">¥</div>
                                            <input type="text" class="form-control text-center" name="sale_amount_high" value="{{$sale_amount_high}}">
                                            <div class="input-group-addon">.00</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Product Price</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <div class="input-group-addon">¥</div>
                                            <input type="text" class="form-control text-center" name="product_price_low" value="{{$product_price_low}}">
                                            <div class="input-group-addon">.00</div>
                                        </div>
                                    </div>
                                    <span class="pull-left">-</span>
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <div class="input-group-addon">¥</div>
                                            <input type="text" class="form-control text-center" name="product_price_high" value="{{$product_price_high}}">
                                            <div class="input-group-addon">.00</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date</label>
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr style="margin-top:0px;" />
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Course ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="course_id" name="course_id" value="{{$course_id}}">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 text-center">
                        <button type="button" class="btn btn-primary btn-lg" onclick="searchOrder();">Search <i class="fa fa-search"></i></button>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="clearfix"></div>                
            <div class="orders-listings-container ajax-content"></div>
            <div class="text-center alax-loader hide"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></div>
		</div>
	</div>
</div>

@stop

@section('extra_js')
<script>
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
            $('#sort_by').val($(this).data('sort-by'))
            // loadOrders();

            var url = '/administration/manage-orders?';
            var data = Array('sort_by='+$('#sort_by').val(),'sort='+$('#sort').val(),'search='+$('#course_name').val());
            url = url + data.join('&');

            $('.ajax-content').html( '<a href="#" data-callback="ajaxifyPagination" data-callback-2="scrollToElement" data-target=".ajax-content" data-url="'+url+'" class="load-remote course-desc-ajax-link">loading</a>' );
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
    }
    jQuery(document).ready(function($){
        loadOrders();

        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var startDateVal = $('#start-date').val();
        var endDateVal = $('#end-date').val();
        if(startDateVal == '' || endDateVal == ''){
            var startDate = now;
            var endDate = now;
            $('#start-date-btn').data('date', startDate)
            $('#end-date-btn').data('date', endDate)
        } else {
            var startDate = startDateVal;
            var endDate = startDateVal;
            $('#start-date-btn').data('date', startDateVal)
            $('#end-date-btn').data('date', endDateVal)
        }

        $('#start-date-btn').datepicker({
            format: 'yyyy-mm-dd'
        })
            .on('changeDate', function(ev){
                if (ev.date.valueOf() > endDate.valueOf()){
                    $('.date-warning').hide().removeClass('hide').show().text('The start date can not be greater then the end date');
                    setTimeout(function(){
                        $('.date-warning').hide().text('');
                    }, 2000);
                } else {
                    $('.date-warning').hide();
                    startDate = new Date(ev.date);
                    $('#start-date').val($('#start-date-btn').data('date'));
                }
                $('#start-date-btn').datepicker('hide');
                $('.datepicker.dropdown-menu').is(':visible').remove();
            });
        $('#end-date-btn').datepicker({
            format: 'yyyy-mm-dd'
        })
            .on('changeDate', function(ev){
                if (ev.date.valueOf() < startDate.valueOf()){
                    $('.date-warning').hide().removeClass('hide').show().text('The end date can not be less then the start date');
                    setTimeout(function(){
                        $('.date-warning').hide().text('');
                    }, 2000);
                } else {
                    $('.date-warning').hide();
                    endDate = new Date(ev.date);
                    $('#end-date').val($('#end-date-btn').data('date'));
                }
                $('#end-date-btn').datepicker('hide');
                $('.datepicker.dropdown-menu').is(':visible').remove();
            });
        console.log($('#search_form').serialize())
    });
</script>
@stop