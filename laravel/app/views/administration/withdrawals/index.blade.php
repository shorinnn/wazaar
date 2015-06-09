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

{{ View::make('administration.withdrawals.partials.table')->with( compact('requests') ) }}

@stop

@section('extra_js')
<script>
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
</script>
@stop