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
<a href="{{ action('EmailTemplatesController@edit', 'course-approved' )}}">Edit Approved Email</a> |
<a href="{{ action('EmailTemplatesController@edit', 'course-rejected' )}}">Edit Rejected Email</a> 
{{ View::make('administration.submissions.partials.table')->with( compact('submissions') ) }}

@stop