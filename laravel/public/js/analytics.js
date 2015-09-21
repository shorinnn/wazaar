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
        $('#wrapper-second-tier-registrations').html($ajaxLoader);
        $('#wrapper-ltc-earnings').html($ajaxLoader);
        $('#wrapper-second-tier-earnings').html($ajaxLoader);
    },
    'topCourses' :  function ($frequency, $courseId, $elem){

        var $tempSelector = '.' + $frequency +  '-data-top-courses';

        if ($($tempSelector).html() == ''){
            $.get('/analytics/topcourses/' + $frequency + '/' + $courseId, function ($html){
                $('#wrapper-top-courses').html($html);
                $($tempSelector).html($html);
            });
        }
        else{
            $('#wrapper-top-courses').html($($tempSelector).html());
        }


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
    },
    'sales' :  function ($frequency, $courseId, $trackingCode, $elem){


        Analytics.activateLoader();

        var $tempSelector = '.' + $frequency +  '-data-sales';

        if ($($tempSelector).html() == ''){
            $.get('/analytics/sales/' + $frequency + '/' + $courseId + '/' + $trackingCode, function ($html){
                $('#wrapper-sales').html($html);
                $($tempSelector).html($html);
            });
        }
        else{
            $('#wrapper-sales').html($($tempSelector).html());
        }

        //$.get('/analytics/sales/' + $frequency + '/' + $courseId + '/' + $trackingCode, function ($html){
        //    $('#wrapper-sales').html($html);
        //});

        $('.sales-dropdown a').removeClass('active');
        $($elem).addClass('active');
        if ($frequency == 'daily'){
            $('#header-sales-frequency').html(_("Today"));
            $('.with-today').trigger('click');
        }
        else if($frequency == 'week'){
            $('#header-sales-frequency').html(_("This Week"));
            $('.with-weekly').trigger('click');
        }
        else if($frequency == 'month'){
            $('#header-sales-frequency').html(_("This Month"));
            $('.with-monthly').trigger('click');
        }
        else if($frequency == 'alltime'){
            $('#header-sales-frequency').html(_("All Time"));
            $('.with-alltime').trigger('click');
        }
        if ($('#wrapper-tracking-codes-table').length == 1) {
            Analytics.trackingCodeTable($frequency, $courseId);
        }

        $('.button-filter').removeClass('btn-primary');
        $('.button-filter-' + $frequency).addClass('btn-primary');
    },

    'trackingCodeTable' : function ($frequency, $courseId){

        $.get('/analytics/trackingcodetable/' + $frequency + '/' + $courseId, function ($html){
            $('#wrapper-tracking-codes-table').html($html);
        });
    },

    'trackingSalesCodes' :  function ($frequency, $courseId, $elem){

        var $tempSelector = '.' + $frequency +  '-data-top-tracking-codes';

        if ($($tempSelector).html() == ''){
            $.get('/analytics/trackingcodessales/' + $frequency + '/' + $courseId, function ($html){
                $('#wrapper-tracking-codes').html($html);
                $($tempSelector).html($html);
            });
        }
        else{
            $('#wrapper-tracking-codes').html($($tempSelector).html());
        }
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
        //$.get('/analytics/trackingcodessales/' + $frequency + '/' + $courseId, function ($html){
        //    $('#wrapper-tracking-codes').html($html);
        //});
    },
    'courseConversions' :  function ($frequency, $courseId, $elem){

        var $tempSelector = '.' + $frequency +  '-data-top-converting-courses';

        if ($($tempSelector).html() == ''){
            $.get('/analytics/courseconversions/' + $frequency + '/' + $courseId, function ($html){
                $('#wrapper-course-conversions').html($html);
                $($tempSelector).html($html);
            });
        }
        else{
            $('#wrapper-course-conversions').html($($tempSelector).html());
        }

        //$.get('/analytics/courseconversions/' + $frequency + '/' + $courseId, function ($html){
        //    $('#wrapper-course-conversions').html($html);
        //});

        $('.course-conversions-dropdown a').removeClass('active');
        $($elem).addClass('active');
        if ($frequency == 'daily'){
            $('#header-course-conversions-frequency').html(_("Today"));
        }
        else if($frequency == 'week'){
            $('#header-course-conversions-frequency').html(_("This Week"));
        }
        else if($frequency == 'month'){
            $('#header-course-conversions-frequency').html(_("This Month"));
        }
        else if($frequency == 'alltime'){
            $('#header-course-conversions-frequency').html(_("All Time"));
        }
    },
    'trackingCodeConversions' :  function ($frequency, $courseId, $elem){

        var $tempSelector = '.' + $frequency +  '-data-top-converting-tracking-codes';

        if ($($tempSelector).html() == ''){
            $.get('/analytics/trackingcodeconversions/' + $frequency + '/' + $courseId, function ($html){
                $('#wrapper-tracking-code-conversions').html($html);
                $($tempSelector).html($html);
            });
        }
        else{
            $('#wrapper-tracking-code-conversions').html($($tempSelector).html());
        }

        $('.tracking-code-conversions-dropdown a').removeClass('active');
        $($elem).addClass('active');
        if ($frequency == 'daily'){
            $('#header-tracking-code-conversions-frequency').html(_("Today"));
        }
        else if($frequency == 'week'){
            $('#header-tracking-code-conversions-frequency').html(_("This Week"));
        }
        else if($frequency == 'month'){
            $('#header-tracking-code-conversions-frequency').html(_("This Month"));
        }
        else if($frequency == 'alltime'){
            $('#header-tracking-code-conversions-frequency').html(_("All Time"));
        }

        //$.get('/analytics/trackingcodeconversions/' + $frequency + '/' + $courseId, function ($html){
        //    $('#wrapper-tracking-code-conversions').html($html);
        //});
    },

    'ltcRegistrations' :  function ($frequency, $elem){

        var $tempSelector = '.' + $frequency +  '-data-ltc-registrations';

        if ($($tempSelector).html() == ''){
            $.get('/analytics/ltcregistrations/' + $frequency, function ($html){
                $('#wrapper-ltc-registrations').html($html);
                $($tempSelector).html($html);
            });
        }
        else{
            $('#wrapper-ltc-registrations').html($($tempSelector).html());
        }


        //$.get('/analytics/ltcregistrations/' + $frequency , function ($html){
        //    $('#wrapper-ltc-registrations').html($html);
        //});

        $('.tracking-code-conversions-dropdown a').removeClass('active');
        $($elem).addClass('active');
        if ($frequency == 'daily'){
            $('#header-ltc-registrations-frequency').html(_("Today"));
        }
        else if($frequency == 'week'){
            $('#header-ltc-registrations-frequency').html(_("This Week"));
        }
        else if($frequency == 'month'){
            $('#header-ltc-registrations-frequency').html(_("This Month"));
        }
        else if($frequency == 'alltime'){
            $('#header-ltc-registrations-frequency').html(_("All Time"));
        }
    },

    'twoTierRegistrations' :  function ($frequency, $elem){

        //$.get('/analytics/second-tier-registrations/' + $frequency , function ($html){
        //});

        var $tempSelector = '.' + $frequency +  '-data-2-tier-signups';

        if ($($tempSelector).html() == ''){
            $.get('/analytics/second-tier-registrations/' + $frequency, function ($html){
                $('#wrapper-second-tier-registrations').html($html);
                $($tempSelector).html($html);
            });
        }
        else{
            $('#wrapper-second-tier-registrations').html($($tempSelector).html());
        }

        //$('#wrapper-second-tier-registrations').html('abcde');

        $('.tracking-code-conversions-dropdown a').removeClass('active');

        $($elem).addClass('active');
        if ($frequency == 'daily'){
            $('#header-second-tier-registrations-frequency').html(_("Today"));
        }
        else if($frequency == 'week'){
            $('#header-second-tier-registrations-frequency').html(_("This Week"));
        }
        else if($frequency == 'month'){
            $('#header-second-tier-registrations-frequency').html(_("This Month"));
        }
        else if($frequency == 'alltime'){
            $('#header-second-tier-registrations-frequency').html(_("All Time"));
        }
    },

    'secondTierEarnings' :  function ($frequency, $elem){

        //$.get('/analytics/second-tier-registrations/' + $frequency , function ($html){
        //});

        var $tempSelector = '.' + $frequency +  '-data-2-tier-earnings';

        if ($($tempSelector).html() == ''){
            $.get('/analytics/second-tier-earnings/' + $frequency, function ($html){
                $('#wrapper-second-tier-earnings').html($html);
                $($tempSelector).html($html);
            });
        }
        else{
            $('#wrapper-second-tier-earnings').html($($tempSelector).html());
        }

        //$('#wrapper-second-tier-registrations').html('abcde');

        //$('.tracking-code-conversions-dropdown a').removeClass('active');

        $($elem).addClass('active');
        if ($frequency == 'daily'){
            $('#header-second-tier-earnings-frequency').html(_("Today"));
        }
        else if($frequency == 'week'){
            $('#header-second-tier-earnings-frequency').html(_("This Week"));
        }
        else if($frequency == 'month'){
            $('#header-second-tier-earnings-frequency').html(_("This Month"));
        }
        else if($frequency == 'alltime'){
            $('#header-second-tier-earnings-frequency').html(_("All Time"));
        }
    },

    'ltcEarnings' :  function ($frequency, $elem){

        var $tempSelector = '.' + $frequency +  '-data-ltc--earnings';

        if ($($tempSelector).html() == ''){
            $.get('/analytics/ltcearnings/' + $frequency, function ($html){
                $('#wrapper-ltc-earnings').html($html);
                $($tempSelector).html($html);
            });
        }
        else{
            $('#wrapper-ltc-earnings').html($($tempSelector).html());
        }

        //$.get('/analytics/ltcearnings/' + $frequency , function ($html){
        //    $('#wrapper-ltc-earnings').html($html);
        //});
        $('.ltc-earnings-dropdown a').removeClass('active');
        $($elem).addClass('active');

        if ($frequency == 'daily'){
            $('#header-ltc-earnings-frequency').html(_("Today"));
        }
        else if($frequency == 'week'){
            $('#header-ltc-earnings-frequency').html(_("This Week"));
        }
        else if($frequency == 'month'){
            $('#header-ltc-earnings-frequency').html(_("This Month"));
        }
        else if($frequency == 'alltime'){
            $('#header-ltc-earnings-frequency').html(_("All Time"));
        }
    },

    'trackingCodeStats' :  function ($frequency, $courseId, $code, $elem){

        var $tempSelector = '.' + $frequency +  '-data-top-tracking-codes';

        if ($($tempSelector).html() == ''){
            $.get('/analytics/course/' + $courseId + '/trackingcode/' + $code + '/stats/' + $frequency, function ($html){
                $('#wrapper-tracking-code-stats').html($html);
                $($tempSelector).html($html);
            });
        }
        else{
            $('#wrapper-tracking-code-stats').html($($tempSelector).html());
        }

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
        //$.get('/analytics/course/' + $courseId + '/trackingcode/' + $code + '/stats/' + $frequency, function ($html){
        //    $('#wrapper-tracking-code-stats').html($html);
        //});
    }
};
