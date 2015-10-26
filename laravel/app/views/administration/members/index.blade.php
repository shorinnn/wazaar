@extends('layouts.default')
@section('page_title') 会員管理 - Wazaar @stop
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

    <div class="row">
        <div class="col-md-12">
            <h1 class='icon admin-page-title'>{{ trans('administration.members.page-title' )}}</h1>
        </div>
    </div>

    {{ View::make('administration.members.partials.table')->with( compact('members') )->with( compact('url_filters') ) }}

@stop