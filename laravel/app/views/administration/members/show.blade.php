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
                    <a href="{{ action('MembersController@edit', $user->id) }}" class="edit-button submit submit-button-2">
                        {{trans('crud/labels.edit')}}
                    </a>            
                    <button type="submit" class="submit submit-button-2 send-message">Send Message</button>   
                </div>         
            </div>
        </div>
    </div>
</div>
<div class="container members-view-wrapper members-area">
	<div class="row">
    	<div class="col-md-12">
        	<div class="profile-photo">
                    @if( Student::find($user->id)->profile)
                        <img src='{{ Student::find($user->id)->profile->photo }}' />
                    @endif
            </div>
        </div>
    </div>
</div>
<div class="container members-view-wrapper members-area personal-info-table">
	<div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-12">
            <table class="table personal-info">

                <tr>
                    <td class="title no-border">{{trans('general.user')}}:</td>
                    <td class="no-border">{{ $user->email }}</td>
                </tr>
                @if($user->hasRole('Affiliate'))
                <tr>
                    <td class="title no-border">{{trans('general.affiliate_id')}}:</td>
                    <td class="no-border">{{ $user->affiliate_id }}</td>
                </tr>
                <tr>
                    <td class="title no-border">{{trans('general.affiliate_agency')}}:</td>
                    <td class="no-border">
                        @if( $user->affiliate_agency_id > 0 )
                            {{AffiliateAgency::find($user->affiliate_agency_id)->name}}
                        @endif
                    
                    </td>
                </tr>
                @endif
                <tr>
                    <td class="title no-border">{{trans('general.first_name')}}:</td>
                    <td class="no-border">{{ $user->first_name }}</td>
                </tr>
                <tr>
                    <td class="title no-border">{{trans('general.last_name')}}:</td>
                    <td class="no-border">{{ $user->last_name }}</td>
                </tr>
                <tr>
                    <td class="title no-border">{{trans('general.groups')}}:</td>
                    <td class="no-border">
                    @foreach($user->roles as $role)
                        <span class="label label-info">{{$role->name}}</span>
                    @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="title no-border">{{trans('general.registered')}}:</td>
                    <td class="no-border">{{ $user->created_at }} {{ $user->created_at->diffForHumans() }}</td>
                </tr>
                <tr>
                    <td class="title no-border">Last Logged in:</td>
                    <td class="no-border">2015-02-14 06:20:16 2 days ago</td>
                </tr>
            </table>
        </div>	
    </div>
