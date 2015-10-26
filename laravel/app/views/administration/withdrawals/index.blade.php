@extends('layouts.default')
@section('content')	
    
@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif
<style>
     .overlay-loading{
        position:absolute;
        margin-left:auto;
        margin-right:auto;
        left:0;
        right:0;
        z-index: 10;
        width:32px;
        height:32px;
        background-image:url('http://www.mytreedb.com/uploads/mytreedb/loader/ajax_loader_blue_32.gif');
    }
    .errored{
        border:1px solid red;
    }
    .checkbox-buttons{
        float: none;
        margin: 0;
    }
    .checkbox-buttons .checkbox-item{
        padding-left: 0;
        padding-bottom: 0;
    }
    .checkbox-buttons input[type="checkbox"] + label.small-checkbox{
        background-color: #fff;
        margin: 0;
        border-radius: 3px;
        vertical-align: middle;
    }
    .checkbox-checkbox{
        float: none !important;
    }
    .label-wrap{
        margin-bottom: 20px;
    }
    .lesson-status{
        margin-top: 8px;
    }
    .members-area{
        margin: 20px auto 0;
    }
    .table-wrapper{
        margin-bottom: 30px;
    }
    .table-wrapper input{
        margin-bottom: 0;
        background-color: #fff;
    }
    .settings-row{
        margin-top: 40px;
    }
    .settings-row a:hover{
        color: #0099ff;
    }
    .settings{
    }
    .table-wrapper{
        border: solid #0d9eff;
        border-width: 1px 0 1px 1px;
    }
    .transaction-date input{
        width: 95px;
    }
</style>
<div class="container-fluid">
    <div class="container">
        <h1 class="text-center margin-top-40">Manage Payments</h1>
        <p class='text-center settings-row'>
            <a href="{{action('WithdrawalsController@index')}}">Pending payments</a> |
            <a href="{{action('WithdrawalsController@notPaid')}}">Approved But Not Paid</a>
        </p>
        <h2 class="text-center transaction-date">
            Calculating transactions up to <input type="text" readonly value="{{ $cutoff }}">
        </h2>
        <div>

          <!-- Nav tabs -->
          <ul class="tabbed-content-header clearfix" role="tablist">
            <li role="presentation" class="active">
                <a href="#instructors" aria-controls="instructors" role="tab" data-toggle="tab" class="tab-header-button">Instructors</a>
            </li>
            <li role="presentation">
                <a href="#affiliates" aria-controls="affiliates" role="tab" data-toggle="tab" class="tab-header-button">Affiliates</a>
            </li>

          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="instructors">
                {{ View::make('administration.withdrawals.partials.instructors-table')->withRequests( $instructorRequests )->withType('instructor')
                            ->withReady( $instructorsReady )->withNot( $instructorsNotReady ) }}
            </div>
            <div role="tabpanel" class="tab-pane" id="affiliates">
                {{ View::make('administration.withdrawals.partials.affiliates-table')->withRequests( $affiliateRequests )->withType('affiliate')
                            ->withReady( $affiliatesReady )->withNot( $affiliatesNotReady ) }}
            </div>
          </div>

        </div>
    </div>
</div>
@stop

@section('extra_js')
<script>
    $(function(){
        calculateReadiness();
    });
    
    function calculateReadiness(){
//        total = $('.ajax-content-instructor .transaction-row').length;
//        noFill = $('.ajax-content-instructor .no-fill').length;
//        $('#instructor-not-ready-for-payment').html(noFill);
//        $('#instructor-ready-for-payment').html( total*1 - noFill*1 );
//        
//        total = $('.ajax-content-affiliate .transaction-row').length;
//        noFill = $('.ajax-content-affiliate .no-fill').length;
//        $('#affiliate-not-ready-for-payment').html(noFill);
//        $('#affiliate-ready-for-payment').html( total*1 - noFill*1 );
    }
    
    function processWithdrawal(target){
        $('.errored').removeClass('errored');
        mode = $(target).attr('data-mode');
        conf = confirm( $(target).attr('data-message') );
        if( !conf ) return false;
        $('#action').val( mode );
        stop = false;
        
        if(mode=='complete'){
            
            $('.cb-togglable:checked').each(function(){
                console.log( $(this).val() ); 
                if( $('[name="reference['+ $(this).val()+']"]').val() == ''){
                    stop = true;
                    $('[name="reference['+ $(this).val()+']"]').addClass('errored');
                }
            });
        }
        
        if( stop ){
            alert( _('Please fill in the reference fields') );
            return false;
        }
        
        $('#withdrawForm').submit();
    }
    
    function toggle(elem){
        $(elem).slideToggle();
    }
    
    $('body').delegate('.csvForm', 'submit', function(){
        setTimeout(function(){
           $('input').removeAttr('disabled');
           console.log('re-enabled');
        }, 1000);
    });
</script>
@stop