@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <div class="container affiliate-dashboard dashboard  analytics-page">
            <div class="top-courses-purchased-wrapper">
                <h1>LTC Purchases</h1>
                <table class='table table-striped table-bordered'>
                    <tr>
                        <td>Product</td>
                        <td>Cost</td>
                        <td>Instructor | Earnings</td>
                        <td>LTC Affiliate | Earnings</td>
                        <td>Affiliate | Earnings</td>
                        <td>2Tier Pub | Earnings</td>
                        <td>2Tier Aff | Earnings</td>
                        <td>Wazaar Earnings</td>
                        
                    </tr>
                    @foreach($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->product->name.' ('.$purchase->product_type.')' }}</td>
                        <td>{{ $purchase->purchase_price }}</td>
                        <td>
                            #{{$purchase->product->instructor->id}}
                            @if($purchase->product_type=='Course')
                                {{ $purchase->product->instructor->fullName() }}
                            @else
                                {{ $purchase->product->module->course->instructor->fullName() }}
                            @endif
                            | 
                            &yen;{{ $purchase->instructor_earnings}}
                        </td>
                        <td>
                            @if($purchase->ltc_affiliate_earnings > 0 )
                                @if($purchase->ltc_affiliate==null)
                                    USER #{{ $purchase->ltc_affiliate_id }} MISSING!
                                @else
                                    #{{ $purchase->ltc_affiliate->id }}
                                    {{  $purchase->ltc_affiliate->fullName() }} |
                                    &yen;{{$purchase->ltc_affiliate_earnings}}
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($purchase->affiliate_earnings > 0)
                                @if($purchase->productAffiliate==null)
                                    USER #{{ $purchase->affiliate_id }} MISSING!
                                @else
                                    #{{ $purchase->productAffiliate->id }}
                                    {{  $purchase->productAffiliate->fullName() }} |
                                    &yen;{{$purchase->affiliate_earnings}}
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($purchase->second_tier_instructor_earnings > 0)
                            <?php $stPub = Instructor::find($purchase->second_tier_instructor_id) ;?>
                                #{{ $stPub->id }}
                                {{ $stPub->fullName() }} |
                                &yen;{{$purchase->second_tier_instructor_earnings}}
                            @endif
                        </td>
                        <td>
                            @if($purchase->second_tier_affiliate_earnings > 0)
                            <?php $stAff = ProductAffiliate::find($purchase->second_tier_affiliate_id) ;?>
                                #{{ $stAff->id }}
                                {{ $stAff->fullName() }} |
                                &yen;{{$purchase->second_tier_affiliate_earnings}}
                            @endif
                        </td>
                        <td>
                            &yen;{{$purchase->site_earnings}}
                        </td>
                        
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