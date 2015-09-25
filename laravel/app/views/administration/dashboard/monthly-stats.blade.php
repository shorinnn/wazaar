@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <div class="container affiliate-dashboard dashboard  analytics-page">
            <div class="top-courses-purchased-wrapper">
                <form class='inline-form'>
                    <div class='col-lg-4'>
                        {{ Form::select('year', $years, Input::get('year') )}}
                    </div>
                    <div class='col-lg-4'>
                        {{ Form::select('month', $months, Input::get('month') )}}
                        
                    </div>
                    <div class='col-lg-2'>
                        <button class='blue-button large-button' type="submit">Filter</button>
                    </div>
                </form>
                <div class="container">
                	<div class="table-responsive analytics-page">
                    	<div class="top-affiliates-table table-wrapper">
                        	<div class="table-responsive">
                                <table class='table clear'>
                                    
                                    <tr>  <td>売上高（purchase_price）</td><td>&yen; {{  number_format( $stats->p_price, Config::get('custom.currency_decimals') ) }}</td></tr>
                                    <tr>    <td>原価（original_price)</td><td>&yen; {{  number_format( $stats->o_price, Config::get('custom.currency_decimals') ) }}</td></tr>
                                    <tr> <td>割引額（discount_value）</td><td>&yen; {{  number_format( $stats->d_value, Config::get('custom.currency_decimals') ) }}</td></tr>
                                    <tr>   <td>件数</td><td>{{ $stats->sales }}</td></tr>
                                    <tr>   <td>販売者収益（instructor_earnings)</td><td>&yen; {{  number_format( $stats->i_earnings, Config::get('custom.currency_decimals') ) }}</td></tr>
                                    <tr>  <td>販売2Tier（second_tier_instructor_earnings)</td><td>&yen; {{  number_format( $stats->sti_earnings, Config::get('custom.currency_decimals') ) }}</td></tr>
                                    <tr> <td>アフィリエイト収入（affiliate_earnings）</td><td>&yen; {{  number_format( $stats->a_earnings, Config::get('custom.currency_decimals') ) }}</td></tr>
                                    <tr> <td>2Tier アフィリエイト（second_tier_affiliate_earnings）</td><td>&yen; {{ number_format( $stats->sta_earnings, Config::get('custom.currency_decimals') ) }}</td></tr>
                                    <tr><td>LTC（ltc_affiliate_earnings）</td><td>&yen; {{  number_format( $stats->ltc_earnings, Config::get('custom.currency_decimals') ) }}</td></tr>
                                    <tr>  <td>Wazaar収入（site_earnings）</td><td>&yen; {{  number_format( $stats->site_earnings, Config::get('custom.currency_decimals') ) }}</td></tr>
                
                                   
                                </table>
                			</div>
                        </div>
                    </div>
                </div>
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