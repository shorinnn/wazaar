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
                    $('#header-top-courses-frequency').html(js_translation_map.today);
                }
                else if($frequency == 'week'){
                    $('#header-top-courses-frequency').html(js_translation_map.thisWeek);
                }
                else if($frequency == 'month'){
                    $('#header-top-courses-frequency').html(js_translation_map.thisMonth);
                }
                else if($frequency == 'alltime'){
                    $('#header-top-courses-frequency').html(js_translation_map.allTime);
                }
            });
    },
    'sales' :  function ($frequency, $courseId, $trackingCode, $elem){

        Analytics.activateLoader();
        $.get('/dashboard/sales/' + $frequency + '/' + $courseId + '/' + $trackingCode, function ($html){
            $('#wrapper-sales').html($html);

            $('.sales-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-sales-frequency').html(js_translation_map.today);
                $('.with-today').trigger('click');
            }
            else if($frequency == 'week'){
                $('#header-sales-frequency').html(js_translation_map.thisWeek);
                $('.with-weekly').trigger('click');
            }
            else if($frequency == 'month'){
                $('#header-sales-frequency').html(js_translation_map.thisMonth);
                $('.with-monthly').trigger('click');
            }
            else if($frequency == 'alltime'){
                $('#header-sales-frequency').html(js_translation_map.allTime);
                $('.with-alltime').trigger('click');
            }
            if ($('#wrapper-tracking-codes-table').length == 1) {
                Analytics.trackingCodeTable($frequency, $courseId);
            }
        });
    },

    'trackingCodeTable' : function ($frequency, $courseId){

        $.get('/dashboard/trackingcodetable/' + $frequency + '/' + $courseId, function ($html){
            $('#wrapper-tracking-codes-table').html($html);
        });
    },

    'trackingSalesCodes' :  function ($frequency, $courseId, $elem){

        $.get('/dashboard/trackingcodessales/' + $frequency + '/' + $courseId, function ($html){
            $('#wrapper-tracking-codes').html($html);

            $('.tracking-codes-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-tracking-codes-frequency').html(js_translation_map.today);
            }
            else if($frequency == 'week'){
                $('#header-tracking-codes-frequency').html(js_translation_map.thisWeek);
            }
            else if($frequency == 'month'){
                $('#header-tracking-codes-frequency').html(js_translation_map.thisMonth);
            }
            else if($frequency == 'alltime'){
                $('#header-tracking-codes-frequency').html(js_translation_map.allTime);
            }
        });
    },
    'courseConversions' :  function ($frequency, $courseId, $elem){

        $.get('/dashboard/courseconversions/' + $frequency + '/' + $courseId, function ($html){
            $('#wrapper-course-conversions').html($html);

            $('.course-conversions-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-course-conversions-frequency').html(js_translation_map.today);
            }
            else if($frequency == 'week'){
                $('#header-course-conversions-frequency').html(js_translation_map.thisWeek);
            }
            else if($frequency == 'month'){
                $('#header-course-conversions-frequency').html(js_translation_map.thisMonth);
            }
            else if($frequency == 'alltime'){
                $('#header-course-conversions-frequency').html(js_translation_map.allTime);
            }
        });
    },
    'trackingCodeConversions' :  function ($frequency, $courseId, $elem){

        $.get('/dashboard/trackingcodeconversions/' + $frequency + '/' + $courseId, function ($html){
            $('#wrapper-tracking-code-conversions').html($html);

            $('.tracking-code-conversions-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-tracking-code-conversions-frequency').html(js_translation_map.today);
            }
            else if($frequency == 'week'){
                $('#header-tracking-code-conversions-frequency').html(js_translation_map.thisWeek);
            }
            else if($frequency == 'month'){
                $('#header-tracking-code-conversions-frequency').html(js_translation_map.thisMonth);
            }
            else if($frequency == 'alltime'){
                $('#header-tracking-code-conversions-frequency').html(js_translation_map.allTime);
            }
        });
    },

    'ltcRegistrations' :  function ($frequency, $elem){

        $.get('/dashboard/ltcregistrations/' + $frequency , function ($html){
            $('#wrapper-ltc-registrations').html($html);

            $('.tracking-code-conversions-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-ltc-registrations-frequency').html(js_translation_map.today);
            }
            else if($frequency == 'week'){
                $('#header-ltc-registrations-frequency').html(js_translation_map.thisWeek);
            }
            else if($frequency == 'month'){
                $('#header-ltc-registrations-frequency').html(js_translation_map.thisMonth);
            }
            else if($frequency == 'alltime'){
                $('#header-ltc-registrations-frequency').html(js_translation_map.allTime);
            }
        });
    },

    'trackingCodeStats' :  function ($frequency, $courseId, $code, $elem){

        $.get('/dashboard/course/' + $courseId + '/trackingcode/' + $code + '/stats/' + $frequency, function ($html){
            $('#wrapper-tracking-code-stats').html($html);

            $('.tracking-code-hits-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-tracking-codes-frequency').html(js_translation_map.today);

            }
            else if($frequency == 'week'){
                $('#header-tracking-codes-frequency').html(js_translation_map.thisWeek);
            }
            else if($frequency == 'month'){
                $('#header-tracking-codes-frequency').html(js_translation_map.thisMonth);
            }
            else if($frequency == 'alltime'){
                $('#header-tracking-codes-frequency').html(js_translation_map.allTime);
            }
        });
    }
};
