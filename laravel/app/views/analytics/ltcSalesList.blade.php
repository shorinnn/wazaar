@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>LTC Sales ({{$salesLabel}})</h2>

                    <table class="table table-striped">
                        <thead>
                            <th>Product Name</th>
                            <th>Original Price</th>
                            <th>Selling Price</th>
                            <th>LTC Commission</th>
                            <th>Date/Time</th>
                        </thead>

                        <tbody>
                            @foreach($purchases as $purchase)
                            <tr>
                                <td>{{$purchase->product->name}}</td>
                                <td>¥{{$purchase->original_price}}</td>
                                <td>¥{{$purchase->purchase_price}}</td>
                                <td>¥{{$purchase->ltc_affiliate_earnings}}</td>
                                <td>{{$purchase->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{$purchases->appends(Input::all())->links()}}
                </div>
            </div>
        </div>
    </div>
@stop