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
</style>
<h1>Edit Email Template</h1>
Tag: {{$template->tag}}
{{ Form::model($template, ['action' => [ 'EmailTemplatesController@update', $template->tag ], 'method' => 'PUT' ] ) }}
{{ Form::textarea('content',null, [ 'id'=>'content' ] ) }}

<button type="submit" class="blue-button extra-large-button">Update</button>
{{ Form::close() }}

@stop

@section('extra_js')
<script>
    $(function(){
        enableRTE('#content');
    });
</script>
@stop