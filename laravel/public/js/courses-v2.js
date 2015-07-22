/**
 * Contains form related reusable functions and event listeners
 * @class Courses 
 */
$(document).ready(function(){
    activatePreviewButton();
    $('body').delegate('.add-module', 'click', addModule);    
    $('body').delegate('.link-to-step-2, .link-to-step-3', 'click', saveStep1Form);    
    
    $('body').delegate('.add-lesson', 'click', addLesson);    
    $('body').delegate('.show-reply-form', 'click', showReplyForm);    
	activeLessonOption(); 
    
    // Make the modules list sortable
    sortablizeModulesAndLessons();
});

function sortablizeModulesAndLessons(){
    var el = document.getElementById('modules-list');
    if( $('#modules-list').length > 0){
        var sortable = Sortable.create(el, {
            animation: 150, 
            handle: '.sortable-handle',
            onEnd: function (evt) {
                var i = 1;
                $('span.module-order').each(function(){
                    $(this).html(i);
                    $(this).parent().parent().find('input.module-order').val(i);
                    $(this).parent().parent().find('input.module-order').trigger('change');
                    ++i;
                });
            }
        });
        
        $('.lessons').each(function(){
            sortablizeLessons( $(this).attr('id') );
        });
    }
}

/**
 * Enables Drag and Drop sorting for dynamically added lessons
 * @method sortablizeLessons
 * @param {String} id The ID of the UL element containing the list
 */
function sortablizeLessons(id){
    var el = document.getElementById(id);
    var sortable = Sortable.create(el, {
        animation: 150, 
        handle: '.sortable-handle',
        onEnd: function (evt) {
            reorderLessons(id);
        }
    });
}

function reorderModulesAndLessons(){
    var i = 1;
    $('span.module-order').each(function(){
        $(this).html(i);
        $(this).parent().parent().find('input.module-order').val(i);
        $(this).parent().parent().find('input.module-order').trigger('change');
        module_id = $(this).attr('data-module-id');
        reorderLessons( 'lessons-holder-'+module_id );
        ++i;
    });

}

/**
 * Recalculates the lesson order within the module
 * @param {String} id The ID of the UL element containing the list
 * @method reorderLessons
 */
function reorderLessons(id){
    var i = 1;
    $('#'+id+' span.lesson-order').each(function(){
        $(this).html(i);
        $(this).parent().parent().find('input.lesson-order').val(i);
        $(this).parent().parent().find('input.lesson-order').trigger('change');
        ++i;
    });
}

/**
 * Called after course creations, sets the step 2 form action attribute
 * @method prepareCourseDetails
 * @param {object} json JSON response from the create course action
 */
function prepareCourseDetails(json){
    $('#edit-course-details-form').attr( 'action', json.updateAction );
    restoreSubmitLabel( $('#create-form') );
    $('#step1').addClass('disabled-item');
    unhide('#step2');
}

/**
 * Event handler for click on .add-module<br />
 * Adds a new Module under the current course
 * @method addModule
 * @param {json} e The json response of the create module call
 */
function addModule(json){
    var destination = '#modules-list';
    var current = $('#modules-list > li').length + 1 * 1;
    var id = json.id;
    var module = json.html;
    $(destination).append(module);
    sortablizeLessons('lessons-holder-'+id);
    restoreSubmitLabel( $('#modules-form') );
    $('.step3-module-count').html( $('.new-module').length );
}

/**
 * Event handler for click on .add-lesson<br />
 * Adds a lesson under the selected module
 * @param {json} e The json response of the create module call
 * @method addLesson
 */
function addLesson(json){
    $('#lessons-holder-'+json.module).append(json.html);
    $('#lessons-holder-'+json.module+' .lesson-no-video .a-add-video').click();
    reorderLessons( 'lessons-holder-'+json.module );
    if( $('.step-2-filled').val()=='0' && $('.lesson-options').length >= 0 ) {
        $('.step-2-filled').val('1');
        updateStepsRemaining();
    }
    $('.step3-lesson-count').html( $('.new-lesson').length );
    activeLessonOption();
}

/**
 * Activates TinyMCE when the text tab of a lesson is loaded
 * @param {Event} e The event containing the calling object
 * @method enableLessonRTE
 */
