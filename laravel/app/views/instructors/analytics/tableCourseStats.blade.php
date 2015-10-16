<!--
<div class="row-fluid">
    <table class="table">
        <thead>
        <!-- <th>{{trans('analytics.date')}}</th> 
        <th>{{trans('analytics.salesCount')}}</th>
        <th>{{trans('analytics.salesTotal')}}</th>
        <th>{{trans('analytics.instructor_commission')}}</th>
        <th>{{trans('analytics.affiliate_revenue')}}</th>
        <th>{{trans('analytics.ltc_commission')}}</th>
        <th>{{trans('analytics.affiliate_two_tier_fee')}}</th>
        <th>{{trans('analytics.wazaar_system_fee')}}</th>
        <th>{{trans('analytics.tax')}}</th>
        </thead>

        <tbody>
        @foreach($stats as $stat)
            <tr>
                <!-- <td>{{$stat->date}}</td>
                <td>{{$stat->sales_count}}</td>
                <td>¥{{$stat->sales_total}}</td>
                <td>¥{{$stat->instructor_earnings}}</td>
                <td>¥{{$stat->affiliate_earnings}}</td>
                <td>¥{{$stat->ltc_affiliate_earnings}}</td>
                <td>¥{{$stat->second_tier_affiliate_earnings}}</td>
                <td>¥{{$stat->site_earnings}}</td>
                <td>¥{{$stat->tax}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
-->
<div class="new_analytics">
    @foreach($stats as $stat)
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 course-summary-block">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-6 column-1">
                <div class="row">
                    <h3>{{trans('analytics.courseStats')}}</h3>
                    <span class="earnings inline-block">
                        <em>¥ {{number_format($stat->sales_total)}}</em>
                        <span>{{trans('analytics.salesTotal')}}</span>
                    </span>
                    <span class="sales inline-block">
                        <em>{{$stat->sales_count}}</em>
                        <span>{{trans('analytics.salesCount')}}</span>
                    </span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 column-2">
                <p>
                    {{trans('analytics.affiliate_revenue')}}
                    <span>¥ {{number_format($stat->affiliate_earnings)}}</span>
                </p>
                <p>
                    {{trans('analytics.instructor_commission')}}
                    <span>¥ {{number_format($stat->instructor_earnings)}}</span>
                </p>
                <p>
                    {{trans('analytics.affiliate_two_tier_fee')}}
                    <span>¥ {{number_format($stat->second_tier_affiliate_earnings)}}</span>
                </p>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 column-3">
                <p>
                    {{trans('analytics.ltc_commission')}}
                    <span>¥ {{number_format($stat->ltc_affiliate_earnings)}}</span>
                </p>
                <p>
                    {{trans('analytics.tax')}}
                    <span>¥ {{number_format($stat->tax)}}</span>
                </p>
                <p>
                    {{trans('analytics.wazaar_system_fee')}}
                    <span>¥ {{number_format($stat->site_earnings)}}</span>
                </p>

            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @endforeach    
    {{-- $stats->links() --}}
    <div class="clearfix"></div>
</div>