<h2>¥{{number_format($sales['salesTotal'])}}

</h2>


<ul>
    @foreach($sales['sales'] as $sale)
        <li id="monday" class="clearfix">
            <span>
                @if (isset($urlIdentifier))
                    <a href="{{url('analytics/affiliate/'. $urlIdentifier .'/' . $frequency . '?' . AnalyticsHelper::getQueryStringParams($frequency,$sale))}}">{{$sale['label']}}</a>
                @else
                    {{$sale['label']}}
                @endif
            </span>
            <div>
                <div class="progress" style="width: {{$sale['percentage']}}%"></div>
            </div>
            <em>¥{{number_format($sale['month']['sales_total'])}}</em>
        </li>
    @endforeach
</ul>
