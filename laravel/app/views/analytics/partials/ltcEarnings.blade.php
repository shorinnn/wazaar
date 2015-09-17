<h2>¥{{number_format($affiliates['affTotal'])}}</h2>
<ul class="daily-stat-wrap">
    @foreach($affiliates['affiliates'] as $aff)
        <li class="clearfix">
            <span>{{$aff['label']}}</span>
            <div>
                <div class="progress" style="width: {{$aff['percentage']}}%"></div>
            </div>
            <em>¥{{number_format($aff[$frequencyOverride]['affiliates_earning'])}}</em>
        </li>
    @endforeach
</ul>
