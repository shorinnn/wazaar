@extends('layouts.default')

@section('page_title')
    Dashboard - 
@stop

@section('content')

<div class='row'>
    <div class='col-lg-12' style='border:1px solid silver'>
        <h3>My Courses</h3>
        @if($student->courses()->count() == 0 )
            <p>You have no courses.</p>
        @else
            <p>Here are your courses:</p>
            @foreach($student->courses() as $course)
            <p>
                <span class="label label-info">{{$course->courseCategory->name}} >
                {{$course->courseSubcategory->name}}</span>
                {{$course->name}} - <a href='{{ action("ClassroomController@dashboard", $course->slug )}}'>Go To Dashboard</a></p>
            @endforeach
        @endif
    </div>
    <div class='col-lg-6' style='border:1px solid silver'>
        <h3>My Balance</h3>
        ¥{{ number_format($student->student_balance, Config::get('custom.currency_decimals')) }}
        
        <h3>My Payment Method</h3>
        Card: **** **** **** UWOT M8<br />
        Exp: 20/20<br />
        Name: Nigel DoesThis
    </div>
    <div class='col-lg-6' style='border:1px solid silver'>
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
            @foreach($student->transactions as $transaction)
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
                        <small>{{ trans('transactions.public_'.$transaction->transaction_type) }}</small>
                    </td>
                    <td>¥{{ number_format($transaction->amount, Config::get('custom.currency_decimals')) }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>{{ $transaction->details }}</td>
                    <td>{{ $transaction->created_at->diffForHumans() }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@stop