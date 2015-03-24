<div class='row'>
    <div class='col-lg-12' style='border:1px solid silver'>
        <h3>My Student Balance</h3>
        ¥{{ number_format($user->student_balance, Config::get('custom.currency_decimals')) }}
        <h3>My Student Transactions</h3>
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
            @foreach($user->paginated_transactions as $transaction)
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
        {{ $user->paginated_transactions->appends( [ 'show' => Input::get('show') ] )->links() }}
    </div>
</div>