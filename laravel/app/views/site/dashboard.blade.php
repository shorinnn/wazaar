@extends('layouts.default')

@section('page_title')
    Dashboard - 
@stop

@section('content')

<section class="student-teacher-dashboard-wrapper">
	<div class="container">
        <div class='row'>
            <div class='col-md-12'>
            	<div class="student-teacher-dashboard-container">
                <h1>My Courses</h1>
                @if($student->courses()->count() == 0 )
                    <p>You have no courses.</p>
                @else
                    <!--<p>Here are your courses:</p>-->
                    @foreach($student->courses() as $course)
                    <div class="row-1">
                        <div class="course-progress">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active progress-bar-banner" role="progressbar" aria-valuenow="40" aria-valuemin="0" 
                                     aria-valuemax="100" style="width: 40%;">
                                    <span>40%</span>
                                </div>
                            </div>
                            <p class="completed">{{trans('general.completed')}}</p>
                        </div>
                        <div class="dashboard-content">
                        	<header class="clearfix">
                            	<div class="title">
                        			<h3>{{$course->name}}
                                    	<span>{{$course->courseCategory->name}} <em></em> {{$course->courseSubcategory->name}}</span>
                                    </h3>
                            		
                                </div>
                                <div class="data">
                                	<span class="joined">{{trans('general.joined')}}: <em>27-02-2015</em></span>
                                    <span class="current-lesson">{{trans('general.current-lesson')}}: <em>{{trans('general.not-started')}}</em></span>
                                </div>
                            </header>
                            <figure>
                            	
                            </figure>
                            <section class="clearfix">
                            	<div class="icons clearfix">
                                	<a href="#" class="questions"></a>
                                    <span class="comments"><i>259</i></span>
                                    <a href="#" class="edit"></a>
                                </div>
                                <p class="description">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore 
                                et dolore magna aliqua. Ut enim ad
                                </p>
                                <div class="buttons">
    		                        <a href='{{ action("ClassroomController@dashboard", $course->slug )}}' class="go-to-dashboard">{{trans('general.go-to-dashboard')}}</a>
									<a href="#" class="continue-last-lesson">{{trans('general.continue-last-lesson')}}</a>                            
                                </div>
                            </section>
                        </div>
                    </div>
                    @endforeach
                @endif
                </div>
            </div>
            <div class='col-md-6'>
                <h3>My Balance</h3>
                ¥{{ number_format($student->student_balance, Config::get('custom.currency_decimals')) }}
                
                <h3>My Payment Method</h3>
                Card: **** **** **** UWOT M8<br />
                Exp: 20/20<br />
                Name: Nigel DoesThis
            </div>
            <div class='col-md-6'>
                <h3>My Transactions</h3>
                <table class='table table-striped table-condensed'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Transaction Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Details</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>
                                {{ $transaction->id }}
                            </td>
                            <td>
                                @if( strpos($transaction->transaction_type, 'debit') !==false )
                                    @if($transaction->product_type=='Course')
                                        Course: {{ Course::find( $transaction->product_id )->name }}
                                    @else
                                        Lesson: {{ Lesson::find( $transaction->product_id )->name }}
                                    @endif
                                @endif
                            </td>
                            <td>
                                <small>{{ trans('transactions.public_'.$transaction->transaction_type.'_transaction') }}</small>
                            </td>
                            <td>¥{{ number_format($transaction->amount, Config::get('custom.currency_decimals')) }}</td>
                            <td>{{ $transaction->status }}</td>
                            <td>{{ $transaction->details }}</td>
                            <td>{{ $transaction->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </table>
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</section>
@stop