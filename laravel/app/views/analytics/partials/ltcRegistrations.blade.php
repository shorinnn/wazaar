<h2>{{number_format($affiliates['affTotal'])}}</h2>
<ul class="daily-stat-wrap">
    @foreach($affiliates['affiliates'] as $aff)
        <li class="clearfix">
                <span>
                    @if (isset($urlIdentifier) && !empty($urlIdentifier))
                        <a href="{{url('affiliate/analytics/'. $urlIdentifier .'/' . $frequency . '?' . AnalyticsHelper::getQueryStringParams($frequency,$aff))}}">{{$aff['label']}}</a>
                    @else
                        {{$aff['label']}}
                    @endif
                </span>
            <div>
                <div class="progress" style="width: {{$aff['percentage']}}%"></div>
            </div>
            <em>{{number_format($aff[$frequencyOverride]['affiliates_count'])}}</em>
        </li>
    @endforeach
</ul>
