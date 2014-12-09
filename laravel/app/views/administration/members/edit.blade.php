@extends('layouts.default')
@section('content')

@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif

{{ link_to_action("MembersController@index", trans('general.members')) }} | 
{{ link_to_action("MembersController@show", trans('crud/labels.view'), $user->id) }}<br />

<table class="table">
{{ Form::model($user, ['action' => ['MembersController@update', $user->id], 'method' => 'PUT', 'id' =>'edit-form'])}}
<tr><td>{{trans('general.user')}}</td><td>{{ Form::text('email') }}</td></tr>
<tr><td>{{trans('general.first_name')}}</td><td>{{ Form::text('first_name') }}</td></tr>
<tr><td>{{trans('general.last_name')}}</td><td>{{ Form::text('last_name') }}</td></tr>
<tr><td>{{trans('general.groups')}}</td><td>
    @foreach($user->roles as $role)
        <span class="label label-info">{{$role->name}}</span>
    @endforeach
    </td></tr>
<tr><td>{{trans('general.registered')}}</td><td>{{ $user->created_at }} {{ $user->created_at->diffForHumans() }}</td></tr>
<tr><td colspan="2">{{ Form::submit( trans('crud/labels.update'), ['class' => 'btn btn-default'] ) }}</td></tr>
{{ Form::close() }}
</table>
@stop