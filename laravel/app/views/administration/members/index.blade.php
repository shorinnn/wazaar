@extends('layouts.default')
@section('content')	
    
@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif

<table class="table">
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
        <button class="btn btn-danger delete-button" type="submit" >{{trans('crud/labels.delete')}}</button>
        {{ Form::close() }}
    </td>
    <br />
@endforeach
</table>
{{$members->links()}}

@stop