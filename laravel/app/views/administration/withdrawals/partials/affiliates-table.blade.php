<?php
$cashoutFee = Setting::where( [ 'name' => 'cashout-bank-fee' ] )->first();
if($cashoutFee==null || $cashoutFee->value==='')
$fee = Config::get('custom.cashout.fee');
else
$fee = $cashoutFee->value;
?>
<div class=" members-area  ajax-content ajax-content-{{$type}}">
    <div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    	    <div class="label-wrap clearfix">
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
            <div class="table-wrap courses-table clear table-responsive">
               <form method='post' id='withdrawForm' action='{{action('WithdrawalsController@update')}}'>
               <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                <table class="table">
                    <thead>
                        <tr>

                            <th>
                                {{ trans('profile.form.name') }}
                            </th>
                            <th>
                                {{ trans('profile.form.email') }}
                            </th>
                            <th>
                                {{ trans('administration.orders.total') }}
                            </th>
                            <th class="text-center">
                                {{ trans('analytics.affiliate_commission') }}
                            </th>
                            <th class="text-center">
                                {{ trans('analytics.second_tier_commission') }}
                            </th>
                            <th>
                                {{ trans('analytics.ltc_commission') }}
                            </th>
                            <th>
                                {{ trans('profile.tabBankDetails') }}
                            </th>
                            <th class="hidden-xs">
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

                                @if($request->user->profile==null)
                                    {{ $request->user->first_name }}
                                @else
                                    {{ $request->user->profile->first_name }}
                                @endif
                            </td>
                            <td>
                                {{ $request->user->email }}
                            </td>
                            <td style="min-width: 130px;">
                                {{ trans('administration.before-fee') }}:
                                    <span class="success-color">¥{{ number_format( ( $request->amount + $fee ), Config::get('custom.currency_decimals')) }}</span>
                                    <div class="clear"></div>
                                {{ trans('administration.after-fee') }}:
                                    <span class="success-color">¥{{ number_format( $request->amount, Config::get('custom.currency_decimals')) }}</span>
                            </td>
                            <td class="text-center">
                                <?php $com = $request->affiliateCommissions() ;?>
                                <span class="success-color">¥{{ number_format( $com['affiliate'], Config::get('custom.currency_decimals')) }}</span>
                            </td>
                            <td class="text-center">
                                <span class="success-color">¥{{ number_format( $com['second'], Config::get('custom.currency_decimals')) }}</span>
                            </td>
                            <td>
                                <span class="success-color">¥{{ number_format( $com['ltc'], Config::get('custom.currency_decimals')) }}</span>
                            </td>
                            <td>
                                @if( $request->user->noFill('Affiliate') )
                                    <span class="danger-color">{{ trans('courses/general.no')}}</span>
                                @else
                                    <span class="success-color">{{ trans('courses/general.yes')}}</span>
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
                                <td colspan="10" class="text-center">
                                    <button type='button' class='blue-button large-button' onclick="processWithdrawal(this)"
                                            data-mode='complete'
                                            data-message='{{ trans('administration.mark-transaction-complete') }}?'>{{ trans('administration.mark-approved') }}</button>
                                    <button type='button' class='red-button large-button' onclick="processWithdrawal(this)"
                                            data-mode='reject'
                                            data-message='{{ trans('administration.mark-transaction-failed') }}?'>{{ trans('administration.reject-selected') }}</button>
                                @else
                                <td colspan="9" class="text-center">
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