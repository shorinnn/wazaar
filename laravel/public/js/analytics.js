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
    }
};
