<h2>¥{{number_format($sales['salesTotal'],2)}}

</h2>


<ul>
    @foreach($sales['sales'] as $sale)
        <li id="monday" class="clearfix">
            <span>{{$sale['label']}}</span>
            <div>
                <span></span>
            </div>
            <em>¥{{number_format($sale['month']['sales_total'],2)}}</em>
        </li>
    @endforeach
</ul>