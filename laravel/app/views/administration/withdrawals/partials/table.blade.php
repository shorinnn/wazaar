<div class="container members-area  ajax-content">
    <div class="row">
    	<div class="col-md-12">
            <div class="table-wrapper table-responsive clear">
               
                <table class="table table-bordered table-striped">
                    <tbody>
                        @foreach($requests as $request)
                        <tr>
                            <td class="hidden-xs">
                                <div class='checkbox-buttons'>
                                    <div class="checkbox-item"> 
                                        <div class="checkbox-checkbox checkbox-checked"> 
                                            <input id="checkbox-{{$request->id}}" autocomplete="off" value='{{$request->id}}' type="checkbox"> 
                                            <label for="checkbox-{{$request->id}}" class="small-checkbox"> </label> 
                                        </div> 
                                    </div>
                                </div>
                            </td>
                            <td class="hidden-xs">
                                {{ trans( 'transactions.'.$request->transaction_type.'_transaction' ) }}
                            </td>
                            <td class="hidden-xs">
                                @if( $request->transaction_type=='instructor_debit')
                                    {{ $request->user->commentName('instructor') }}
                                    
                                @elseif( $request->transaction_type=='affiliate_debit')
                                    {{ $request->user->commentName('affiliate') }}
                                @else
                                    {{ $request->user->commentName('instructor_agency') }}
                                @endif
                            </td>
                            <td>
                                Before Fee:
                                    ¥{{ number_format( ( $request->amount + Config::get('custom.cashout.fee') ), Config::get('custom.currency_decimals')) }}<br />
                                After Fee: 
                                    ¥{{ number_format( $request->amount, Config::get('custom.currency_decimals')) }}
                                
                            </td>
                            <td>
                                {{ $request->created_at->diffForHumans() }}
                            </td>
                            <td>
                                <form method='post' class='ajax-form' action='{{action('WithdrawalsController@complete')}}'>
                                    <input type='text' name='reference' placeholder="Reference" />  <br />
                                    <input type='hidden' name='transaction' value='{{$request->id}}' />
                                    <button type='submit' class='btn btn-primary delete-button'
                                        data-message='Mark transaction complete?'>Complete</button>
                                </form>
                                <form method='post' class='ajax-form' action='{{action('WithdrawalsController@reject')}}'>
                                    <input type='hidden' name='transaction' value='{{$request->id}}' />
                                <button type='submit' class='btn btn-danger delete-button'
                                        data-message='Mark transaction as failed and refund balance?'>Reject</button>
                                </form>
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12 load-remote" data-target='.ajax-content' data-load-method="fade">
    		{{ $requests->links() }}
    	</div>
	</div>
</div>