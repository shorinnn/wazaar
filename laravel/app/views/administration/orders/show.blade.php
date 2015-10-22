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
			<div class="col-md-8">Affiliate Revenue</div>
			<div class="col-md-4">¥ {{number_format($order->affiliate_earnings)}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-8">Instructor Comissions</div>
			<div class="col-md-4">¥ {{number_format($order->instructor_earnings)}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-8">Affiliate 2nd Tier Fee</div>
			<div class="col-md-4">¥ {{number_format($order->second_tier_affiliate_earnings)}}</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="col-md-6">
		<div>
			<div class="col-md-8">LTC Comissions</div>
			<div class="col-md-4">¥ {{number_format($order->ltc_affiliate_earnings)}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-8">TAX</div>
			<div class="col-md-4">¥ {{number_format($order->tax)}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-8">Wazaar System Fee</div>
			<div class="col-md-4">¥ {{number_format($order->site_earnings)}}</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="course-details">
	<div>
		<div class="col-md-3">Course</div>
		<div class="col-md-9"><a href="{{action('CoursesController@adminShowCourse', $order->product->slug)}}" class="wazaar-blue-text">{{$order->product->name}}</a></div>
		<div class="clearfix"></div>
	</div>
	<div class="col-md-6">
		<div>
			<div class="col-md-5">Student</div>
			<div class="col-md-7">{{$order->student->last_name.' '.$order->student->first_name}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-5">Email</div>
			<div class="col-md-7">{{$order->student->email}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-5">Instructor</div>
			<div class="col-md-7">{{$order->product->instructor->last_name.' '.$order->product->instructor->first_name}}</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-5">Email</div>
			<div class="col-md-7">{{$order->product->instructor->email}}</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="col-md-6">
		<div>
			<div class="col-md-7">Affiliate</div>
			<div class="col-md-5">
				@if($order->productAffiliate)
					{{$order->productAffiliate->last_name.' '.$order->productAffiliate->first_name}}
				@else
					N/A
				@endif
			</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-7">LTC</div>
			<div class="col-md-5">
				@if($order->ltcAffiliate)
					{{$order->ltcAffiliate->last_name.' '.$order->ltcAffiliate->first_name}}
				@else
					N/A
				@endif
			</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="col-md-7">2-Tier Affiliate</div>
			<div class="col-md-5">
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
			<div class="col-md-7">2-Tier Publisher</div>
			<div class="col-md-5">
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
</div>