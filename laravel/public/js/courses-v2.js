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
    var i = 1;
    lessons = [];
    $('.lesson-module-'+id).each(function(){
        $(this).html(i);
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
    $('.lesson-file-uploader').each(function(){
        if( typeof( $(this).attr('data-upload-enabled') ) =='undefined' ){
            $(this).attr('data-upload-enabled', 1);
            enableFileUploader( $(this) );
        }
    });
    
}

/**
 * Enables AJAX file uploading for the specified element
 * @param {object} $uploader The file object that is ajaxified
 * @param {string} data-dropzone CSS Selector of the element to be used as the uploader's dropzone
 * @param {string} data-progress-bar CSS selector of the element to be used as the uploader's progress bar
 * @param {string} data-callback What method to run after upload is complete
 * @method enableFileUploader
 */
function enableFileUploader($uploader){
    dropzone = $uploader.attr('data-dropzone');
    var progressbar = $uploader.attr('data-progress-bar');
    var progressLabel = $(progressbar).attr('data-label');
    $progressLabel = $(progressLabel);
    upload_url = $uploader.closest('form').attr('action');
    
    var $u = $uploader;
    $u.fileupload({
                dropZone: $(dropzone)
            }).on('fileuploadadd', function (e, data) {
                $(progressbar).parent().show();
//                str =  $(progressbar).prop('outerHTML');
//                str += '<br /><br />';
//                bootbox.dialog({
//                    title: _('Uploading'),
//                    message: str
//                  });
                callback = $uploader.attr('data-add-callback');
                if( typeof(callback) !='undefined' ){
                    return window[callback](e, data);
                }
            }).on('fileuploadprogress', function (e, data) {
                 $progressLabel = $(progressLabel);
                var $progress = parseInt(data.loaded / data.total * 100, 10);
                $(progressbar).css('width', $progress + '%');
                if( $progressLabel.length > 0 ) $progressLabel.html($progress);
                else $(progressbar).find('span').html($progress);
                if($progress=='100'){
                    console.log( $progressLabel );
                    if( $progressLabel.length > 0 ) $progressLabel.html( _('Upload complete. Processing') + ' <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
                    else $(progressbar).parent().find('span').html( _('Upload complete. Processing') + ' <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
                }
            }).on('fileuploadfail', function (e, data) {
                $progressLabel = $(progressLabel);
                $(progressbar).find('span').html('');
                $(progressbar).css('width', 0 + '%');
                $.each(data.files, function (index) {
                    var error = $('<span class="alert alert-danger upload-error"/>').text( _('File upload failed.') );
                    $(progressbar).css('width', 100 + '%');
                    if( $progressLabel.length > 0 ) $progressLabel.html(error);
                    else $(progressbar).find('span').html(error);
                });
                
            }).on('fileuploaddone', function (e,data){
                callback = $uploader.attr('data-callback');
                if( typeof(callback) !=undefined ){
                    window[callback](e, data);
                    
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

//    $uploadTo = $(e.target).parent().parent().parent();
    uploadTo = $(e.target).attr('data-upload-to');
    $uploadTo = $(uploadTo);
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
        if(result.status=='success'){
            $(progressbar).find('span').html('');
            $(progressbar).css('width', 0 + '%');
    //        console.log(result);
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
        
//        bootbox.hideAll();
        
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
    $(progressbar).parent().hide();
    progressLabel = $(progressbar).attr('data-label');
    $(progressLabel).hide();
    
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


$('body').delegate('a.link-to-remote-confirm', 'click', linkToRemoteConfirm);

function linkToRemoteConfirm(e){
    e.preventDefault();
    // get the message from the clicked button, don't hard code it (so we can use localization)
    msg = $(e.target).attr('data-message');
    elem = $(e.target);
    while(typeof(msg)=='undefined'){
        elem = elem.parent();
        msg = elem.attr('data-message');
    }
    if( !confirm(msg) ) return false;
    
    var nofollow = $(e.target).attr('data-nofollow');
    if( typeof(nofollow)!='undefined'&& nofollow==1 ) return false;
    
    var loading = $(e.target).attr('data-loading');
    if( typeof(loading)!='undefined'&& loading==1 ) return false;
    
    url = $(e.target).attr('data-url');
    var callback = $(e.target).attr('data-callback');
    elem = $(e.target);
    while(typeof(url)=='undefined'){
        elem = elem.parent();
        url = elem.attr('data-url');
        callback = elem.attr('data-callback');  
        e.target = elem;
    }
    
    $(elem).attr('data-old-label', $(elem).html() );
    $(elem).html( '<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
    $.get(url, function(result){
        $(e.target).attr('data-loading', 0);
        $(elem).html( $(elem).attr('data-old-label') );
        result = JSON.parse(result);
        if(result.status == 'success' ){
            if( typeof(callback)!= 'undefined'){
                window[callback](e, result);
            }
        }
        else{
            console.log( result );
            $.bootstrapGrowl( _('An Error Occurred.'),{align:'center', type:'danger'} );
        }
    });

}
$('body').delegate('.reset-form', 'click', resetForm);
function resetForm(e){
    e.preventDefault();
    form = $(e.target).attr('data-form');
    $form = $(form);
    $form[0].reset();
}

$('body').delegate('.submit-form', 'click', submitForm);
function submitForm(e){
    e.preventDefault();
    form = $(e.target).attr('data-form');
    $form = $(form);
    $form.find('[type="submit"]').click();
//    $form[0].submit();
}

/**
 * Restores the form's submit button original label
 * @method restoreSubmitLabel
 * @param {jQuery form} $form
 */
function restoreSubmitLabel($form){
    if( typeof( $form.attr('data-save-indicator') ) !='undefined' ){
        indicator = $form.attr('data-save-indicator');
        $indicator = $(indicator);
        $indicator.html( $indicator.attr('data-old-label') );
        $indicator.removeAttr('disabled');
        return false;
    }
    
    if( typeof( $form.attr('data-no-processing') ) == 'undefined' ||  $form.attr('data-no-processing') != 1){
        $form.find('[type=submit]').html( $form.find('[type=submit]').attr('data-old-label') );
        $form.find('[type=submit]').removeAttr('disabled');
    }
    
}

$('body').delegate('.characters-left', 'keyup', charactersLeft);
function charactersLeft(e){
    elem = $(e.target);
    limit = $(elem).attr('maxlength');
    current = $(elem).val().length;
    remaining = limit - current;
    display = $(elem).attr('data-target');
    $(display).html(remaining);
}

function enableCharactersLeft(){
    $('.characters-left').each(function(){
        $(this).keyup();
    });
}

function toggleTheClass(e){
    $source = $(e.target);
    dest = $source.attr('data-target');
    cls = $source.attr('data-class');
    $(dest).toggleClass(cls);
}

function toggleVisibility(e){
    $source = $(e.target);
    dest = $source.attr('data-target');
    hide =  $source.attr('data-visible');
    if ( hide == 'hide' ) {
        $source.attr('data-visible', 'show');
        $(dest).hide();
    }
    else {
        $source.attr('data-visible', 'hide');
        $(dest).show();
    }
}

function sortablizeLsn(){
    $('.drag-lesson').each(function(){
        if( typeof( $(this).attr('data-sortablized')) =='undefined' ) {
            $(this).attr('data-sortablized', 1);
            el = $(this)[0];
            var sortable = Sortable.create( el, {
                animation: 150,
                onEnd: function (evt) {
                    console.log(evt);
                    cls = $(evt.item).attr('class');
                    $lesson = $('div.'+cls);
                    i = 0;
                    $lesson.parent().find('.shr-lesson').each(function(){
                        if(i == evt.newIndex){
                            if( evt.newIndex < evt.oldIndex ) $(this).before( $lesson );
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


$('body').delegate('.type-in-elements', 'keyup', typeInElemens);
function typeInElemens(e){
    elem = $(e.target).attr('data-elements');
    $(elem).html( $(e.target).val() );
}

function calculateFileSizes(){
    $('.calculate-file-size').each(function(){
        id = $(this).attr('data-id');
        obj = $(this);
        $.get( COCORIUM_APP_PATH+'blocks/'+id+'/size', function(result){
            result = JSON.parse(result);
            $obj = $('.calculate-file-size-'+result.id);
            console.log($obj);
            $obj.html( result.val );
            console.log( result.val );
            $obj.removeClass('calculate-file-size');
        });
    });
}

$('body').delegate('.toggle-minimize', 'click', toggleMinimize);
function toggleMinimize(e){
    if( $(e.target).hasClass('fa') ) $(e.target).toggleClass('fa-compress');
    if( typeof( $(e.target).attr('data-toggle-icon')) !='undefined' ){
        $( $(e.target).attr('data-toggle-icon') ).toggleClass('fa-compress');
    }
    
    cls = $(e.target).attr('data-class');
    target = $(e.target).attr('data-target');
    $(target).toggleClass( cls );
    console.log('toggling minimize!!!');
}


function deleteAttachment( event, result ){
    deleteItem(result, event);
    lessonId = $(event.target).attr('data-lesson');
    count = $('.uploaded-files-'+lessonId+' > li').length;
    $('.attachment-counter-'+lessonId).html(count);
}

function minimizeAfterSave(result, e){
    elem = $(e.target).attr('data-elem');
    console.log( elem+' .toggle-minimize' );
    $(elem+' .toggle-minimize').first().click();
}


$('body').delegate('.click-on-enter', 'keyup keypress', clickOnEnter);
function clickOnEnter(e){
    if( e.which == 13 ){
        if( $.trim( $(e.target).val() )  == '') return false;
        link = $(e.target).attr('data-click');
        if( e.type=='keyup'){
            $(link).click();
        }
        e.preventDefault();
        e.stopPropagation();
        return false;
    }
}