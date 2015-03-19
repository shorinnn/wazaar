@if ($course)
    <div class="object small-box small-box-one">
        <div class="img-container">
            <img src="{{$course->previewImage->url}}" class="img-responsive" alt="">
        </div>
        <div class="next_" style="position: relative; ">
            <div style="color:#fff; padding: 15px 0 0 10px;">{{$course->name}}</div>
        </div>
        <div>&nbsp;</div>
        <div class="row">
            <div class="col-md-4"><strong>Price</strong></div>
            <div class="col-md-6">¥ {{number_format($finalCost)}}</div>
        </div>
        <div>&nbsp;</div>
        <div class="row">
            <div class="col-md-4"><strong>Tax(8%)</strong></div>
            <div class="col-md-6">¥ {{$taxValue}}</div>
        </div>
        <hr/>
        <ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="#"><span class="badge pull-right">¥ {{number_format($amountToPay)}}</span> Total</a>
            </li>
        </ul>
    </div>
@else
    Course Not Found
@endif