function enableLessonRTE(e){
    textarea = $(e.target).parent().parent().parent().parent().find('textarea');
    selector = '#'+textarea.attr('id');
    tinymce.remove(selector);
    tinymce.init({
        menu:{},
        language: 'ja',
        language_url: COCORIUM_APP_PATH+'js/lang/tinymce/ja.js',
        autosave_interval: "20s",
        autosave_restore_when_empty: true,
        selector: selector,
        save_onsavecallback: function() {
            savingAnimation(0);
            $(selector).closest('form').submit();
            savingAnimation(1);
            return true;
        },
        
        plugins: [
            "advlist autolink autosave lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste save"
        ],
        toolbar: "save | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });
	
	var actionPanel = $(e.target).parent().parent().parent().siblings('div[class*="action-panel"]');
	var actionPanelHeight = $(actionPanel).height();
	TweenMax.fromTo(actionPanel, 0.3, {marginBottom: '40px', padding: '10px'}, {marginBottom: '0px', padding: '30px 10px 10px'});
} 

function enableRTE(selector, changeCallback){
    if( typeof(changeCallback) == 'undefined' ) changeCallback = function(){};
    tinymce.remove(selector);
    tinymce.init({
        setup : function(ed) {
                  ed.on('change', changeCallback);
            },
        menu:{},
        language: 'ja',
        language_url: COCORIUM_APP_PATH+'js/lang/tinymce/ja.js',
        autosave_interval: "20s",
        autosave_restore_when_empty: true,
        selector: selector,
        save_onsavecallback: function() {
            savingAnimation(0);
            $(selector).closest('form').submit();
            savingAnimation(1);
            return true;
        },
        
        plugins: [
            "advlist autolink autosave lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste save"
        ],
        toolbar: "bold | bullist numlist",
        statusbar: false
    });
}

/**
 * Called after the files tab of a lesson is loaded, it ajaxifies the file upload form
 * @param {Event} e The original event containing the calling object
 * @method enableBlockFileUploader
 */
function enableBlockFileUploader(e){
//    $uploader = $(e.target).parent().parent().parent().parent().find('[type=file]');
    $uploader = $(e.target).parent().parent().parent().parent().find('.lesson-file-uploader');
    console.log($uploader);
    enableFileUploader($uploader);
	
	var actionPanel = $(e.target).parent().parent().parent().siblings('div[class*="action-panel"]');
	var actionPanelHeight = $(actionPanel).height();
	TweenMax.fromTo(actionPanel, 0.3, {marginBottom: '40px'}, {marginBottom: '0px'});
}

/**
 * Called after the Video tab of a lesson is loaded, it ajaxifies the file upload form
 * 
 * 
 */
function enableVideoOption(e){
	var actionPanel = $(e.target).parent().parent().parent().siblings('div[class*="action-panel"]');
	var actionPanelHeight = $(actionPanel).height();
	TweenMax.fromTo(actionPanel, 0.3, {marginBottom: '40px'}, {marginBottom: '0px'});
}

/**
 * Called after the Settings tab of a lesson is loaded, it ajaxifies the file upload form
 * 
 * 
 */
function enableSettingOption(e){
	var actionPanel = $(e.target).parent().parent().parent().siblings('div[class*="action-panel"]');
	var actionPanelHeight = $(actionPanel).height();
	TweenMax.fromTo(actionPanel, 0.3, {marginBottom: '40px'}, {marginBottom: '0px'});
}


/**
 * Called after the lesson file has been uploaded, it resets the progress bar 
 * and includes the new object in the UI
 * @param {event} e The original event
 * @param {object} data The upload result object
 * @method blockFileUploaded
 */
function blockFileUploaded(e, data){
    lessonId = $(e.target).attr('data-lesson-id');
    var progressbar = $(e.target).attr('data-progress-bar');

    $uploadTo = $(e.target).parent().parent().parent();
//    console.log($uploadTo);

//    result = JSON.parse(data.result);
    result = xmlToJson(data.result);
    awsResponse = result;
//    console.log(result);
    $.post(COCORIUM_APP_PATH + 'lessons/blocks/'+lessonId+'/files', {
        key: result.PostResponse.Key['#text'],
        content: result.PostResponse.Location['#text']
    }, function(result){
        result = JSON.parse(result);
        $(progressbar).find('span').html('');
        $(progressbar).css('width', 0 + '%');
//        console.log(result);
        $uploadTo.append(result.html);
//        $(e.target).parent().parent().parent().append(result.html);
    });
//    if(result.status=='error'){
////        $(e.target).closest('form').after("<p class='alert alert-danger ajax-error'>"+result.errors+'</p>');
//        $(e.target).closest('form').prepend("<p class='alert alert-danger ajax-error'>"+result.errors+'</p>');
//        return false;
//    }
//    $(e.target).parent().parent().parent().append(result.html);
}

/**
 * Called before ajax uploading a lesson file, it limits the number of files that can be uploaded
 * @param {event} e The original event
 * @param {object} data The upload result object
 * @return {Boolean} False if file can't be uploaded, true otherwise
 */
function limitLessonFiles(e, data){
//    $(e.target).parent().find('.ajax-error').remove();
    $(e.target).closest('form').find('.ajax-error').remove();
    filename = $(e.target).closest('form').find('[name="key"]').attr('data-value');
    filename = filename.replace('{timestamp}--', Date.now()+'--' );
    $(e.target).closest('form').find('[name="key"]').val( filename );
    max_upload = $(e.target).attr('data-max-upload');
    if( $(e.target).parent().parent().find('.uploaded-file').length >= max_upload){
        $(e.target).after("<p class='alert alert-danger ajax-error'>"+$(e.target).attr('data-max-upload-error')+'</p>');
        return false;
    }
    return true;
}
/**
 * Called after a course preview/banner image is uploaded, it appends the new element to the list and clears the progressbar
 * @param {event} e The original event
 * @param {object} data The upload result object
 * @return {undefined}
 */
function courseImageUploaded(e, data){
    var progressbar = $(e.target).attr('data-progress-bar');
    $(progressbar).find('span').html('');
    $(progressbar).css('width', 0 + '%');
    target = $(e.target).attr('data-target');
    console.log(data.result);
    result = JSON.parse(data.result);
    $(target).append(result.html);
    $(target).find('[type=radio]').click();
    $('.course-listing-image-preview').html( result.html );
}

/**
* This call back function adds an active class to the active lesson-option link
*/

function activeLessonOption(){
	var lessonOptionButtons = $('.lesson-options .buttons a');
	lessonOptionButtons.on('click', function (e) {
		$(this).parent().parent('.lesson-options-buttons').find('.load-remote-cache').not(this).removeClass('active');
		$(this).parent().parent('.lesson-options-buttons').find('.load-remote-cache').not(this).removeClass('active-done');
		$(this).addClass('active');
		if($(this).hasClass('done')){
			$(this).removeClass('active').addClass('active-done');
		}
	});
}


function submitForApproval(result, event){
    $('#publish-status-header').html('Publish Status: Pending');
    deleteItem(result, event);
}

function assignInstructor(e){
    holder = $(e).attr('data-checkmark-holder');
    console.log(holder);
    $('.assigned-check').remove();
    $('[name="details_displays"]').val('instructor');
    $('#assign-instructor').prev('label').append('<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" class="assigned-check" />');
    email = $('#assign-instructor').val();
    $.get( COCORIUM_APP_PATH+'courses/search-instructor/'+email, function(result){
        $('#assigned_instructor_id').val( parseInt(result) );
        $('.assigned-check').remove();
        if( result > 0 ){
            $(holder).html('<i class="fa fa-check assigned-check"></i>');
        }
    });
}

function showReplyForm(e){
    $('#reply-form').attr('data-delete', $(e.target).attr('data-delete'));
    $('#reply-form-id').val( $(e.target).attr('data-id') );
    $('#reply-form-type').val( $(e.target).attr('data-type') );
    $('#reply-form-reply').val('');
    $('#reply-modal').modal('show');
}

function instructorReplied(result, event){
    deleteItem(result, event);
    $('#reply-modal').modal('hide');
}

function courseSettings(){
    $('[href="#course-edit"]').click();
}

function adjustPrice(e){
    $(e).parent().parent().find('.min-price-error').remove();
    val = parseInt(e.val());
    if( val==0 && typeof('data-allow-zero')!='undefined' ){}
    else if(  val!=0 ){
        if(val < 500){
            if(  typeof( $(e).attr('data-next-to') ) == 'undefined' )
                $(e).parent().parent().append('<p class="min-price-error alert alert-danger">' + _('min-price-500') + '</p>');
            else
                $(e).parent().append('<p class="min-price-error alert alert-danger">' + _('min-price-500') + '</p>');
        }
        val = ( e.val() >= 500 )? e.val() : 500;
    }
    else{}
    e.val( round2( val, 10 ) ) ;
}

function adjustDiscount(e){
    val = parseInt(e.val());
    kind = e.attr('data-saleType');
    kind = $("[name='"+kind+"']").val();
//    if(kind=='amount' && val>0) val =  round2( val, 10 );
    val =  round2( val, 10 );
    e.val( val );
}

function courseChangedTabs(e){
    $('.header-tabs').removeClass('active');
    $(e.target).addClass('active');
//    remaining = $(e.target).attr('data-steps-remaining');
//    if(remaining==0){
//        $('.steps-remaining').hide();
//    }
//    else{
//        $('.steps-remaining').find('span').html( _(remaining) );
//        $('.steps-remaining').show();
//    }
    // update who is for
    str = '';
    $('[name="who_is_this_for[]"]').each(function(){
       if($(this).val() != '') str += "<li>"+$(this).val()+"</li>"; 
    });
    $('.who-is-for-ul').html(str);
    // update reqs
    str = '';
    $('[name="requirements[]"]').each(function(){
       if($(this).val() != '') str += "<li>"+$(this).val()+"</li>"; 
    });
    $('.requirements-ul').html(str);
    // update by the end
    str = '';
    $('[name="what_will_you_achieve[]"]').each(function(){
       if($(this).val() != '') str += "<li>"+$(this).val()+"</li>"; 
    });
    $('.by-the-end-ul').html(str);
}

function saveAndNextTab(e){
    $('html, body').animate({
        scrollTop: $("body").offset().top
    }, 500);
    formSaved(e);
    $('.header-tabs.active').next('.header-tabs').click();
}

function saveStep1Form(){
    $('.step-1-form').attr('data-old-callback', $('.step-1-form').attr('data-callback'));
    $('.step-1-form').attr('data-callback', 'savedStep1');
    $('.step-1-form').attr('data-save-indicator', '.step-1-save-btn');
    $('.step-1-form').submit();
   
}

function savedStep1(e,json){
    $('.step-1-form').attr('data-callback', $('.step-1-form').attr('data-old-callback'));
    $('.step-1-form').removeAttr('data-old-callback');
    $('.step-1-form').removeAttr('data-save-indicator');
    savingAnimation(0);
    setTimeout(function(){
        savingAnimation(1);
    }, 1000);
}

function submittedCourse(){
    $('.header-tabs').last().removeAttr('data-loaded');
    $('.header-tabs').last().click();
    $('.submit-for-approval').attr('disabled', 'true');
    $('.submit-for-approval').addClass('disabled-button');
    
}

function updateStepsRemaining(){
    course_steps_remaining--;
    $('.steps-remaining p span span').html( course_steps_remaining );
    if( course_steps_remaining == 0){
        $('.steps-remaining p').html( '<span>' + _('Course Ready For Submission') +'</span>' );
    }
    activatePreviewButton();
}

function activatePreviewButton(){
    if( $('.step-1-filled').val()==1 && $('.step-2-filled').val()==1){
        $('.preview-course-btn').removeClass('disabled-button');
        $('.preview-course-btn').attr( 'target','_blank' );
        $('.preview-course-btn').attr( 'href', $('.preview-course-btn').attr('data-href') );
    }
}

function courseUpdateDiscount(e){
    $('.discount-ajax-result').remove();
    sale = $('[name="sale"]').val();
    sale_starts_on = $('[name="sale_starts_on"]').val();
    sale_ends_on = $('[name="sale_ends_on"]').val();
    url = $(e.target).attr('data-url');
    token = $('[name="_token"]').val();
    $.post(url, { _method:'PUT', _token:token, sale:sale, sale_starts_on:sale_starts_on, sale_ends_on:sale_ends_on }, function(result){
        result = JSON.parse(result);
        if(result.status=='success'){
            $(e.target).after("<p class='alert alert-success discount-ajax-result'>"+_('Discount Updated')+"</p>");
        }
        else{
            $(e.target).after("<p class='alert alert-danger discount-ajax-result'>"+result.errors+"</p>");
        }
    });
}

function saveStep3Form(){
    $('.step-3-form').attr('data-old-callback', $('.step-3-form').attr('data-callback'));
    $('.step-3-form').attr('data-callback', 'savedStep3');
    $('.step-3-form').attr('data-save-indicator', '.step-3-save-btn');//update already
    $('[name="publish_status"]').val(0);
    $('.step-3-form').submit();
}

function savedStep3(e,json){
    $('.step-3-form').attr('data-callback', $('.step-3-form').attr('data-old-callback'));
    $('.step-3-form').removeAttr('data-old-callback');
    $('.step-3-form').removeAttr('data-save-indicator');
    $('[name="publish_status"]').val(1);
    savingAnimation(0);
    setTimeout(function(){
        savingAnimation(1);
    }, 1000);
}

function deleteCurriculumItem( event, result ){
    console.log('DELETING ITEMZZZ');
    identifier = $(event.target).attr('data-delete');
    console.log(identifier);
    deleteItem(result, event);
    reorderModulesAndLessons();
    $('.step3-lesson-count').html( $('.new-lesson').length );
    $('.step3-module-count').html( $('.new-module').length );
}