<h2>¥{{number_format($sales['salesTotal'])}}</h2>
<ul class="daily-stat-wrap">
    @foreach($sales['sales'] as $sale)
        <li id="monday" class="clearfix">
            <span>{{$sale['label']}}</span>
            <div>
                <div class="progress" style="width: {{$sale['percentage']}}%"></div>
            </div>
            <em>¥{{number_format($sale['day']['sales_total'])}}</em>
        </li>
    @endforeach
</ul>
