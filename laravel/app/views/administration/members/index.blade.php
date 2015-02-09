@extends('layouts.default')
@section('content')	
    
@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif
<div class="container members-area">
	<div class="row">
    	<div class="col-md-12 clearfix">
	        <div class="button-wrapper clearfix">
                <div class="submit-button">
                    <button type="submit" class="submit submit-button-2">Students</button>
                    <button type="submit" class="submit submit-button-2">Teachers</button>
                    <button type="submit" class="submit submit-button-2">Affiliates</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
            <div class="member-search-box clearfix clear">
                <form>
                    <input type="search" name="member-search" placeholder="Search for user (username or email)">
                    <button type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
            <div class="table-wrapper table-responsive clear">
                <span class="table-title">
                     <div class="activate-dropdown">
                        <button aria-expanded="false" data-toggle="dropdown" 
                                class="btn btn-default dropdown-toggle" type="button" id="btnGroupDrop1">
                            View
                        </button>
                        <ul id="table-header-dropdown" aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu">
                            <li>
                                <a class="profile-button" href="#">10s</a>
                            </li>
                            <li>
                                <a class="courses-button" href="#">20s</a>
                            </li>
                            <li>
                                <a class="settings-button" href="#">30s</a>
                            </li>
                            <li>
                                <a class="settings-button" href="#">40s</a>
                            </li>
                        </ul>
                    </div>               
                </span>
                <table class="table table-bordered table-striped">
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td class="hidden-xs">
                            {{$member->email}}
                            </td>
                            <td>
                            	First name, Last name
                            </td>
                            <td class="hidden-xs">
                                @foreach($member->roles as $role)
                                    <span class="label label-info">{{$role->name}}</span>
                                @endforeach
                            </td>
                            <td class="view">
                                    <a href="{{ action('MembersController@show', $member->id) }}">
                                    	<i class="fa fa-eye fa-4"></i>
                                    	<span>{{ trans('crud/labels.view') }}</span>
                                    </a>
                                <!--<span class="icon-container visible-xs">
                                	{{link_to_action('MembersController@show', trans('crud/labels.view'), $member->id)}}
                                    <img class="img-responsive" src="" alt="">
                                </span>-->
                            </td>
                            <td class="edit">
                            	<a href="action('MembersController@edit', $member->id)">
                                	<i class="fa fa-pencil-square-o fa-4"></i>
                                	<span>{{trans('crud/labels.edit')}}</span>
                                </a>
                            </td>
                            <td class="delete">
                                {{ Form::open(array('action' => array('MembersController@destroy', $member->id), 'method' => 'delete', 'id'=>'member-form-'.$member->id)) }}
                                <button class="btn btn-danger delete-button" data-message="Are you sure you want to delete? (msg coming from btn)"
                                type="submit">
                                	<i class="fa fa-trash fa-4"></i>
                                	<span>{{trans('crud/labels.delete')}}</span>
                                </button>
                                {{ Form::close() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
    		{{$members->links()}}
    	</div>
	</div>
</div>
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