</div>
<div class="container members-view-wrapper members-area">
    <div class="row">
    	<div class="col-md-12">
        	<div class="order-history">
            	<h2>Order History</h2>
                <p class="purchased-amount">Total Purchased Amout<span>¥185,001</span></p>
                <div class="table-wrapper table-responsive clear">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Course</th>
                                <th>Purchase Amount</th>
                                <th>Date of Purchase</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>1234MDB</td>
                                <td>PHP Primer</td>
                                <td>¥185,001</td>
                                <td>12/02/2015</td>
                                <td class="active">Active</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>1234MDB</td>
                                <td>PHP Primer</td>
                                <td>¥185,001</td>
                                <td>12/02/2015</td>
                                <td class="processing">Processing</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>1234MDB</td>
                                <td>PHP Primer</td>
                                <td>¥185,001</td>
                                <td>12/02/2015</td>
                                <td class="refunded">Refunded</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>1234MDB</td>
                                <td>PHP Primer</td>
                                <td>¥185,001</td>
                                <td>12/02/2015</td>
                                <td class="failed">Failed</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>1234MDB</td>
                                <td>PHP Primer</td>
                                <td>¥185,001</td>
                                <td>12/02/2015</td>
                                <td class="failed">Failed</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>1234MDB</td>
                                <td>PHP Primer</td>
                                <td>¥185,001</td>
                                <td>12/02/2015</td>
                                <td class="failed">Failed</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>1234MDB</td>
                                <td>PHP Primer</td>
                                <td>¥185,001</td>
                                <td>12/02/2015</td>
                                <td class="failed">Failed</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>1234MDB</td>
                                <td>PHP Primer</td>
                                <td>¥185,001</td>
                                <td>12/02/2015</td>
                                <td class="failed">Failed</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>1234MDB</td>
                                <td>PHP Primer</td>
                                <td>¥185,001</td>
                                <td>12/02/2015</td>
                                <td class="failed">Failed</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>1234MDB</td>
                                <td>PHP Primer</td>
                                <td>¥185,001</td>
                                <td>12/02/2015</td>
                                <td class="failed">Failed</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination-container clearfix">
            	<div class="page-numbers-container clearfix">
                    <ul class="clearfix">
                        <li>
                            <a href="#"></a>
                        </li>
                        <li>
                            <a href="#" class="active">1</a>
                        </li>
                        <li>
                            <a href="#">2</a>
                        </li>
                        <li>
                            <a href="#">3</a>
                        </li>
                        <li>
                            <a href="#">4</a>
                        </li>
                        <li>
                            <a href="#">5</a>
                        </li>
                        <li>
                            <a href="#"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@if( $user->hasRole('affiliate') )
    <div class="container members-view-wrapper members-area affiliate-table">
        <div class="row">
            <div class="col-md-12">
                    <div class="affiliate">
                    <h2>Affiliate</h2>
                    <table class="table affiliate-table">
                        <tr>
                            <td class="title no-border">Affiliate Rank:</td>
                            <td class="no-border">1221</td>
                        </tr>
                        <tr>
                            <td class="title no-border">Total Sales:</td>
                            <td class="no-border">¥2,185,123</td>
                        </tr>
                        <tr>
                            <td class="title no-border">Total Commissions:</td>
                            <td class="no-border">¥185,001</td>
                        </tr>
                    </table>
                    <div class="button-wrapper">
                        <div class="submit-button">
                            <a href="#" class="edit-button submit submit-button-2">
                                View Dashboard
                            </a>            
                        </div>         
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if( $user->hasRole('instructor') )
    <div class="container members-view-wrapper members-area teacher-stats-table">
        <div class="row">
            <div class="col-md-12">
                    <div class="teacher">
                    <h2>Teacher Stats</h2>
                    <table class="table teacher-table">
                        <tr>
                            <td class="title no-border">Number of Courses:</td>
                            <td class="no-border">5</td>
                        </tr>
                        <tr>
                            <td class="title no-border">Total Sales:</td>
                            <td class="no-border">¥2,185,123</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container members-view-wrapper members-area">
        <div class="row">
            <div class="col-md-12">
                <div class="table-wrapper table-responsive clear">               
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course Name</th>
                                <th>Published Date</th>
                                <th>Sales Amount</th>
                                <th>Overall Sales Rank</th>
                                <th>Category Sales Rank</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>PHP Primer</td>
                                <td>12/02/2015</td>
                                <td>¥185,001</td>
                                <td>4</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>PHP Primer</td>
                                <td>12/02/2015</td>
                                <td>¥185,001</td>
                                <td>4</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>PHP Primer</td>
                                <td>12/02/2015</td>
                                <td>¥185,001</td>
                                <td>4</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>PHP Primer</td>
                                <td>12/02/2015</td>
                                <td>¥185,001</td>
                                <td>4</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>PHP Primer</td>
                                <td>12/02/2015</td>
                                <td>¥185,001</td>
                                <td>4</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>PHP Primer</td>
                                <td>12/02/2015</td>
                                <td>¥185,001</td>
                                <td>4</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>PHP Primer</td>
                                <td>12/02/2015</td>
                                <td>¥185,001</td>
                                <td>4</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>PHP Primer</td>
                                <td>12/02/2015</td>
                                <td>¥185,001</td>
                                <td>4</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>PHP Primer</td>
                                <td>12/02/2015</td>
                                <td>¥185,001</td>
                                <td>4</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>PHP Primer</td>
                                <td>12/02/2015</td>
                                <td>¥185,001</td>
                                <td>4</td>
                                <td>2</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>  
        </div> 
        <div class="row">
            <div class="col-md-12">     
                <div class="pagination-container clearfix">
                    <div class="page-numbers-container clearfix">
                        <ul class="clearfix">
                            <li>
                                <a href="#"></a>
                            </li>
                            <li>
                                <a href="#" class="active">1</a>
                            </li>
                            <li>
                                <a href="#">2</a>
                            </li>
                            <li>
                                <a href="#">3</a>
                            </li>
                            <li>
                                <a href="#">4</a>
                            </li>
                            <li>
                                <a href="#">5</a>
                            </li>
                            <li>
                                <a href="#"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


@stop