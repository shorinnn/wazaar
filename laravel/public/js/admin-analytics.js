var $ajaxLoader = $('#ajax-loader-wrapper').html();

var Analytics = {

    'activateLoader': function () {
        $('#wrapper-sales').html($ajaxLoader);
        $('#wrapper-top-courses').html($ajaxLoader);
        $('#wrapper-top-free-courses').html($ajaxLoader);
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

    'InstructorsAndStudentsSignups' : function (){

    }
}