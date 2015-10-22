<div class="container members-area  ajax-content ajax-content-{{$type}}">
    <div class="row">
    	<div class="col-md-12">
            @if(Request::segment('3')=='')
                <div class='label label-success'>
                    <span id='{{$type}}-ready-for-payment'></span> ready for payments
                </div>

                <div class='label label-danger'>
                    <span id='{{$type}}-not-ready-for-payment'></span> without bank details
                </div>
            @endif
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
                                {{ trans('administration.period') }}
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
                        <tr class='transaction-row'>
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
                                            <p class='no-fill' style='color:red; font-weight: bold'>NO FILL</p>
                                        @elseif( $request->user->noFill('Instructor') )
                                            <p class='no-fill' style='color:red; font-weight: bold'>NO FILL</p>
                                        @else
                                        @endif
                                        
                                    {{ $request->user->commentName('instructor') }}
                                    
                                @elseif( $request->transaction_type=='affiliate_debit')
                                        @if($request->user->_profile('Affiliate')==null)
                                            <p class='no-fill' style='color:red; font-weight: bold'>NO FILL</p>
                                         @elseif( $request->user->noFill('Affiliate') )
                                            <p class='no-fill' style='color:red; font-weight: bold'>NO FILL</p>
                                        @else
                                        @endif
                                        
                                    {{ $request->user->commentName('affiliate') }}
                                @else
                                    {{ $request->user->commentName('instructor_agency') }}
                                @endif
                                <br />
                                {{ $request->user->email }}
                                <br />
                                <a onclick="toggle('.bank-deets-{{$request->id}}')">Bank Details</a>
                            </td>
                            <td>
                                {{ trans('administration.before-fee') }}:
                                    ¥{{ number_format( ( $request->amount + Config::get('custom.cashout.fee') ), Config::get('custom.currency_decimals')) }}<br />
                                {{ trans('administration.after-fee') }}: 
                                    ¥{{ number_format( $request->amount, Config::get('custom.currency_decimals')) }}
                                
                            </td>
                            <td>{{ $request->period() }}</td>
                            <td>
                                {{ $request->created_at->diffForHumans() }}
                            </td>
                            <td>
                                @if( isset($request) && $request->status=='pending') 
                                    <input type="text" name="reference[{{$request->id}}]" placeholder="{{ trans('administration.reference') }}" 
                                           value="{{ $request->id }}" />
                                @endif
                            </td>
                            
                        </tr>
                        <tr></tr>
                        <tr>
                            <td colspan="7">
                                <div class="row well bank-deets-{{$request->id}}" style="display:none">
                                    @if( $request->transaction_type=='instructor_debit')
                                        <?php $bank = $request->user->_profile('Instructor');?>
                                    @elseif( $request->transaction_type=='affiliate_debit')
                                        <?php $bank = $request->user->_profile('Affiliate');?>
                                    @else
                                    @endif
                                    <div class="col-lg-6">
                                        Bank Code: {{ $bank->bank_code or '' }}<br />
                                        Bank Name: {{ $bank->bank_name or '' }}<br />
                                        Branch Code: {{ $bank->branch_code or '' }}<br />
                                        Branch Name: {{ $bank->branch_name or '' }}<br />
                                    </div>
                                    <div class="col-lg-6">
                                        Account Type: {{ $bank->account_type or '' }}<br />
                                        Account Number: {{ $bank->account_number or '' }}<br />
                                        Beneficiary Name: {{ $bank->beneficiary_name or '' }}<br />
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="7">
                                @if( isset($request) && $request->status=='pending') 
                                    <button type='button' class='btn btn-primary' onclick="processWithdrawal(this)"
                                            data-mode='complete'
                                            data-message='{{ trans('administration.mark-transaction-complete') }}?'>{{ trans('administration.mark-approved') }}</button>
                                    <button type='button' class='btn btn-danger' onclick="processWithdrawal(this)"
                                            data-mode='reject'
                                            data-message='{{ trans('administration.mark-transaction-failed') }}?'>{{ trans('administration.reject-selected') }}</button>
                                @else
                                    <button type='button' class='btn btn-primary' onclick="processWithdrawal(this)"
                                        data-mode='paid'
                                        data-message='{{ trans('administration.mark-transaction-paid') }}?'>{{ trans('administration.mark-paid') }}</button>
                               
                                @endif
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
    	<div class="col-md-12 load-remote" data-target='.ajax-content-{{$type}}' data-load-method="fade" data-callback='calculateReadiness'>
    		{{ $requests->appends( ['tab' => $type] )->links() }}
    	</div>
	</div>
</div>