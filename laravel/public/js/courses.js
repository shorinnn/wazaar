/**
 * Contains form related reusable functions and event listeners
 * @class Courses 
 */
$(document).ready(function(){
    $('body').delegate('.add-module', 'click', addModule);    
    $('body').delegate('.add-lesson', 'click', addLesson);    
    $('body').delegate('.show-reply-form', 'click', showReplyForm);    
	activeLessonOption(); 
    
    // Make the modules list sortable
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
});

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

function enableRTE(selector){
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
}

/**
 * Called after the files tab of a lesson is loaded, it ajaxifies the file upload form
 * @param {Event} e The original event containing the calling object
 * @method enableBlockFileUploader
 */
function enableBlockFileUploader(e){
    $uploader = $(e.target).parent().parent().parent().parent().find('[type=file]');
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
    var progressbar = $(e.target).attr('data-progress-bar');
    $(progressbar).find('span').html('');
    $(progressbar).css('width', 0 + '%');
    result = JSON.parse(data.result);
    if(result.status=='error'){
//        $(e.target).closest('form').after("<p class='alert alert-danger ajax-error'>"+result.errors+'</p>');
        $(e.target).closest('form').prepend("<p class='alert alert-danger ajax-error'>"+result.errors+'</p>');
        return false;
    }
    $(e.target).parent().parent().parent().append(result.html);
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
    $('.assigned-check').remove();
    $('[name="details_displays"]').val('instructor');
    $('.display-instructor').hide();
    $('#assign-instructor').prev('label').append('<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" class="assigned-check" />');
    email = $('#assign-instructor').val();
    $.get( COCORIUM_APP_PATH+'courses/search-instructor/'+email, function(result){
        $('#assigned_instructor_id').val( parseInt(result) );
        $('.assigned-check').remove();
        if( result > 0 ){
            $('.display-instructor').show();
            $('#assign-instructor').prev('label').append('<i class="fa fa-check assigned-check"></i>');
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
    val = parseInt(e.val());
    if( val!=0 ){
        val = ( e.val() >= 500 )? e.val() : 500;
    }
    e.val( round2( val, 100 ) ) ;
}

function adjustDiscount(e){
    val = parseInt(e.val());
    kind = e.attr('data-saleType');
    kind = $("[name='"+kind+"']").val();
    if(kind=='amount' && val>0) val =  round2( val, 100 );
    e.val( val );
}