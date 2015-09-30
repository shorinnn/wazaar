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
        }
        cb(moment().subtract(29, 'days'), moment());
        var $date = new Date();
        $('#reportrange').daterangepicker({
            locale: 'jp',
            startDate: new Date($date.getFullYear(), $date.getMonth(), 1),
            endDate: new Date($date.getFullYear(), $date.getMonth() + 1, 0),
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

        });
    },
    'DateFilterStart' : '',
    'DateFilterEnd' : '',
    'ApplyTableDateFilter' : function (){

        Analytics.DateFilterStart = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
        Analytics.DateFilterEnd = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');
        Analytics.TableSiteStats();
    },

    'TableSiteStats' : function (){
        $.get('/administration/analytics/site-statistics-table/' + Analytics.DateFilterStart + '/' + Analytics.DateFilterEnd, function ($table){
            $('#table-site-stats').html($table);
        });
    }
}

$(function(){
    Analytics.ApplyFilter('today');
    Analytics.InitCalendarFilter();
});