
<style>
	.details-container .list{
		padding-top:5px;
		padding-bottom: 5px;
	}

</style>
<h2 class="text-center">Order {{$order->id}}</h2>
<p class="text-center text-muted">
	{{$order->created_at->format('M d, Y h:i A')}}<br />
	{{$order->created_at->format('\\(l\\)')}}
</p>
<p class="text-center text-muted">
	Order Amount
</p>
<h2 class="text-center text-success" style="margin-top:0px;">
	¥ {{number_format($order->purchase_price)}}
</h2>
<div>
	<div class="col-md-6">
		<div>
			<div class="col-md-8 list">Affiliate Revenue</div>
			<div class="col-md-4 list">¥ {{number_format($order->affiliate_earnings)}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-8 list">Instructor Comissions</div>
			<div class="col-md-4 list">¥ {{number_format($order->instructor_earnings)}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-8 list">Affiliate 2nd Tier Fee</div>
			<div class="col-md-4 list">¥ {{number_format($order->second_tier_affiliate_earnings)}}</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="col-md-6">
		<div>
			<div class="col-md-8 list">LTC Comissions</div>
			<div class="col-md-4 list">¥ {{number_format($order->ltc_affiliate_earnings)}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-8 list">TAX</div>
			<div class="col-md-4 list">¥ {{number_format($order->tax)}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-8 list">Wazaar System Fee</div>
			<div class="col-md-4 list">¥ {{number_format($order->site_earnings)}}</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="course-details">
	<div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top-30 padding-bottom-20 text-center">Course: <a href="{{action('CoursesController@adminShowCourse', $order->product->slug)}}" class="wazaar-blue-text"> {{$order->product->name}}</a></div>
		<div class="clearfix"></div>
	</div>
	<div class="col-md-6">
		<div>
			<div class="col-md-5 list">Student</div>
			<div class="col-md-7 list">{{$order->student->last_name.' '.$order->student->first_name}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-5 list">Email</div>
			<div class="col-md-7 list">{{$order->student->email}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-5 list">Instructor</div>
			<div class="col-md-7 list">{{$order->product->instructor->last_name.' '.$order->product->instructor->first_name}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-5 list">Email</div>
			<div class="col-md-7 list">{{$order->product->instructor->email}}</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="col-md-6">
		<div>
			<div class="col-md-7 list">Affiliate</div>
			<div class="col-md-5 list">
				@if($order->productAffiliate)
					{{$order->productAffiliate->last_name.' '.$order->productAffiliate->first_name}}
				@else
					N/A
				@endif
			</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-7 list">LTC</div>
			<div class="col-md-5 list">
				@if($order->ltcAffiliate)
					{{$order->ltcAffiliate->last_name.' '.$order->ltcAffiliate->first_name}}
				@else
					N/A
				@endif
			</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-7 list">2-Tier Affiliate</div>
			<div class="col-md-5 list">
				@if($order->productAffiliate)
					@if($order->productAffiliate->secondTierAffiliate)
						{{$order->productAffiliate->secondTierAffiliate->last_name.' '.$order->productAffiliate->secondTierAffiliate->first_name}}
					@else
						N/A
					@endif
				@else
					N/A
				@endif
			</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-7 list">2-Tier Publisher</div>
			<div class="col-md-5 list">
				@if($order->second_tier_instructor)
					{{$order->second_tier_instructor->last_name.' '.$order->second_tier_instructor->first_name}}
				@else
					N/A
				@endif
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="text-center big-red-circle-btn-container">
		{{ Form::open( ['action' => array('MembersController@refund'), 
                'method' => 'POST', 'id'=>'refund-form-'.$order->id, 'class' => 'ajax-form',
            'data-callback' => 'closeModalAndRefreshList'] ) }}
        <input type="hidden" name="purchase" value="{{ $order->id }}" />
		<button type="submit" name='refund-purchase' class="big-red-circle delete-button refund-purchase-{{$order->id}}" data-message="{{ trans('administration.sure-refund') }}?">{{ trans('administration.refund') }}</button>
        {{ Form::close() }}
	</div>
</div>