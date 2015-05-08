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
<form method="post" action="{{ action('WithdrawalsController@downloadBankFile' ) }}" target="_blank"  onsubmit="reenable()" >
    <select name="time">
       <?php
        $stop = Config::get('custom.cashout.start_date') ;
        $now = time();
        while( strtotime($stop) < $now){
            $label = date('m-Y', $now);
            $now = date('Y-m-d', $now);
            echo "<option value='$now'>$label</option>";
            $now =  strtotime( $now.' - 1 month');
        }
       ?>
    </select>
    <input id='submitBtn' type="submit" value=" {{ trans('courses/student_dash.download' ) }}" />
</form>


@stop

@section('extra_js')
<script>
    function reenable(){
        setTimeout(function(){
            $('#submitBtn').removeAttr('disabled');
            console.log(  $('#submitBtn') );
            console.log('enabled!');
        },200);
    }
</script>
@stop