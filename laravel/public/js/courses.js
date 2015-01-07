function createCourse(){
    $.post('/courses',{ name:$('#name').val(), _token : _globalObj._token },function(result){
        console.log(result);
        unhide('#step2');
    });   
}
function unhide(elem){
    $(elem).removeClass('hidden');
    $('html, body').animate({
        scrollTop: $(elem).offset().top
    }, 200);
}

$('body').delegate('.ajax-form', 'submit', ajaxForm);

function ajaxForm(e){
    form = $(e.target);
    form.find('.ajax-errors').remove();
    $.post(form.attr('action'), form.serialize(), function(result){
        result = JSON.parse(result);
        if(result.status=='error'){
            form.append('<p class="alert alert-danger ajax-errors">'+result.errors+'</p>');
            restoreSubmitLabel(form);
            return false;
        }
        if( typeof(form.attr('data-callback'))!='undefined' ){
            window[form.attr('data-callback')](result);
        }
    });
    return false;
}

function prepareCourseDetails(json){
    $('#step1').hide();
    $('#edit-course-details-form').attr( 'action', json.updateAction );
    unhide('#step2');
}
var zzz;
function populateDropdown(elem){
    target = $(elem).attr('data-target');
    target = $(target);
    target.empty();
    var o = new Option( 'loading...', 'loading...' );
    $(o).html( 'loading...' );
    target.append(o);
    target.attr('disabled', true);
    $.get( $(elem).attr('data-url'),{id:$(elem).val()}, function(result){
        target.empty();
        for(i=0; i<result.length; ++i){
            console.log( result[i] );
            var o = new Option( result[i].name, result[i].id );
            $(o).html( result[i].name );
            target.append(o);
        }
        target.attr('disabled', false);
    });
    return;    
}