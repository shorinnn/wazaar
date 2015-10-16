<div class="container members-area  ajax-content">
    <div class="row">
    	<div class="col-md-12">
            <div class="table-wrapper table-responsive clear">
               <form method='post' id='withdrawForm' action='{{action('WithdrawalsController@update')}}'>
               <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>
                                <div class='checkbox-buttons'>
                                    <div class="checkbox-item"> 
                                        <div class="checkbox-checkbox checkbox-checked"> 
                                            <input id="checkbox" class="checkbox-toggler" data-target=".cb-togglable" autocomplete="off" type="checkbox"> 
                                            <label for="checkbox" class="small-checkbox"> </label> 
                                        </div> 
                                    </div>
                                </div>
                            </th>
                            <th>
                                {{ trans('administration.request-type') }}
                            </th>
                            <th>
                                {{ trans('administration.user') }}
                            </th>
                            <th>
                                {{ trans('administration.amount') }}
                            </th>
                            <th>
                                {{ trans('administration.timestamp') }}
                            </th>
                            <th>
                                {{ trans('administration.reference') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr>
                            <td class="hidden-xs">
                                <div class='checkbox-buttons'>
                                    <div class="checkbox-item"> 
                                        <div class="checkbox-checkbox checkbox-checked"> 
                                            <input id="checkbox-{{$request->id}}" class="cb-togglable"
                                                   name="request[{{$request->id}}]"
                                                   autocomplete="off" value='{{$request->id}}' type="checkbox"> 
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
                                        @if($request->user->_profile('Instructor')==null)
                                            <p style='color:red; font-weight: bold'>NO FILL</p>
                                        @elseif( $request->user->noFill('Instructor') )
                                            <p style='color:red; font-weight: bold'>NO FILL</p>
                                        @else
                                        @endif
                                        
                                    {{ $request->user->commentName('instructor') }}
                                    
                                @elseif( $request->transaction_type=='affiliate_debit')
                                        @if($request->user->_profile('Affiliate')==null)
                                            <p style='color:red; font-weight: bold'>NO FILL</p>
                                         @elseif( $request->user->noFill('Affiliate') )
                                            <p style='color:red; font-weight: bold'>NO FILL</p>
                                        @else
                                        @endif
                                        
                                    {{ $request->user->commentName('affiliate') }}
                                @else
                                    {{ $request->user->commentName('instructor_agency') }}
                                @endif
                                <br />
                                {{ $request->user->email }}
                            </td>
                            <td>
                                {{ trans('administration.before-fee') }}:
                                    ¥{{ number_format( ( $request->amount + Config::get('custom.cashout.fee') ), Config::get('custom.currency_decimals')) }}<br />
                                {{ trans('administration.after-fee') }}: 
                                    ¥{{ number_format( $request->amount, Config::get('custom.currency_decimals')) }}
                                
                            </td>
                            <td>
                                {{ $request->created_at->diffForHumans() }}
                            </td>
                            <td>
                                <input type="text" name="reference[{{$request->id}}]" placeholder="{{ trans('administration.reference') }}" 
                                       value="{{ $request->id }}" />
                            </td>
                            
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="6">
                                <button type='button' class='btn btn-primary' onclick="processWithdrawal(this)"
                                        data-mode='complete'
                                        data-message='{{ trans('administration.mark-transaction-complete') }}?'>{{ trans('administration.complete-selected') }}</button>
                                <button type='button' class='btn btn-danger' onclick="processWithdrawal(this)"
                                        data-mode='reject'
                                        data-message='{{ trans('administration.mark-transaction-failed') }}?'>{{ trans('administration.reject-selected') }}</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                   <input type="hidden" name="action" id='action' />
               </form>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12 load-remote" data-target='.ajax-content' data-load-method="fade">
    		{{ $requests->links() }}
    	</div>
	</div>
</div>