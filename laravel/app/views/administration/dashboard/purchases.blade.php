@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <div class="container affiliate-dashboard dashboard  analytics-page">
            <div class="top-courses-purchased-wrapper">
                <br />
                <a class='btn btn-default' href='?filter=all'>All</a>
                <a class='btn btn-default' href='?filter=paid'>Paid</a>
                <a class='btn btn-default' href='?filter=free'>Free</a>
                <br />
                <table class='table table-striped table-bordered'>
                    <tr>
                        <td>Transaction ID</td>
                        <td>Product</td>
                        <td>Cost</td>
                        <td>Instructor</td>
                        <td>Customer</td>
                        <td>DateTime</td>
                    </tr>
                    @foreach($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->id }}</td>
                        <td>{{ $purchase->product->name.' ('.$purchase->product_type.')' }}</td>
                        <td>{{ $purchase->purchase_price }}</td>
                        <td>
                            @if($purchase->product_type=='Course')
                                {{ $purchase->product->instructor->fullName() }}
                            @else
                                {{ $purchase->product->module->course->instructor->fullName() }}
                            @endif
                        </td>
                        <td>
                            @if($purchase->student==null)
                                ACCOUNT NO LONGER EXISTS
                            @else
                            {{ $purchase->student->fullName() }}
                            @endif
                        </td>
                        <td>{{ $purchase->created_at }}</td>
                    </tr>
                    @endforeach
                </table>
                {{ $purchases->appends(['filter'=>Input::get('filter')])->links() }}
            </div>
        </div>
    </div>

    </div>

    <div id="ajax-loader-wrapper" class="hidden">
        <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
    </div>
@stop

@section('extra_css')
    <link rel="stylesheet" href="{{url('resources/select2-dist/select2.css')}}"/>
    <link rel="stylesheet" href="{{url('resources/select2-dist/select2-bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{url('resources/datetimepicker/build/css/bootstrap-datetimepicker.css')}}"/>
@stop

@section('extra_js')
    <script type="text/javascript" src="{{url('resources/select2-dist/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('js/analytics.js')}}"></script>
    <script type="text/javascript" src="{{url('js/admin.dashboard.js')}}"></script>
    <script src="{{url('resources/moment/min/moment.min.js')}}"></script>

    <script type="text/javascript" src="{{url('resources/datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
    <!--<script type="text/javascript" src="{{url('plugins/datepicker/js/bootstrap-datepicker.js')}}"></script>-->

    <script type="text/javascript">
        $(function(){
            $('#affiliateId').select2({
                placeholder: "Select an Affiliate"
            });

            $('#tcyCategoryId').select2({
                placeholder: "Select a Category"
            });

            $('#tcnCategoryId').select2({
                placeholder: "Select a Category"
            });


            $('#startDate, #startDate-yes, #startDate-no').datetimepicker({format: 'MM/DD/YYYY'});
            $('#endDate, #endDate-yes, #endDate-no').datetimepicker({format: 'MM/DD/YYYY'});

            $("#startDate").on("dp.change",function (e) {
                $('#endDate').data("DateTimePicker").minDate(e.date);
            });
            $("#endDate").on("dp.change",function (e) {
                $('#startDate').data("DateTimePicker").maxDate(e.date);
            });

            $("#startDate-yes").on("dp.change",function (e) {
                $('#endDate-yes').data("DateTimePicker").minDate(e.date);
            });
            $("#endDate-yes").on("dp.change",function (e) {
                $('#startDate-yes').data("DateTimePicker").maxDate(e.date);
            });

            $("#startDate-no").on("dp.change",function (e) {
                $('#endDate-no').data("DateTimePicker").minDate(e.date);
            });
            $("#endDate-no").on("dp.change",function (e) {
                $('#startDate-no').data("DateTimePicker").maxDate(e.date);
            });

            $("#startDate-no").on("click",function (e) {
                $('#startDate-no').data("DateTimePicker").show();
            });
            $("#startDate-yes").on("click",function (e) {
                $('#startDate-yes').data("DateTimePicker").show();
            });

            $("#endDate-no").on("click",function (e) {
                $('#endDate-no').data("DateTimePicker").show();
            });
            $("#endDate-yes").on("click",function (e) {
                $('#endDate-yes').data("DateTimePicker").show();
            });

            $("#endDate").on("click",function (e) {
                $('#endDate').data("DateTimePicker").show();
            });
            $("#startDate").on("click",function (e) {
                $('#startDate').data("DateTimePicker").show();
            });


            $('.affiliates-table-and-pagination').on('click', '.pagination-top-affiliates ul a',function ($e){
                $e.preventDefault();

                var $loc = $(this).attr('href');

                $.post($loc, function ($resp){
                    $('.affiliates-table-and-pagination').html($resp.html);
                },'json');
            });

            $('#btn-apply-filter-affiliates').on('click', function (){
                var $formData = $('#form-affiliates').serialize();

                var $btn = $(this);
                $btn.button('loading');

                $.post('/dashboard/admin/affiliatestable', $formData, function ($resp){
                    $('.affiliates-table-and-pagination').html($resp.html);
                    $btn.button('reset');
                },'json');
            });

            $('.courses-table-and-pagination-yes').on('click', '.pagination-top-courses ul a',function ($e){
                $e.preventDefault();

                var $loc = $(this).attr('href');

                $.post($loc, function ($resp){
                    $('.courses-table-and-pagination-yes').html($resp.html);
                },'json');
            });

            $('.courses-table-and-pagination-no').on('click', '.pagination-top-courses ul a',function ($e){
                $e.preventDefault();

                var $loc = $(this).attr('href');

                $.post($loc, function ($resp){
                    $('.courses-table-and-pagination-no').html($resp.html);
                },'json');
            });

            $('#btn-apply-filter-courses-yes').on('click', function (){
                var $formData = $('#form-courses-yes').serialize();

                var $btn = $(this);
                $btn.button('loading');

                $.post('/dashboard/admin/courses/yes', $formData, function ($resp){
                    $('.courses-table-and-pagination-yes').html($resp.html);
                    $btn.button('reset');
                },'json');
            });

            $('#btn-apply-filter-courses-no').on('click', function (){
                var $formData = $('#form-courses-no').serialize();

                var $btn = $(this);
                $btn.button('loading');

                $.post('/dashboard/admin/courses/no', $formData, function ($resp){
                    $('.courses-table-and-pagination-no').html($resp.html);
                    $btn.button('reset');
                },'json');
            });

        });
    </script>
@stop