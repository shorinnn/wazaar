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
            if ($frequency == 'today'){
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
    }
};
