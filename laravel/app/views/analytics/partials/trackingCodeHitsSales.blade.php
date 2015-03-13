<div class="row">
    <div class="col-md-7"><div class="big-text align-right">{{trans('analytics.clicks')}}</div> </div>
    <div class="col-md-5"><div class="big-text align-left">{{number_format($trackingHitsSales->hits)}}</div></div>
</div>
<div class="row">
    <div class="col-md-7"><div class="big-text align-right">{{trans('analytics.salesCount')}}</div></div>
    <div class="col-md-5"><div class="big-text">{{$trackingHitsSales->sales_count}}</div></div>
</div>
<div class="row">
    <div class="col-md-7"><div class="big-text align-right">{{trans('analytics.salesTotal')}}</div></div>
    <div class="col-md-5"><div class="big-text">¥ {{number_format($trackingHitsSales->sales_total)}}</div></div>
</div>
<div class="row">
    <div class="col-md-7"><div class="big-text align-right">{{trans('analytics.conversion')}}</div></div>
    <div class="col-md-5">
        <div class="big-text">
            @if ($trackingHitsSales->hits > 0)
            {{number_format($trackingHitsSales->sales_count / $trackingHitsSales->hits * 100,2)}}
            @else
                0
            @endif
                %
        </div>
    </div>
</div>