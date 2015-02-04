var Analytics = {
    'topCourses' :  function ($frequency, $elem){
            $.get('dashboard/topcourses/' + $frequency, function ($html){
                $('#wrapper-top-courses').html($html);

                $('.top-courses-dropdown a').removeClass('active');
                $($elem).addClass('active');
                if ($frequency == 'daily'){
                    $('#header-top-courses-frequency').html('Today');
                }
                else if($frequency == 'week'){
                    $('#header-top-courses-frequency').html('This Week');
                }
                else if($frequency == 'month'){
                    $('#header-top-courses-frequency').html('This Month');
                }
                else if($frequency == 'alltime'){
                    $('#header-top-courses-frequency').html('All Time');
                }
            });
    },
    'sales' :  function ($frequency, $elem){
        $.get('dashboard/sales/' + $frequency, function ($html){
            $('#wrapper-sales').html($html);

            $('.sales-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-sales-frequency').html('Today');
            }
            else if($frequency == 'week'){
                $('#header-sales-frequency').html('This Week');
            }
            else if($frequency == 'month'){
                $('#header-sales-frequency').html('This Month');
            }
            else if($frequency == 'alltime'){
                $('#header-sales-frequency').html('All Time');
            }
        });
    },
    'trackingSalesCodes' :  function ($frequency, $elem){
        $.get('dashboard/trackingcodessales/' + $frequency, function ($html){
            $('#wrapper-tracking-codes').html($html);

            $('.tracking-codes-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-tracking-codes-frequency').html('Today');
            }
            else if($frequency == 'week'){
                $('#header-tracking-codes-frequency').html('This Week');
            }
            else if($frequency == 'month'){
                $('#header-tracking-codes-frequency').html('This Month');
            }
            else if($frequency == 'alltime'){
                $('#header-tracking-codes-frequency').html('All Time');
            }
        });
    },
    'courseConversions' :  function ($frequency, $elem){
        $.get('dashboard/courseconversions/' + $frequency, function ($html){
            $('#wrapper-course-conversions').html($html);

            $('.course-conversions-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-course-conversions-frequency').html('Today');
            }
            else if($frequency == 'week'){
                $('#header-course-conversions-frequency').html('This Week');
            }
            else if($frequency == 'month'){
                $('#header-course-conversions-frequency').html('This Month');
            }
            else if($frequency == 'alltime'){
                $('#header-course-conversions-frequency').html('All Time');
            }
        });
    },
    'trackingCodeConversions' :  function ($frequency, $elem){
        $.get('dashboard/trackingcodeconversions/' + $frequency, function ($html){
            $('#wrapper-tracking-code-conversions').html($html);

            $('.tracking-code-conversions-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'daily'){
                $('#header-tracking-code-conversions-frequency').html('Today');
            }
            else if($frequency == 'week'){
                $('#header-tracking-code-conversions-frequency').html('This Week');
            }
            else if($frequency == 'month'){
                $('#header-tracking-code-conversions-frequency').html('This Month');
            }
            else if($frequency == 'alltime'){
                $('#header-tracking-code-conversions-frequency').html('All Time');
            }
        });
    }
};
