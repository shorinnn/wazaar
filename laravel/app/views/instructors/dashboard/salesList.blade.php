@extends('layouts.default')
@section('content')
<div class="container">
    <div class="table-responsive analytics-page">
        <div class="top-affiliates-table table-wrapper">
            <div class="table-header clearfix">
                <h1 class="left">{{ trans('analytics.sales') }} ({{$salesLabel}})</h1>
			</div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>{{ trans('analytics.product_name') }}</th>
                        <th>{{ trans('analytics.original_price') }}</th>
                        <th>{{ trans('analytics.selling_price') }}</th>
                        <th>{{ trans('analytics.affiliate_commission') }}</th>
                        <th>{{ trans('analytics.instructor_commission') }}</th>
                        <th>{{ trans('analytics.date_time') }}</th>
                    </thead>

                    <tbody>
                        @foreach($purchases as $purchase)
                        <tr>
                            <td>{{$purchase->product->name}}</td>
                            <td>¥{{$purchase->original_price}}</td>
                            <td>¥{{$purchase->purchase_price}}</td>
                            <td>¥{{$purchase->affiliate_earnings}}</td>
                            <td>¥{{$purchase->instructor_earnings}}</td>
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