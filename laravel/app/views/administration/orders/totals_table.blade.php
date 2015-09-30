<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>{{ trans('administration.orders.original-price' )}}</th>
				<th>{{ trans('administration.orders.discounted-price' )}}</th>
				<th>{{ trans('administration.orders.site-income' )}}</th>
				<th>{{ trans('administration.orders.instructor-income' )}}</th>
				<th>{{ trans('administration.orders.affiliate-income' )}}</th>
				<th>{{ trans('administration.orders.ltc-income' )}}</th>
				<th>{{ trans('administration.orders.2-tier-affiliate-income' )}}</th>
				<th>{{ trans('administration.orders.2-tier-instructor-income' )}}</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{ trans('administration.orders.total' )}}</td>
				<td>¥ {{number_format($totals[0]->original_price_total)}}</td>
				<td>¥ {{number_format($totals[0]->discounted_price_total)}}</td>
				<td>¥ {{number_format($totals[0]->site_earnings_total)}}</td>
				<td>¥ {{number_format($totals[0]->instructor_earnings_total)}}</td>
				<td>¥ {{number_format($totals[0]->affiliate_earnings_total)}}</td>
				<td>¥ {{number_format($totals[0]->ltc_affiliate_earnings_total)}}</td>
				<td>¥ {{number_format($totals[0]->second_tier_affiliate_earnings_total)}}</td>
				<td>¥ {{number_format($totals[0]->second_tier_instructor_earnings_total)}}</td>
			</tr>
		</tbody>
	</table>
</div>
