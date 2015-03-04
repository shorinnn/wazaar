/**
 * Contains generic reusable functions and event listeners
 * @class Messages 
 */
// JavaScript Document
$(document).ready(function(){
    $('body').delegate('.load-message', 'click', loadMessage);
});

function loadMessage(e){
    $(e.target).closest('tr').removeClass('bolded');
    id = $(e.target).attr('data-row-id');
    if( $('#'+id).length==0 ){
        $(e.target).closest('tr').after("<tr id='"+id+"'><td colspan='3'></td></tr>");
        loadRemoteCache(e);
    }
    else{
        $('#'+id).slideToggle('fast');
    }
}

function postedStudentPM(e){
    history.pushState({}, '', '/private-messages');
    $('#start-pm-form').parent().parent().slideToggle();
    $.bootstrapGrowl( _('Message Sent'),{align:'center', type:'success'} );
}