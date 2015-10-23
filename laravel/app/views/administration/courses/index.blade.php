@extends('layouts.default')

@section('content')	
<style>
    .course-container{
        margin-bottom: 10px;
        border: #CCC solid 1px;
        border-radius: 5px;
        padding-top: 10px;
    }
    .action-btn-container{
        padding-bottom: 10px;
    }
    #search_form #search{
        margin-bottom: 0px;
    }
    .course-container h2{
        margin: 0px;
    }
</style>

<div class="col-lg-10 col-lg-offset-1 course-categories">
	<div class="row">
    	<div class="col-md-12">
            <h1 class='icon'>{{trans('administration.courses.label.courses' )}}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3 text-center">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-12 col-sm-4 col-md-4 text-success">
                        <h2>{{$totals['approved']}}</h2>
                        <small>{{ trans('administration.courses.label.approved' )}}</small>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 text-warning">
                        <h2>{{$totals['pending']}}</h2>
                        <small>{{ trans('administration.courses.label.pending' )}}</small>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 text-danger">
                        <h2>{{$totals['rejected']}}</h2>
                        <small>{{ trans('administration.courses.label.disapproved' )}}</small>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">{{ trans('administration.courses.label.courses' )}}</h2>
            <div class="row">
                <form id="search_form" class="form-horizontal" style="padding-bottom:20px;">
                    <input type="hidden" id="page" name="page" value="{{$page}}">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.courses.label.search' )}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="search" name="search" value="{{$search}}">
                                <span id="helpBlock" class="help-block">{{ trans('administration.courses.label.note' )}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-md-offset-3">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Price</label>
                            <div class="col-sm-9">
                                <div class="btn-group buttons-container price-group" data-toggle="buttons">
                                    <label class="btn btn-default segmented-buttons @if(empty(Input::get('price')) || Input::get('price') == 'all' ) active @endif">
                                        <input type="radio" name="price" value="all" class="price" autocomplete="off" 
                                        @if(empty(Input::get('price')) || Input::get('price') == 'all' ) checked='checked' @endif
                                        onchange="selectThisPrice(this);"> {{ trans('administration.courses.label.all' )}}
                                    </label>
                                    <label class="btn btn-default segmented-buttons @if(!empty(Input::get('price')) && Input::get('price') == 'paid' ) active @endif">
                                        <input type="radio" name="price" value="paid" class="price" autocomplete="off" 
                                        @if(!empty(Input::get('price')) && Input::get('price') == 'paid' ) checked='checked' @endif
                                        onchange="selectThisPrice(this);"> {{ trans('administration.courses.label.paid' )}}
                                    </label>
                                    <label class="btn btn-default segmented-buttons @if(!empty(Input::get('price')) && Input::get('price') == 'free' ) active @endif">
                                        <input type="radio" name="price" value="free" class="price" autocomplete="off" 
                                        @if(!empty(Input::get('price')) && Input::get('price') == 'free' ) checked='checked' @endif
                                        onchange="selectThisPrice(this);"> {{ trans('administration.courses.label.free' )}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.courses.label.category' )}}</label>
                            <div class="col-sm-9">
                                {{Form::select('course_category', $course_categories, $course_category, ['id'=>'course_category', 'class'=>'form-control', 'onchange'=>'populateSubCat(this);'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.courses.label.subcategory' )}}</label>
                            <div class="col-sm-9 sub-cat-container">
                                {{Form::select('course_sub_category', $course_sub_categories, $course_sub_category, ['id'=>'course_sub_category', 'class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group hide">
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
                        <div class="form-group text-center">
                            <button type="button" class="search-btn btn btn-primary btn-lg" onclick="searchOrder(true, true);">{{ trans('administration.courses.label.search' )}} <i class="fa fa-search"></i></button>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="btn-group btn-group-justified buttons-container filter-group" data-toggle="buttons">
                                    <label class="btn btn-success segmented-buttons @if(empty(Input::get('filter')) || Input::get('filter') == 'approved' ) active @endif">
                                        <input type="radio" name="filter" value="approved" class="filter" autocomplete="off" 
                                        @if(empty(Input::get('filter')) || Input::get('filter') == 'approved' ) checked='checked' @endif
                                        onchange="selectThisFilter(this);"> {{ trans('administration.courses.label.approved' )}}
                                    </label>
                                    <label class="btn btn-info segmented-buttons @if(!empty(Input::get('filter')) && Input::get('filter') == 'pending' ) active @endif">
                                        <input type="radio" name="filter" value="pending" class="filter" autocomplete="off" 
                                        @if(!empty(Input::get('filter')) && Input::get('filter') == 'pending' ) checked='checked' @endif
                                        onchange="selectThisFilter(this);"> {{ trans('administration.courses.label.pending' )}}
                                    </label>
                                    <label class="btn btn-danger segmented-buttons @if(!empty(Input::get('filter')) && Input::get('filter') == 'rejected' ) active @endif">
                                        <input type="radio" name="filter" value="rejected" class="filter" autocomplete="off" 
                                        @if(!empty(Input::get('filter')) && Input::get('filter') == 'rejected' ) checked='checked' @endif
                                        onchange="selectThisFilter(this);"> {{ trans('administration.courses.label.disapproved' )}}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                {{Form::select('sort_data', $sort_list, $sort_data, ['id'=>'sort_data', 'class'=>'form-control', 'style'=>'margin:0px auto;', 'onchange'=>'searchOrder(false, false)'])}}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <h2 class="courses-listings-total-container text-center"></h2>
                        </div>
                    </div>
                    
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="clearfix"></div>                
            <div class="courses-listings-container ajax-content row"></div>
            <div class="text-center alax-loader hide"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></div>
        </div>
    </div>
    <div id="disapprove-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <img src="" id="modal-img" class="pull-left" style="width:200px;">
                        <span id="modal-title" class="pull-right" style="width: calc(100% - 220px);"></span>
                        <div class="clearfix"></div>
                    </h4>
                </div>
                <div class="modal-body"><img src="{{url('images/ajax-loader.gif')}}" class="img-responsive" style="margin:10px auto;" /></div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
@stop


@section('extra_extra_js')
<script>
    function activateRejectButton()
    {
        $('.reject-btn').on('click', function(e){
            var $modal = $('#disapprove-modal').modal();
            var id = $(this).data('id');
            var img = $('#'+id+' .course-img').attr('src');
            var title = $('#'+id+' .course-title a').text();
            var url = '/administration/manage-courses/get-disapprove-form?course_id='+id;

            $modal.find('#modal-img').attr('src', img);
            $modal.find('#modal-title').text(title);
            $.ajax({
                url: url,
                cache: false,
                success: function(result){
                    $modal.find('.modal-body').html(result);
                }
            });
            $modal.on('hidden.bs.modal', function(){
                $modal.find('#modal-img').attr('src', '');
                $modal.find('#modal-title').text('');
                $modal.find('.modal-body').html('<img src="{{url('images/ajax-loader.gif')}}" class="img-responsive" style="margin:10px auto;" />');
            });
        })
    }
    function populateSubCat(el)
    {
        var url = '/administration/manage-courses/get-subcats?cat_id='+$(el).val();
        $.ajax({
            url: url,
            cache: false,
            success: function(result){
                $('.sub-cat-container').html(result);
            }
        });
    }

    function selectThisPrice(el)
    {
        $('.price-group label').each(function(){
            $(this).removeClass('active');
        });
    }

    function selectThisFilter(el)
    {
        $('.filter-group label').each(function(){
            $(this).removeClass('active');
        });
        $('.search-btn').click();
    }

    function searchOrder(update_total, reset_page)
    {
        if(reset_page){
            $('#page').val('1');
        }
        var url = '/administration/manage-courses?';
        var data = $('#search_form').serialize()

        url = url + data;

        $('.courses-listings-container').html( '<a href="#" data-callback="ajaxifyPagination" data-target=".courses-listings-container" data-url="'+url+'" class="load-remote courses-listings-ajax-link">loading</a>' );

        if(update_total){
            url = url + '&total=true';
            $('.courses-listings-total-container').html( '<a href="#" data-callback="ajaxifyPagination" data-target=".courses-listings-total-container" data-url="'+url+'" class="load-remote courses-listings-total-ajax-link">loading</a>' );
            $('.courses-listings-total-ajax-link').click();
        }        
        $('.courses-listings-ajax-link').click();
    }
    
    function closeModalAndUpdateSearchOrder()
    {
        $('#disapprove-modal').modal('hide');
        updateSearchOrder();
    }

    function updateSearchOrder()
    {
        searchOrder(true, true);
    }

    function loadCourses()
    {
        var url = '/administration/manage-courses?';
        var data = $('#search_form').serialize()

        url = url + data;

        $('.alax-loader').hide().removeClass('hide').show();
        $.ajax({
            url: url,
            cache: false,
            success: function(result){
                $('.alax-loader').hide();
                $('.courses-listings-container').html(result);
                // triggerSorter();
                ajaxifyPagination( null );
                // addSorterIndicator();
            }
        });

        url = url + '&total=true';
        $.ajax({
            url: url,
            cache: false,
            success: function(result){
                $('.courses-listings-total-container').html(result);
            }
        });
    }

    jQuery(document).ready(function($){
        loadCourses();
    });
</script>
@stop