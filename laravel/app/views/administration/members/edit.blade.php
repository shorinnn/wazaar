@extends('layouts.default')
@section('content')

@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif
<style>
    #save-indicator{
        border:1px solid black;
        background-color:white;
        width:90px;
        height:30px;
        position:fixed;
        top:100px;
        left:-100px;
        text-align: right;
        padding-right: 10px;
    }
</style>
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
                {{ Form::model($user, ['action' => ['MembersController@update', $user->id], 'method' => 'PUT', 'data-callback' => 'formSaved',
                            'id' =>'edit-form', 'class' => 'ajax-form'])}}
                <table class="table personal-info">
                    <tr>
                        <td class="title no-border">{{trans('general.email')}}</td>
                        <td class="no-border">{{ Form::text('email') }}</td>
                    </tr>
                    @if($user->hasRole('Affiliate'))
                    <tr>
                        <td class="title no-border">{{trans('general.affiliate_id')}}</td>
                        <td class="no-border">{{ Form::text('affiliate_id') }}</td>
                    </tr>
                    <tr>
                        <td class="title no-border">{{trans('general.life-time-commission')}}:</td>
                        <td class="no-border">{{ Form::select('has_ltc',[
                            'no' => trans('courses/curriculum.no'),
                            'yes' => trans('courses/curriculum.yes')
                        ]) }}</td>
                    </tr>
                    @endif
                    @if($user->hasRole('Instructor'))
                     <tr>
                        <td class="title no-border">{{trans('general.instructor_agency')}}</td>
                        <td class="no-border">
                            <div>
                                {{ Form::select('instructor_agency_id', $instructor_agencies ) }}
                            </div>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td class="title no-border">{{trans('general.first_name')}}</td>
                        <td class="no-border">{{ $user->firstName() }}</td>
                    </tr>
                    <tr>
                        <td class="title no-border">{{trans('general.last_name')}}</td>
                        <td class="no-border">{{ $user->lastName() }}</td>
                    </tr>
                    <tr>
                        <td class="title no-border">{{trans('general.groups')}}</td>
                        <td class="no-border">
                    @foreach($user->roles as $role)
                        <span class="label label-info">{{$role->name}}</span>
                    @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="title no-border">{{trans('administration.status')}}</td>
                        <td class="no-border">
                            <div>
                                {{ Form::select('status',['Active'=>'Active', 'Suspended'=>'Suspended'] ) }}
                            </div>
                        </td>
                    </tr>
                    <tr class="no-border">
                        <td class="title no-border">{{trans('general.registered')}}</td>
                        <td class="no-border">{{ $user->created_at }} {{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            {{ Form::submit( trans('crud/labels.update'), ['class' => 'btn btn-default submit submit-button-2'] ) }}
                        </td>
                    </tr>
                </table>
                {{ Form::close() }}
            </div>
		</div>
    </div>
</div>
@stop