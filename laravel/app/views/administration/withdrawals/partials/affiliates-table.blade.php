<?php
$cashoutFee = Setting::where( [ 'name' => 'cashout-bank-fee' ] )->first();
if($cashoutFee==null || $cashoutFee->value==='')
$fee = Config::get('custom.cashout.fee');
else
$fee = $cashoutFee->value;
?>
<div class=" members-area  ajax-content ajax-content-{{$type}}">
    <div class="row">
    	<div class="col-md-12">
    	    <div class="label-wrap">
                @if(Request::segment('3')=='')
                    <div class='lesson-status approved'>
                        <span id='{{$type}}-ready-for-payment'>
                            {{ $ready }}
                        </span> ready for payments
                    </div>

                    <div class='lesson-status rejected'>
                        <span id='{{$type}}-not-ready-for-payment'>
                            {{ $not }}
                        </span> without bank details
                    </div>
                    <a href='{{action('WithdrawalsController@settings')}}' class="right settings default-button large-button"><i class='fa fa-cogs'></i> Settings</a>
                @endif
            </div>
            <div class="table-wrapper table-responsive clear">
               <form method='post' id='withdrawForm' action='{{action('WithdrawalsController@update')}}'>
               <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>

                            <th>
                                {{ trans('profile.form.lastName') }}
                            </th>
                            <th>
                                {{ trans('profile.form.firstName') }}
                            </th>
                            <th>
                                {{ trans('profile.form.email') }}
                            </th>
                            <th>
                                {{ trans('administration.orders.total') }}
                            </th>
                            <th>
                                {{ trans('analytics.affiliate_commission') }}
                            </th>
                            <th>
                                {{ trans('analytics.second_tier_commission') }}
                            </th>
                            <th>
                                {{ trans('analytics.ltc_commission') }}
                            </th>
                            <th>
                                {{ trans('profile.tabBankDetails') }}
                            </th>
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
                            @if(Request::segment('3')=='')
                                <th>
                                    {{ trans('administration.notes') }}
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr class='transaction-row'>
                            
                            
                            <td class="hidden-xs">
                                @if($request->user->profile==null)
                                    {{ $request->user->last_name }}
                                @else
                                    {{ $request->user->profile->last_name }}
                                @endif
                            </td>
                            <td>
                                @if($request->user->profile==null)
                                    {{ $request->user->first_name }}
                                @else
                                    {{ $request->user->profile->first_name }}
                                @endif
                            </td>
                            <td>
                                {{ $request->user->email }}
                            </td>
                            <td>
                                {{ trans('administration.before-fee') }}:
                                    ¥{{ number_format( ( $request->amount + $fee ), Config::get('custom.currency_decimals')) }}<br />
                                {{ trans('administration.after-fee') }}: 
                                    ¥{{ number_format( $request->amount, Config::get('custom.currency_decimals')) }}
                                
                            </td>
                            <td> 
                                <?php $com = $request->affiliateCommissions() ;?>
                                ¥{{ number_format( $com['affiliate'], Config::get('custom.currency_decimals')) }}
                            </td>
                            <td>
                                ¥{{ number_format( $com['second'], Config::get('custom.currency_decimals')) }}
                            </td>
                            <td>
                                ¥{{ number_format( $com['ltc'], Config::get('custom.currency_decimals')) }}
                            </td>
                            <td>
                                @if( $request->user->noFill('Affiliate') )
                                    {{ trans('courses/general.no')}}
                                @else
                                    {{ trans('courses/general.yes')}}
                                @endif
                            </td>
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
                            @if( isset($request) && $request->status=='pending') 
                            <td>
                                <input type="text" name="reference[{{$request->id}}]" placeholder="{{ trans('administration.notes') }}" />
                            </td>
                            @endif
                            
                        </tr>
                        @endforeach
                        <tr>
                                @if( isset($request) && $request->status=='pending') 
                                <td colspan="10">
                                    <button type='button' class='blue-button large-button' onclick="processWithdrawal(this)"
                                            data-mode='complete'
                                            data-message='{{ trans('administration.mark-transaction-complete') }}?'>{{ trans('administration.mark-approved') }}</button>
                                    <button type='button' class='red-button large-button' onclick="processWithdrawal(this)"
                                            data-mode='reject'
                                            data-message='{{ trans('administration.mark-transaction-failed') }}?'>{{ trans('administration.reject-selected') }}</button>
                                @else
                                <td colspan="9">
                                    <button type='button' class='blue-button large-button' onclick="processWithdrawal(this)"
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