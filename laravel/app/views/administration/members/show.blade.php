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
                    <a href="{{ action('MembersController@edit', $student->id) }}" class="edit-button submit submit-button-2">
                        {{trans('crud/labels.edit')}}
                    </a>            
                    <a href='{{action("PrivateMessagesController@index")}}?send-to={{$student->id}}' target='_blank' type="submit" 
                       class="submit submit-button-2 send-message">{{ trans('administration.send-message')}}</a>   
                </div>         
            </div>
        </div>
    </div>
</div>
<div class="container members-view-wrapper members-area">
	<div class="row">
    	<div class="col-md-12">
        	<div class="profile-photo">
                    @if( $student->profile )
                        <img src='{{ Student::find($student->id)->profile->photo }}' />
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
                    <td class="no-border">{{ $student->email }}</td>
                </tr>
                @if($student->hasRole('Affiliate'))
                <tr>
                    <td class="title no-border">{{trans('general.affiliate_id')}}:</td>
                    <td class="no-border">{{ $student->affiliate_id }}</td>
                </tr>
                <tr>
                    <td class="title no-border">{{trans('general.affiliate_agency')}}:</td>
                    <td class="no-border">
                        @if( $student->affiliate_agency_id > 0 )
                            {{AffiliateAgency::find($student->affiliate_agency_id)->name}}
                        @endif
                    
                    </td>
                </tr>
                @endif
                <tr>
                    <td class="title no-border">{{trans('general.first_name')}}:</td>
                    <td class="no-border">{{ $student->firstName() }}</td>
                </tr>
                <tr>
                    <td class="title no-border">{{trans('general.last_name')}}:</td>
                    <td class="no-border">{{ $student->lastName() }}</td>
                </tr>
                <tr>
                    <td class="title no-border">{{trans('general.groups')}}:</td>
                    <td class="no-border">
                    @foreach($student->roles as $role)
                        <span class="label label-info">{{$role->name}}</span>
                    @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="title no-border">{{trans('general.registered')}}:</td>
                    <td class="no-border">{{ $student->created_at }} {{ $student->created_at->diffForHumans() }}</td>
                </tr>
            </table>
        </div>	
    </div>
</div>
<div class="container members-view-wrapper members-area">
    <div class="row">
    	<div class="col-md-12">
        	<div class="order-history">
            	<h2>{{ trans('administration.order-history') }}</h2>
                <p class="purchased-amount">{{ trans('administration.total-purchased-amount') }}<span>¥ {{ 
                    number_format($student->purchases()->sum('purchase_price'), Config::get('custom.currency_decimals')) 
                     }}</span></p>
                <div class="table-wrapper table-responsive clear">
                    <table class="table table-bordered table-striped orders-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('administration.order-id') }}</th>
                                <th>{{ trans('administration.item') }}</th>
                                <th>{{ trans('administration.item-type') }}</th>
                                <th>{{ trans('administration.purchase-amount') }}</th>
                                <th>{{ trans('administration.date-of-purchase') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                            ?>
                            @foreach($student->purchases as $purchase)
                                <tr>
                                    <td> {{ $i }}</td>
                                    <td>{{ $purchase->id }}</td>
                                    <td>
                                        {{ $purchase->product->name }}
                                    @if( !isset( $purchase->product->module ) )
                                            <a href='{{ action( 'CoursesController@show', $purchase->product->slug ) }}' target='_blank'>
                                    @else
                                            <a href='{{ action( 'CoursesController@show', $purchase->product->module->lesson->course->slug ) }}' 
                                               target='_blank'>
                                    @endif
                                    {{ trans('crud/labels.view') }}
                                                <i class="fa fa-external-link"></i>
                                            </a>
                                    </td>
                                    <td> {{ trans('administration.'.get_class( $purchase->product ) ) }}</td>
                                    <td>¥{{ number_format($purchase->purchase_price, Config::get('custom.currency_decimals')) }}</td>
                                    <td> {{ $purchase->created_at }}</td>
                                </tr>
                                <?php ++$i ;?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if( $student->hasRole('Affiliate') )
    <div class="container members-view-wrapper members-area affiliate-table">
        <div class="row">
            <div class="col-md-12">
                    <div class="affiliate">
                    <h2>{{ trans('administration.affiliate') }}</h2>
                    <table class="table affiliate-table">
                        <tr>
                            <td class="title no-border">{{ trans('administration.affiliate-rank') }}:</td>
                            <td class="no-border"> ? </td>
                        </tr>
                        <tr>
                            <td class="title no-border">{{ trans('administration.total-sales') }}:</td>
                            <td class="no-border">¥ {{ number_format( 
                                        Purchase::where('product_affiliate_id', $student->id)->sum('purchase_price'), 
                                        Config::get('custom.currency_decimals')
                                        ) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="title no-border">{{ trans('administration.total-commissions') }}:</td>
                            <td class="no-border">¥ TBC</td>
                        </tr>
                    </table>
                    <div class="button-wrapper">
                        <div class="submit-button">
                            <a href="#" class="edit-button submit submit-button-2">
                                {{ trans('administration.view-dashboard') }}
                            </a>            
                        </div>         
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if( $student->hasRole('Instructor') )
<?php
    $instructor = Instructor::where( 'id', $student->id )
            ->with('coursesRel')
            ->with('coursesRel.sales')
            ->with('coursesRel.modules')
            ->with('coursesRel.modules.lessons')
            ->with('coursesRel.modules.lessons.sales')
            ->first();
    $i = 1;
?>
    <div class="container members-view-wrapper members-area teacher-stats-table">
        <div class="row">
            <div class="col-md-12">
                    <div class="teacher">
                    <h2>{{ trans('administration.teacher-stats') }}</h2>
                    <table class="table teacher-table">
                        <tr>
                            <td class="title no-border">{{ trans('administration.number-of-courses') }}:</td>
                            <td class="no-border"> {{ $instructor->coursesRel->count() }}</td>
                        </tr>
                        <tr>
                            <td class="title no-border">{{ trans('administration.total-sales') }}:</td>
                            <td class="no-border">¥{{ number_format( $instructor->totalSales(), Config::get('custom.currency_decimals')) }}</td>
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
                                <th>{{ trans('administration.course-name') }}</th>
                                <th>{{ trans('administration.published-date') }}</th>
                                <th>{{ trans('administration.sales-amount') }}</th>
                                <th>{{ trans('administration.overall-sales-rank') }}</th>
                                <th>{{ trans('administration.category-sales-rank') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($instructor->coursesRel as $course)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>
                                        {{ $course->name }}
                                        <a href='{{ action( 'CoursesController@show', $course->slug ) }}' target='_blank'>
                                            {{ trans('crud/labels.view') }}
                                            <i class="fa fa-external-link"></i>
                                        </a>
                                    </td>
                                    <td>{{ $course->created_at }}</td>
                                    <td>¥{{ number_format( $course->sales->sum('purchase_price') + $course->lessonSales(), 
                                                Config::get('custom.currency_decimals')) }}
                                    </td>
                                    <td> ? </td>
                                    <td> ? </td>
                                </tr>
                                <?php ++$i;?>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>  
        </div> 
    </div>
@endif


@stop