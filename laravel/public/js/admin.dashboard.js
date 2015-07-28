var AdminDashboard = {
    'UserStats' : function ($frequency, $elem){
        $.get('/dashboard/users/count/' + $frequency , function ($html){
            $('#wrapper-user-stats').html($html);

            $('.top-courses-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'today'){
                $('#header-user-stats-frequency').html(_("Today"));
            }
            else if($frequency == 'week'){
                $('#header-user-stats-frequency').html(_("This Week"));
            }
            else if($frequency == 'month'){
                $('#header-user-stats-frequency').html(_("This Month"));
            }
            else if($frequency == 'alltime'){
                $('#header-user-stats-frequency').html(_("All Time"));
            }
        });
    },
    'SalesCount' : function ($frequency, $elem){
        $.get('/dashboard/admin/sales/count/' + $frequency , function ($html){
            $('#wrapper-sales-count').html($html);

            $('.top-courses-dropdown a').removeClass('active');
            $($elem).addClass('active');
            if ($frequency == 'today'){
                $('#header-sales-count-frequency').html(_("Today"));
            }
            else if($frequency == 'week'){
                $('#header-sales-count-frequency').html(_("This Week"));
            }
            else if($frequency == 'month'){
                $('#header-sales-count-frequency').html(_("This Month"));
            }
            else if($frequency == 'alltime'){
                $('#header-sales-count-frequency').html(_("All Time"));
            }
        });
    }
};