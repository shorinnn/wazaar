@extends('layouts.default')

@section('content')	
<style>
    .course-container{
        margin-bottom: 10px;
        border: #EEEEEE solid 1px;
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
            <h1 class='icon'>Courses</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3 text-center">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-12 col-sm-4 col-md-4 text-success">
                        <h2>{{$totals['approved']}}</h2>
                        <small>Approved</small>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 text-warning">
                        <h2>{{$totals['pending']}}</h2>
                        <small>Pending</small>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 text-danger">
                        <h2>{{$totals['rejected']}}</h2>
                        <small>Disapproved</small>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">{{ trans('administration.orders.search-course' )}}</h2>
            <div class="row">
                <form id="search_form" class="form-horizontal" style="padding-bottom:20px;">
                    <input type="hidden" name="sort_by" id="sort_by" value="{{-- $sort_by --}}">
                    <input type="hidden" name="sort" id="sort" value="{{-- $sort --}}">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.orders.label.name' )}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="search" name="search" value="{{-- $search --}}">
                                <span id="helpBlock" class="help-block">Enter Course Name, Instructor Email, Course Slug</span>
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
                                        onchange="selectThisPrice(this);"> {{ trans('courses/general.filter.all') }}
                                    </label>
                                    <label class="btn btn-default segmented-buttons @if(!empty(Input::get('price')) && Input::get('price') == 'paid' ) active @endif">
                                        <input type="radio" name="price" value="paid" class="price" autocomplete="off" 
                                        @if(!empty(Input::get('price')) && Input::get('price') == 'paid' ) checked='checked' @endif
                                        onchange="selectThisPrice(this);"> {{ trans('courses/general.filter.paid') }}
                                    </label>
                                    <label class="btn btn-default segmented-buttons @if(!empty(Input::get('price')) && Input::get('price') == 'free' ) active @endif">
                                        <input type="radio" name="price" value="free" class="price" autocomplete="off" 
                                        @if(!empty(Input::get('price')) && Input::get('price') == 'free' ) checked='checked' @endif
                                        onchange="selectThisPrice(this);"> {{ trans('courses/general.filter.free') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.orders.label.category' )}}</label>
                            <div class="col-sm-9">
                                {{Form::select('course_category', $course_categories, $course_category, ['id'=>'course_category', 'class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Subcategory</label>
                            <div class="col-sm-9">
                                {{Form::select('course_sub_category', $course_sub_categories, $course_sub_category, ['id'=>'course_sub_category', 'class'=>'form-control'])}}
                            </div>
                        </div>
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
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="btn-group btn-group-justified buttons-container filter-group" data-toggle="buttons">
                                    <label class="btn btn-success segmented-buttons @if(empty(Input::get('filter')) || Input::get('filter') == 'approved' ) active @endif">
                                        <input type="radio" name="filter" value="approved" class="filter" autocomplete="off" 
                                        @if(empty(Input::get('filter')) || Input::get('filter') == 'approved' ) checked='checked' @endif
                                        onchange="selectThisFilter(this);"> Approved
                                    </label>
                                    <label class="btn btn-info segmented-buttons @if(!empty(Input::get('filter')) && Input::get('filter') == 'pending' ) active @endif">
                                        <input type="radio" name="filter" value="pending" class="filter" autocomplete="off" 
                                        @if(!empty(Input::get('filter')) && Input::get('filter') == 'pending' ) checked='checked' @endif
                                        onchange="selectThisFilter(this);"> Pending
                                    </label>
                                    <label class="btn btn-danger segmented-buttons @if(!empty(Input::get('filter')) && Input::get('filter') == 'rejected' ) active @endif">
                                        <input type="radio" name="filter" value="rejected" class="filter" autocomplete="off" 
                                        @if(!empty(Input::get('filter')) && Input::get('filter') == 'rejected' ) checked='checked' @endif
                                        onchange="selectThisFilter(this);"> Disapproved
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                {{Form::select('sort_data', $sort_list, $sort_data, ['id'=>'sort_data', 'class'=>'form-control', 'style'=>'margin:0px auto;'])}}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 text-center">
                        <button type="button" class="search-btn btn btn-primary btn-lg" onclick="searchOrder();">{{ trans('administration.orders.search' )}} <i class="fa fa-search"></i></button>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="clearfix"></div>                
            <div class="courses-totals-container row"></div>
            <div class="courses-listings-container ajax-content row"></div>
            <div class="text-center alax-loader hide"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></div>
        </div>
    </div>

</div>
@stop


@section('extra_extra_js')
<script>
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
    function searchOrder()
    {
        var url = '/administration/manage-courses?';
        var data = $('#search_form').serialize()

        url = url + data;

        $('.courses-listings-container').html( '<a href="#" data-callback="ajaxifyPagination" data-target=".courses-listings-container" data-url="'+url+'" class="load-remote courses-listings-ajax-link">loading</a>' );

        $('.courses-listings-ajax-link').click();
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
    }

    jQuery(document).ready(function($){
        loadCourses();
    });
</script>
@stop