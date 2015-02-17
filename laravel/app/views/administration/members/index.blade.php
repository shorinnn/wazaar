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

{{ View::make('administration.members.partials.table')->with( compact('members') )->with( compact('url_filters') ) }}

<!--<table class="table">
@foreach($members as $member)
<tr>
    <td>
    {{$member->email}}
    </td>
    <td>
        @foreach($member->roles as $role)
            <span class="label label-info">{{$role->name}}</span>
        @endforeach
    </td>
    <td>{{link_to_action('MembersController@show', trans('crud/labels.view'), $member->id)}}</td>
    <td>{{link_to_action('MembersController@edit', trans('crud/labels.edit'), $member->id)}} </td>
    <td>
        {{ Form::open(array('action' => array('MembersController@destroy', $member->id), 'method' => 'delete', 'id'=>'member-form-'.$member->id)) }}
        <button class="btn btn-danger delete-button" data-message="Are you sure you want to delete? (msg coming from btn)" type="submit" >{{trans('crud/labels.delete')}}</button>
        {{ Form::close() }}
    </td>
    <br />
@endforeach
</table>
{{$members->links()}}
-->
@stop