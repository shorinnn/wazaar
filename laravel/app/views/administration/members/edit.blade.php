@extends('layouts.default')
@section('content')

@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif

<div class="container-fluid members-view-wrapper members-area">
	<div class="row">
    	<div class="col-md-12">
        	<div class="breadcrumb button-wrapper clearfix">
                <a href="{{ action('MembersController@index') }}" class="back-to-members">
                    {{trans('general.members')}}
                </a>                
            </div>
            <div class="button-wrapper">
            	<div class="submit-button">
                    <a href="{{ action('MembersController@show', $user->id) }}" class="edit-button submit submit-button-2">
                        {{trans('crud/labels.view')}}
                    </a>            
                </div>         
            </div>
        </div>
    </div>
</div>
<div class="container members-edit-wrapper members-area">
	<div class="row">
    	<div class="col-md-12">
            <div class="table-responsive">
                <table class="table personal-info">
                {{ Form::model($user, ['action' => ['MembersController@update', $user->id], 'method' => 'PUT', 'id' =>'edit-form'])}}
                    <tr>
                        <td class="title no-border">{{trans('general.user')}}</td>
                        <td class="no-border">{{ Form::text('email') }}</td>
                    </tr>
                    @if($user->hasRole('Affiliate'))
                    <tr>
                        <td class="title no-border">{{trans('general.affiliate_id')}}</td>
                        <td class="no-border">{{ Form::text('affiliate_id') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="title no-border">{{trans('general.first_name')}}</td>
                        <td class="no-border">{{ Form::text('first_name') }}</td>
                    </tr>
                    <tr>
                        <td class="title no-border">{{trans('general.last_name')}}</td>
                        <td class="no-border">{{ Form::text('last_name') }}</td>
                    </tr>
                    <tr>
                        <td class="title no-border">{{trans('general.groups')}}</td>
                        <td class="no-border">
                    @foreach($user->roles as $role)
                        <span class="label label-info">{{$role->name}}</span>
                    @endforeach
                        </td>
                    </tr>
                    <tr class="no-border">
                        <td class="title no-border">{{trans('general.registered')}}</td>
                        <td class="no-border">{{ $user->created_at }} {{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">{{ Form::submit( trans('crud/labels.update'), ['class' => 'btn btn-default submit submit-button-2'] ) }}</td>
                    </tr>
                {{ Form::close() }}
                </table>
            </div>
		</div>
    </div>
</div>
@stop