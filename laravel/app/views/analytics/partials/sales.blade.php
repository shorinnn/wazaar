<h2>¥{{number_format($sales['salesTotal'],2)}}</h2>
<ul>
    @foreach($sales['sales'] as $sale)
        <li id="monday" class="clearfix">
            <span>{{$sale['label']}}</span>
            <div>
                <div class="progress" style="width: {{$sale['percentage']}}%"></div>
            </div>
            <em>¥{{number_format($sale['day']['sales_total'],2)}}</em>
        </li>
    @endforeach
</ul>
