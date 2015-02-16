<div class="row">
    <div class="col-md-7"><div class="big-text align-right">Clicks</div> </div>
    <div class="col-md-5"><div class="big-text align-left">{{number_format($trackingHitsSales->hits)}}</div></div>
</div>
<div class="row">
    <div class="col-md-7"><div class="big-text align-right">Sales Count</div></div>
    <div class="col-md-5"><div class="big-text">{{$trackingHitsSales->sales_count}}</div></div>
</div>
<div class="row">
    <div class="col-md-7"><div class="big-text align-right">Sales Total</div></div>
    <div class="col-md-5"><div class="big-text">¥ {{number_format($trackingHitsSales->sales_total)}}</div></div>
</div>
<div class="row">
    <div class="col-md-7"><div class="big-text align-right">Conversion</div></div>
    <div class="col-md-5"><div class="big-text">{{number_format($trackingHitsSales->sales_count / $trackingHitsSales->hits * 100,2)}}%</div></div>
</div>