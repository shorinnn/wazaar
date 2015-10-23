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
</style>
<form method="post" class="csvForm">
    <input type="submit" class="btn btn-primary" value="Download Bank Details CSV" />
</form>
<form method="post" class="csvForm" action="withdrawals/all-cashout-list">
    <input type="submit" class="btn btn-primary" value="All Cashout List" />
</form>
<p class='text-center'>
    <a href="{{action('WithdrawalsController@index')}}">Pending payments</a> | 
    <a href="{{action('WithdrawalsController@notPaid')}}">Approved But Not Paid</a>
</p>

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#instructors" aria-controls="instructors" role="tab" data-toggle="tab">Instructors</a></li>
    <li role="presentation"><a href="#affiliates" aria-controls="affiliates" role="tab" data-toggle="tab">Affiliates</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="instructors">
        {{ View::make('administration.withdrawals.partials.instructors-table')->withRequests( $instructorRequests )->withType('instructor')
                    ->withReady( $instructorsReady )->withNot( $instructorsNotReady ) }}
    </div>
    <div role="tabpanel" class="tab-pane" id="affiliates">
        {{-- View::make('administration.withdrawals.partials.table')->withRequests( $affiliateRequests )->withType('affiliate')
                    ->withReady( $affiliatesReady )->withNot( $affiliatesNotReady ) --}}
    </div>
  </div>

</div>

<form method="post" class="csvForm">
    <input type="submit" class="btn btn-primary" value="Download Bank Details CSV" />
</form>
<form method="post" class="csvForm" action="withdrawals/all-cashout-list">
    <input type="submit" class="btn btn-primary" value="All Cashout List" />
</form>

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