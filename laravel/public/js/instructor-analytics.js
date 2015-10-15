var $ajaxLoader = $('#ajax-loader-wrapper').html();

var Analytics = {

    'activateLoader' : function (){
        $('#wrapper-sales').html($ajaxLoader);
        $('#wrapper-top-courses').html($ajaxLoader);
        $('#wrapper-tracking-codes-table').html($ajaxLoader);
        $('#wrapper-tracking-codes').html($ajaxLoader);
        $('#wrapper-course-conversions').html($ajaxLoader);
        $('#wrapper-tracking-code-conversions').html($ajaxLoader);
        $('#wrapper-ltc-registrations').html($ajaxLoader);
        $('#wrapper-tracking-code-stats').html($ajaxLoader);
        $('#wrapper-user-stats').html($ajaxLoader);
        $('#wrapper-sales-count').html($ajaxLoader);
        $('#wrapper-two-tier-sales').html($ajaxLoader);
    },
    'topCourses' :  function ($frequency, $courseId, $elem){


        $.get('/dashboard/topcourses/' + $frequency + '/' + $courseId, function ($html){
            $('#wrapper-top-courses').html($html);

            $('.top-courses-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-top-courses-frequency').html(_("Today"));
            }
            else if($frequency == 'week'){
                $('#header-top-courses-frequency').html(_("This Week"));
            }
            else if($frequency == 'month'){
                $('#header-top-courses-frequency').html(_("This Month"));
            }
            else if($frequency == 'alltime'){
                $('#header-top-courses-frequency').html(_("All Time"));
            }
        });
    },
    'TwoTierSales' :  function ($frequency, $courseId, $trackingCode, $elem){


        $.get('/analytics/two-tier-sales/' + $frequency + '/' + $courseId + '/' + $trackingCode, function ($html){
            $('#wrapper-two-tier-sales').html($html);

            $('.sales-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-two-tier-sales-frequency').html(_("Today"));
            }
            else if($frequency == 'week'){
                $('#header-two-tier-sales-frequency').html(_("This Week"));
            }
            else if($frequency == 'month'){
                $('#header-two-tier-sales-frequency').html(_("This Month"));
            }
            else if($frequency == 'alltime'){
                $('#header-two-tier-sales-frequency').html(_("All Time"));
            }

        });
    },
    'Sales' :  function ($frequency, $courseId, $trackingCode, $elem){


        $.get('/analytics/sales/' + $frequency + '/' + $courseId + '/' + $trackingCode, function ($html){
            $('#wrapper-sales').html($html);

            $('.sales-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-sales-frequency').html(_("Today"));
            }
            else if($frequency == 'week'){
                $('#header-sales-frequency').html(_("This Week"));
            }
            else if($frequency == 'month'){
                $('#header-sales-frequency').html(_("This Month"));
            }
            else if($frequency == 'alltime'){
                $('#header-sales-frequency').html(_("All Time"));
            }
            if ($('#wrapper-tracking-codes-table').length == 1) {
                Analytics.trackingCodeTable($frequency, $courseId);
            }
        });
    },

    'SalesCount' : function ($frequency, $courseId, $elem){

        Analytics.activateLoader();
        $.get('/analytics/sales/get-count/' + $frequency + '/' + $courseId, function ($html){
            $('.sales-count-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'today' || $frequency == 'daily'){
                $('#header-sales-count-frequency').html(_("Today"));
                $('.with-today').trigger('click');
            }
            else if($frequency == 'week'){
                $('#header-sales-count-frequency').html(_("This Week"));
                $('.with-weekly').trigger('click');
            }
            else if($frequency == 'month'){
                $('#header-sales-count-frequency').html(_("This Month"));
                $('.with-monthly').trigger('click');
            }
            else if($frequency == 'alltime'){
                $('#header-sales-count-frequency').html(_("All Time"));
                $('.with-alltime').trigger('click');
            }

            $('#wrapper-sales-count').html($html);
        });

        $('.button-filter').removeClass('btn-primary');
        $('.button-filter').removeClass('active');
        $('.button-filter-' + $frequency).addClass('btn-primary');
    },

    'trackingCodeTable' : function ($frequency, $courseId){

        $.get('/analytics/trackingcodetable/' + $frequency + '/' + $courseId, function ($html){
            $('#wrapper-tracking-codes-table').html($html);
        });
    },

    'trackingSalesCodes' :  function ($frequency, $courseId, $elem){

        $.get('/analytics/trackingcodessales/' + $frequency + '/' + $courseId, function ($html){
            $('#wrapper-tracking-codes').html($html);

            $('.tracking-codes-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-tracking-codes-frequency').html(_("Today"));
            }
            else if($frequency == 'week'){
                $('#header-tracking-codes-frequency').html(_("This Week"));
            }
            else if($frequency == 'month'){
                $('#header-tracking-codes-frequency').html(_("This Month"));
            }
            else if($frequency == 'alltime'){
                $('#header-tracking-codes-frequency').html(_("All Time"));
            }
        });
    },

    'trackingCodeStats' :  function ($frequency, $courseId, $code, $elem){

        $.get('/dashboard/course/' + $courseId + '/trackingcode/' + $code + '/stats/' + $frequency, function ($html){
            $('#wrapper-tracking-code-stats').html($html);

            $('.tracking-code-hits-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-tracking-codes-frequency').html(_("Today"));

            }
            else if($frequency == 'week'){
                $('#header-tracking-codes-frequency').html(_("This Week"));
            }
            else if($frequency == 'month'){
                $('#header-tracking-codes-frequency').html(_("This Month"));
            }
            else if($frequency == 'alltime'){
                $('#header-tracking-codes-frequency').html(_("All Time"));
            }
        });
    },
    'CourseId' : 0,
    'DateFilterStart' : undefined,
    'DateFilterEnd' : undefined,
    'InitCalendarFilter' : function(){
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            Analytics.DateFilterStart = start.format('YYYY-MM-DD');
            Analytics.DateFilterEnd =end.format('YYYY-MM-DD');
        }
        cb(moment().subtract(29, 'days'), moment());
        var $date = new Date();
        var $startDate = new Date($date.getFullYear(), $date.getMonth(), 1);
        var $endDate = new Date($date.getFullYear(), $date.getMonth() + 1, 0);

        $('#reportrange').daterangepicker({
            locale: 'jp',
            startDate: $startDate,
            endDate: $endDate,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            Analytics.DateFilterStart = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
            Analytics.DateFilterEnd = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');
        });
    },

    'CourseStatisticsTable' : function(){
        $('.table-stats-wrapper').html($ajaxLoader);
        $.get('/analytics/course/stats/' + Analytics.CourseId + '/' + Analytics.DateFilterStart + '/' + Analytics.DateFilterEnd, function ($table){
            $('.table-stats-wrapper').html($table);
        });
    },

    'CourseAffiliatesTable' : function() {
        $('.table-affiliates-wrapper').html($ajaxLoader);
        $.get('/analytics/course/affiliates/' + Analytics.CourseId + '/' + Analytics.DateFilterStart + '/' + Analytics.DateFilterEnd, function ($table){
            $('.table-affiliates-wrapper').html($table);
        });
    },

    'ApplyCoursePageTableDateFilter' : function (){
        Analytics.CourseAffiliatesTable();
        Analytics.CourseStatisticsTable();
    },

    'InitCoursePage' : function(){

        Analytics.CourseAffiliatesTable();
        Analytics.CourseStatisticsTable();


        $('.table-stats-wrapper').on('click','a', function ($e){
            $e.preventDefault();
            var $url = $(this).attr('href');
            $.get($url, function ($table){
                $('.table-stats-wrapper').html($table);
            });
        });

        $('#affiliateId').select2({
            placeholder: "Select an Affiliate"
        });

        $('#tcyCategoryId').select2({
            placeholder: "Select a Category"
        });

        $('#tcnCategoryId').select2({
            placeholder: "Select a Category"
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

            $.post('/analytics/affiliatestable', $formData, function ($resp){
                $('.affiliates-table-and-pagination').html($resp.html);
                $btn.button('reset');
            },'json');
        });
    }
};
