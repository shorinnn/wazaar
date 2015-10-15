/**
 * Contains form related reusable functions and event listeners
 * @class Courses 
 */
var form1Changed = form3Changed = false;
$(document).ready(function(){
    activatePreviewButton();
    $('body').delegate('#edit-course-form :input', 'change', function(){
      form1Changed = true;
    });
    
    $('body').delegate('#edit-course-form-s3 :input', 'change', function(){
      form3Changed = true;
    });
    
    $('body').delegate('.add-module', 'click', addModule);    
//    $('body').delegate('.link-to-step-2, .link-to-step-3', 'click', saveStep1Form);    
    
    $('body').delegate('.add-lesson', 'click', addLesson);    
    $('body').delegate('.show-reply-form', 'click', showReplyForm);    
    $('body').delegate('a.toggle-minimize, button.toggle-minimize, .module-minimized div.toggle-minimize.module-data, .lesson-minimized div.toggle-minimize.lesson-data ', 'click', toggleMinimize);
	activeLessonOption(); 
    
    // Make the modules list sortable
    sortablizeModulesAndLessons();
});

function sortablizeModulesAndLessons(){
    var el = document.getElementById('modules-list');
    if( $('#modules-list').length > 0){
        var sortable = Sortable.create(el, {
            group: 'modules',
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
        group: 'lessons',
        animation: 150, 
        handle: '.sortable-handle',
        onEnd: function (evt) {
            reorderLessons(id);
        }
    });
}

function reorderModulesAndLessons(){
    var i = 1;
    var modules = [];
    var lessons = [];
    $('span.module-order').each(function(){
        $(this).html(i);
        id = $(this).attr('data-id');
        modules.push( id );
        l = reorderLessons( id );
        lessons.push(  { module:id, lessons: l} );
        ++i;
    });
    id = $('.course-id').val();
    $.post( COCORIUM_APP_PATH+'courses/'+id+'/reorder', { modules:modules, lessons:lessons }, function(result){
        console.log(result);
    });
    return true;
}

/**
 * Recalculates the lesson order within the module
 * @param {String} id The ID of the UL element containing the list
 * @method reorderLessons
 */
function reorderLessons(id){
    lessons = [];
    var i = 1;
    $('.shr-editor-module-'+id+' .lesson-order').each(function(){
            $(this).html(i);
            ++i;
    });
    
    var i = 1;
    $('.shr-editor-module-'+id+' .lesson-li').each(function(){
        id = $(this).attr('data-id');
        lessons.push( id );
        ++i;
    });
    return lessons;
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
    var destination = '.module-container';
    var module = json.html;
    $(destination).append(module);
    restoreSubmitLabel( $('#modules-form') );
    $('.drag-module').append( json.li );
    $('.step3-module-count').html( $('.new-module').length );
//    var id = json.id;
}

/**
 * Event handler for click on .add-lesson<br />
 * Adds a lesson under the selected module
 * @param {json} e The json response of the create module call
 * @method addLesson
 */
function addLesson(json){
    $('div.shr-editor-module-'+json.module+' .lesson-container').append(json.html);
    $('li.shr-editor-module-'+json.module+' ol').append(json.li);
   
    $('.step3-lesson-count').html( $('.new-lesson').length );
    
    if( $('.step-2-filled').val()=='0' ) {
        $('.step-2-filled').val('1');
        updateStepsRemaining();
    }
    enableBlockFileUploader();
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
         paste_as_text: true,
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


/**
 * Called after the files tab of a lesson is loaded, it ajaxifies the file upload form
 * @param {Event} e The original event containing the calling object
 * @method enableBlockFileUploader
 */
function enableBlockFileUploader(e){
//    $uploader = $(e.target).parent().parent().parent().parent().find('[type=file]');
    $('.lesson-file-uploader').each(function(){
        if( typeof( $(this).attr('data-upload-enabled') ) =='undefined' ){
            $(this).attr('data-upload-enabled', 1);
            enableFileUploader( $(this) );
        }
    });
    
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
    progressLabel = $(progressbar).attr('data-label');
    var $progressLabel = $(progressLabel);

    uploadTo = $(e.target).attr('data-upload-to');
    $uploadTo = $(uploadTo);

    result = xmlToJson(data.result);
    awsResponse = result;
    $.post(COCORIUM_APP_PATH + 'lessons/blocks/'+lessonId+'/files', {
        key: result.PostResponse.Key['#text'],
        content: result.PostResponse.Location['#text']
    }, function(result){
        result = JSON.parse(result);
        if(result.status=='success'){
            $(progressbar).find('span').html('');
            $(progressbar).css('width', 0 + '%');
            $uploadTo.append(result.html);
            $(progressbar).parent().hide();
            $progressLabel.html('');
            calculateFileSizes();
            count = $('.uploaded-files-'+lessonId+' > li').length;
            $('.attachment-counter-'+lessonId).html(count);
            $('.shr-lesson-'+lessonId+' .uploaded-files').show();
            $('.shr-lesson-'+lessonId+' .uploader-area ').addClass('col-lg-3');
            $('.shr-lesson-'+lessonId+' .uploader-area ').addClass('col-md-3');
            $('.shr-lesson-'+lessonId+' .uploader-area ').addClass('col-sm-3');
        }
        else{
            $(progressbar).find('span').html( result.errors );
            $(progressbar).css('width', 0 + '%');
            $progressLabel.html(result.errors );
        }
       
    });
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
    $(progressbar).parent().hide();
    progressLabel = $(progressbar).attr('data-label');
    $(progressLabel).hide();
    
    target = $(e.target).attr('data-target');
    console.log(data.result);
    result = JSON.parse(data.result);
    $(target).append(result.option);
    insertSelectBorder();
//    $(target).find('[type=radio]').last().click();
//    $(target).find('.select-border').last().click();
//    $(target).find('.select-border').last().click();
    $('.image-thumb-box input:radio').last().click();
    $('.course-listing-image-preview').html( result.html );
    $('.listing-image-upload ').addClass('resource-uploaded');
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
    val =  round2( val, 10 );
    e.val( val );
}

function courseChangedTabs(e){
    $('.header-tabs').removeClass('active');
    $(e.target).addClass('active');
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

var editorStepSubmit = true;
function saveAndNextTab(e){
    $('html, body').animate({
        scrollTop: $("body").offset().top
    }, 500);
//    formSaved(e);
//    editorStepSubmit = false;
    $('.header-tabs.active').next('.header-tabs').click();
//    $form = $('');
//    restoreSubmitLabel( $form );
}

function saveStep1Form(){
    if( editorStepSubmit==true  ){
        if( $('.step-1-form').parsley().isValid() ){
            $('.step-1-form').attr('data-old-callback', $('.step-1-form').attr('data-callback'));
            $('.step-1-form').attr('data-callback', 'savedStep1');
            $('.step-1-form').attr('data-save-indicator', '.step-1-save-btn');
        }
        $('.step-1-form').submit();
        form1Changed = false;
    }
    else editorStepSubmit = true;
}

function savedStep1(e,json){
    $('.step-1-form').attr('data-callback', $('.step-1-form').attr('data-old-callback'));
    $('.step-1-form').removeAttr('data-old-callback');
    $('.step-1-form').removeAttr('data-save-indicator');
    console.log(json);
//    savingAnimation(0);
//    setTimeout(function(){
//        savingAnimation(1);
//    }, 1000);
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
    form3Changed = false;
}

function savedStep3(e,json){
    $('.step-3-form').attr('data-callback', $('.step-3-form').attr('data-old-callback'));
    $('.step-3-form').removeAttr('data-old-callback');
    $('.step-3-form').removeAttr('data-save-indicator');
    $('[name="publish_status"]').val(1);
//    savingAnimation(0);
//    setTimeout(function(){
//        savingAnimation(1);
//    }, 1000);
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


function sortablizeLsn(){
    $('.drag-lesson').each(function(){
        if( typeof( $(this).attr('data-sortablized')) =='undefined' ) {
            $(this).attr('data-sortablized', 1);
            el = $(this)[0];
            var sortable = Sortable.create( el, {
                group: 'lessons-drag',
                animation: 150,
                onEnd: function (evt) {
                    console.log(evt);
                    cls = $(evt.item).attr('class');
                    $lesson = $('div.'+cls);
                    i = 0;
                    module = $(evt.item).parent().attr('data-module-id');

                    console.log('MODULE IS: '+module);
                    console.log(evt.newIndex);
//                    $lesson.parent().find('.shr-lesson').each(function(){
                    if(evt.newIndex >= $('.shr-editor-module-'+module).find('.shr-lesson').length){
                        $('.shr-editor-module-'+module).find('.shr-lesson').last().after( $lesson );
                    }
                    
                    $('.shr-editor-module-'+module).find('.shr-lesson').each(function(){
                        if(i == evt.newIndex){
                            if( evt.newIndex <= evt.oldIndex ) $(this).before( $lesson );
                            else $(this).after( $lesson );
                        }
                        ++i;
                    });
                    reorderModulesAndLessons();
                }
            });
        }
    });
}

function sortablizeMdl(){
    $('.drag-module').each(function(){
        if( typeof( $(this).attr('data-sortablized')) =='undefined' ) {
            $(this).attr('data-sortablized', 1);
            el = $(this)[0];
            var sortable = Sortable.create( el, {
                group: 'modules-drag',
                animation: 150,
                onEnd: function (evt) {
                    console.log(evt);
                    cls = $(evt.item).attr('class');
                    $module = $('div.'+cls);
                    i = 0;
                    $module.parent().find('.shr-editor-module').each(function(){
                        if(i == evt.newIndex){
                            if( evt.newIndex < evt.oldIndex ) $(this).before( $module );
                            else $(this).after( $module );
                        }
                        ++i;
                    });
                    reorderModulesAndLessons();
                }
            });
        }
    });
}

function toggleMinimize(e){
    if( $(e.target).hasClass('fa') ) $(e.target).toggleClass('fa-compress');
    
    toggleIcon = $(e.target).attr('data-toggle-icon');
    
    cls = $(e.target).attr('data-class');
    target = $(e.target).attr('data-target');
    
    elem = $(e.target);
    tries = 0;
    var fromChild = false;
    while( typeof(cls)=='undefined'){
        elem = elem.parent();
        cls = elem.attr('data-class');
        target = $(elem).attr('data-target');
        toggleIcon = $(elem).attr('data-toggle-icon');
        console.log( target );
        tries ++;
        fromChild = true;
        if( tries > 50) break;
    }
    e.preventDefault();
    e.stopPropagation();
    console.log( $(target).hasClass(cls) );
    console.log( $(target) );
    // dont minimize when clicking inside the box
    if(fromChild && !$(target).hasClass(cls)){
        console.log('FROM CHILD');
        return false;
    }
    
    $(target).toggleClass( cls );
    console.log('toggling minimize!!!');
    if( typeof( toggleIcon ) !='undefined' ){
        $(toggleIcon).toggleClass('fa-compress');
    }
}

function deleteAttachment( event, result ){
    deleteItem(result, event);
    lessonId = $(event.target).attr('data-lesson');
    count = $('.uploaded-files-'+lessonId+' > li').length;
    $('.attachment-counter-'+lessonId).html(count);
    
    $('.shr-lesson-'+lessonId+' .uploaded-files').hide();
    $('.shr-lesson-'+lessonId+' .uploader-area ').removeClass('col-lg-3');
    $('.shr-lesson-'+lessonId+' .uploader-area ').removeClass('col-md-3');
    $('.shr-lesson-'+lessonId+' .uploader-area ').removeClass('col-sm-3');
}

function minimizeAfterSave(result, e){
    elem = $(e.target).attr('data-elem');
    console.log( elem+' .toggle-minimize' );
    $(elem+' a.toggle-minimize').first().click();
}
