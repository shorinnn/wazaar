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
            <h1 class='icon'>{{ trans('administration.users.manage-users' )}}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">{{ trans('administration.users.search-user' )}}</h2>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form id="search_form" class="form-horizontal" style="padding-bottom:20px;">
                        <input type="hidden" name="sort_by" id="sort_by" value="{{$sort_by}}">
                        <input type="hidden" name="sort" id="sort" value="{{$sort}}">
                        <input type="hidden" name="start" id="start" value="{{$start}}">
                        <input type="hidden" name="limit" id="limit" value="{{$limit}}">
                        <input type="hidden" name="page" id="page" value="{{$page}}">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.users.label.name' )}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" value="{{$name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.users.label.email' )}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="email" name="email" value="{{$email}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.users.label.join-date' )}}</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="alert alert-danger hide date-warning"></div>
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <input type="text" id="start-date" class="form-control text-center" readonly="readonly" name="join_date_low" value="{{$join_date_low}}">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" id="start-date-btn" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <span class="pull-left">-</span>
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <input type="text" id="end-date" class="form-control text-center" readonly="readonly" name="join_date_high" value="{{$join_date_high}}">
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
                            <label class="col-sm-3 control-label">{{ trans('administration.users.label.total-purchased' )}}</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <div class="input-group-addon">¥</div>
                                            <input type="text" class="form-control text-center" name="total_purchased_low" value="{{$total_purchased_low}}">
                                        </div>
                                    </div>
                                    <span class="pull-left">-</span>
                                    <div class="col-xs-5 col-sm-5">
                                        <div class="input-group">
                                            <div class="input-group-addon">¥</div>
                                            <input type="text" class="form-control text-center" name="total_purchased_high" value="{{$total_purchased_high}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.users.label.status' )}}</label>
                            <div class="col-sm-9">
                                <div class="btn-group buttons-container" data-toggle="buttons">
                                  <label class="btn btn-default segmented-buttons @if(empty($status)) || $status) == 'all' ) active @endif">
                                    <input type="radio" name="status" value="all" class="filter" autocomplete="off" onchange="loadFilteredCourseCategory();"> {{ trans('administration.users.status.all' )}}
                                  </label>
                                  <label class="btn btn-default segmented-buttons @if(!empty($status)) && $status) == 'live' ) active @endif">
                                    <input type="radio" name="status" value="live" class="filter" autocomplete="off" onchange="loadFilteredCourseCategory();"> {{ trans('administration.users.status.live' )}}
                                  </label>
                                  <label class="btn btn-default segmented-buttons @if(!empty($status)) && $status) == 'suspended' ) active @endif">
                                    <input type="radio" name="status" value="suspended" class="filter" autocomplete="off" onchange="loadFilteredCourseCategory();"> {{ trans('administration.users.status.suspended' )}}
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.users.label.email-verified' )}}</label>
                            <div class="col-sm-9">
                                <div class="btn-group buttons-container" data-toggle="buttons">
                                  <label class="btn btn-default segmented-buttons @if(empty($email_verified) || $email_verified == 'all' ) active @endif">
                                    <input type="radio" name="email_verified" value="all" class="filter" autocomplete="off" onchange="loadFilteredCourseCategory();"> {{ trans('administration.users.email-verified.all' )}}
                                  </label>
                                  <label class="btn btn-default segmented-buttons @if(!empty($email_verified) && $email_verified == 'yes' ) active @endif">
                                    <input type="radio" name="email_verified" value="paid" class="filter" autocomplete="off" onchange="loadFilteredCourseCategory();"> {{ trans('administration.users.email-verified.yes' )}}
                                  </label>
                                  <label class="btn btn-default segmented-buttons @if(!empty($email_verified) && $email_verified == 'no' ) active @endif">
                                    <input type="radio" name="email_verified" value="free" class="filter" autocomplete="off" onchange="loadFilteredCourseCategory();"> {{ trans('administration.users.email-verified.no' )}}
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('administration.users.label.roles' )}}</label>
                            <div class="col-sm-9">
                                <div class="form-group col-sm-12">
                                    {{Form::select('role', $roles, $role, ['id'=>'role', 'class'=>'form-control'])}}
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="btn-group buttons-container" data-toggle="buttons">
                                      <label class="btn btn-default segmented-buttons @if(!empty($user_filter) || $user_filter == 'only' ) active @endif">
                                        <input type="radio" name="user_filter" value="only" class="filter" autocomplete="off" onchange="loadFilteredCourseCategory();"> {{ trans('administration.users.roles.only' )}}
                                      </label>
                                      <label class="btn btn-default segmented-buttons @if(empty($user_filter) && $user_filter == 'or' ) active @endif">
                                        <input type="radio" name="user_filter" value="or" class="filter" autocomplete="off" onchange="loadFilteredCourseCategory();"> {{ trans('administration.users.roles.or' )}}
                                      </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 text-center">
                            <button type="button" class="btn btn-primary btn-lg" onclick="searchOrder();">{{ trans('administration.users.search' )}} <i class="fa fa-search"></i></button>
                        </div>
                        <button type="button" class="pull-right btn btn-sm btn-info clearfix" onclick="downloadCsv();"><i class="fa fa-download"></i> {{ trans('administration.users.download-csv' )}}</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>                
            <div class="orders-totals-container row"></div>
            <div class="users-listings-container ajax-content row"></div>
            <div class="text-center alax-loader hide"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></div>
        </div>
    </div>
</div>

@stop

@section('extra_extra_js')
<script>
    // function downloadCsv()
    // {
    //     var url = '/administration/manage-users?';
    //     var data = $('#search_form').serialize();
    //     url = url + data + '&download=true';
    //     // console.log(url)
    //     window.location.href = url;
    // }
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
        var url = '/administration/manage-users?';
        var data = $('#search_form').serialize()

        url = url + data;

        $('.users-listings-container').html( '<a href="#" data-callback="ajaxifyPagination" data-target=".users-listings-container" data-url="'+url+'" class="load-remote users-listings-ajax-link">loading</a>' );
        $('.users-listings-ajax-link').click();
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

            var url = '/administration/manage-users?';
            var data = $('#search_form').serialize()
            url = url + data;

            $('.ajax-content').html( '<a href="#" data-callback="ajaxifyPagination" data-target=".ajax-content" data-url="'+url+'" class="load-remote course-desc-ajax-link">loading</a>' );
            $('.course-desc-ajax-link').click();
        })
    }
    function loadUsers()
    {
        var url = '/administration/manage-users?';
        var data = $('#search_form').serialize()

        url = url + data;

        $('.alax-loader').hide().removeClass('hide').show();
        $.ajax({
            url: url,
            cache: false,
            success: function(result){
                $('.alax-loader').hide();
                $('.users-listings-container').html(result);
                // triggerSorter();
                ajaxifyPagination( null );
                addSorterIndicator();
            }
        });
    }
    jQuery(document).ready(function($){
        loadUsers();

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