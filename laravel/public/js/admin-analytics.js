var $ajaxLoader = $('#ajax-loader-wrapper').html();

var Analytics = {

    'activateLoader': function () {
        $('#wrapper-total-signups-student-instructors').html($ajaxLoader);
        $('#wrapper-total-revenues').html($ajaxLoader);
        $('#wrapper-total-signups-affiliates').html($ajaxLoader);
    },

    'InstructorsAndStudentsSignups' : function ($frequency){

        $.get('/administration/analytics/instructor-student-sign-ups/' + $frequency, function($html){
            $('#wrapper-total-signups-student-instructors').html($html);
        });

        if ($frequency == 'today'){
            $('#header-total-signups-student-instructors-frequency').html(_("Today"));
        }
        else if($frequency == 'week'){
            $('#header-total-signups-student-instructors-frequency').html(_("This Week"));
        }
        else if($frequency == 'month'){
            $('#header-total-signups-student-instructors-frequency').html(_("This Month"));
        }
        else if($frequency == 'alltime'){
            $('#header-total-signups-student-instructors-frequency').html(_("All Time"));
        }
    },

    'AffiliateSignups' : function ($frequency){

        if ($frequency == 'today'){
            $('#header-total-signups-affiliates-frequency').html(_("Today"));
        }
        else if($frequency == 'week'){
            $('#header-total-signups-affiliates-frequency').html(_("This Week"));
        }
        else if($frequency == 'month'){
            $('#header-total-signups-affiliates-frequency').html(_("This Month"));
        }
        else if($frequency == 'alltime'){
            $('#header-total-signups-affiliates-frequency').html(_("All Time"));
        }

        $.get('/administration/analytics/affiliate-sign-ups/' + $frequency, function($html){
            $('#wrapper-total-signups-affiliates').html($html);
        });

    },

    'Revenues' : function ($frequency){

        if ($frequency == 'today'){
            $('#header-total-revenues-frequency').html(_("Today"));
        }
        else if($frequency == 'week'){
            $('#header-total-revenues-frequency').html(_("This Week"));
        }
        else if($frequency == 'month'){
            $('#header-total-revenues-frequency').html(_("This Month"));
        }
        else if($frequency == 'alltime'){
            $('#header-total-revenues-frequency').html(_("All Time"));
        }

        $.get('/administration/analytics/sales/' + $frequency, function($html){
            $('#wrapper-total-revenues').html($html);
        });
    },
    'ApplyFilter' : function ($frequency){
        Analytics.activateLoader();
        Analytics.InstructorsAndStudentsSignups($frequency);
        Analytics.AffiliateSignups($frequency);
        Analytics.Revenues($frequency);
        $('.button-filter').removeClass('btn-primary');
        $('.button-filter').removeClass('active');
        $('.button-filter-' + $frequency).addClass('btn-primary');
    },
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
    'DateFilterStart' : '',
    'DateFilterEnd' : '',
    'ApplyTableDateFilter' : function (){

        //Analytics.DateFilterStart = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //Analytics.DateFilterEnd = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');
        Analytics.TableSiteStats();
        Analytics.TableSalesStats();
        Analytics.TableTopCourses();
        Analytics.TableTopAffiliates();
    },

    'TableSiteStats' : function (){

        $.get('/administration/analytics/site-statistics-table/' + Analytics.DateFilterStart + '/' + Analytics.DateFilterEnd, function ($table){
            $('#table-site-stats').html($table);
        });
    },
    'TableSalesStats' : function (){

        $.get('/administration/analytics/sales-statistics-table/' + Analytics.DateFilterStart + '/' + Analytics.DateFilterEnd, function ($table){
            $('#table-sales-stats').html($table);
        });
    },
    'TableTopCourses' : function (){

        $.get('/administration/analytics/top-courses-table/' + Analytics.DateFilterStart + '/' + Analytics.DateFilterEnd, function ($table){
            $('#table-top-courses').html($table);
        });
    },

    'TableTopAffiliates' : function (){

        $.get('/administration/analytics/top-affiliates-table/' + Analytics.DateFilterStart + '/' + Analytics.DateFilterEnd, function ($table){
            $('#table-top-affiliates').html($table);
        });
    }
}

$(function(){

    $('#table-site-stats').on('click','a', function ($e){
        $e.preventDefault();
        showLoading();
        var $url = $(this).attr('href');
        $.get($url, function ($table){
            hideLoading();
            $('#table-site-stats').html($table);
        });
    });

    $('#table-sales-stats').on('click','a', function ($e){
        $e.preventDefault();
        showLoading();
        var $url = $(this).attr('href');
        $.get($url, function ($table){
            hideLoading();
            $('#table-sales-stats').html($table);
        });
    });

    $('#table-top-courses').on('click','a', function ($e){
        $e.preventDefault();
        showLoading();
        var $url = $(this).attr('href');
        $.get($url, function ($table){
            hideLoading();
            $('#table-top-courses').html($table);
        });
    });

    $('#table-top-affiliates').on('click','a', function ($e){
        $e.preventDefault();
        showLoading();
        var $url = $(this).attr('href');
        $.get($url, function ($table){
            hideLoading();
            $('#table-top-affiliates').html($table);
        });
    });

    Analytics.ApplyFilter('today');
    Analytics.InitCalendarFilter();
    Analytics.ApplyTableDateFilter();
});