@extends('layouts.default')
@section('content')
<div class="container">
    <div class="table-responsive analytics-page">
        <div class="top-affiliates-table table-wrapper">
            <div class="table-header clearfix">
            	<h1 class="left">Second Tier Sales ({{$salesLabel}})</h1>
			</div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Product Name</th>
                        <th>Original Price</th>
                        <th>Selling Price</th>
                        <th>Second Tier Commission</th>
                        <th>Date/Time</th>
                    </thead>

                    <tbody>
                        @foreach($purchases as $purchase)
                        <tr>
                            <td>{{$purchase->product->name}}</td>
                            <td>¥{{$purchase->original_price}}</td>
                            <td>¥{{$purchase->purchase_price}}</td>
                            <td>¥{{$purchase->second_tier_affiliate_earnings}}</td>
                            <td class="last-column">{{$purchase->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
			</div>
                {{$purchases->appends(Input::all())->links()}}
        </div>
    </div>
</div>
@stop