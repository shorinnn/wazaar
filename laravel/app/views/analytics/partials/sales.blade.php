<h2>¥{{number_format($sales['sales_total'],2)}}
    <span>(+20%)</span>
</h2>

@if ($frequency == 'week')
<ul>
    @foreach($sales['data'] as $sale)
        <li id="monday" class="clearfix">
            <span>{{date('l',strtotime($sale['created_at']))}}</span>
            <div>
                <span></span>
            </div>
            <em>¥{{number_format($sale['total_purchase'],2)}}</em>
        </li>
    @endforeach
</ul>
@endif