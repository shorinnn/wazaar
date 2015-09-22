<h2>{{number_format($sales['salesCount'])}}</h2>
<ul class="daily-stat-wrap">
    @foreach($sales['sales'] as $sale)
        <li class="clearfix">
            <span>{{$sale['label']}}</span>
            <div>
                <div class="progress" style="width: {{$sale['percentage']}}%"></div>
            </div>
            <em>{{number_format($sale[$frequencyOverride]['sales_count'])}}</em>
        </li>
    @endforeach
</ul>
