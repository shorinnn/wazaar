@extends('layouts.default')
@section('content')	

@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif

{{ link_to_action("MembersController@index", trans('general.members')) }} | 
{{ link_to_action("MembersController@edit", trans('crud/labels.edit'), $user->id) }}<br />

<table class="table">
<tr><td>{{trans('general.user')}}</td><td>{{ $user->email }}</td></tr>
<tr><td>{{trans('general.first_name')}}</td><td>{{ $user->first_name }}</td></tr>
<tr><td>{{trans('general.last_name')}}</td><td>{{ $user->last_name }}</td></tr>
<tr><td>{{trans('general.registered')}}</td><td>{{ $user->created_at }} {{ $user->created_at->diffForHumans() }}</td></tr>
</table>

@stop