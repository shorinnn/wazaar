/**
 * Contains form related reusable functions and event listeners
 * @class Courses 
 */
$(document).ready(function(){
    $('body').delegate('.add-module', 'click', addModule);    
    $('body').delegate('.add-lesson', 'click', addLesson);    
    
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
                    $(this).next('input.module-order').val(i);
                    $(this).next('input.module-order').trigger('change');
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
        $(this).next('input.lesson-order').val(i);
        $(this).next('input.lesson-order').trigger('change');
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
    reorderLessons( 'lessons-holder-'+json.module );
}

function enableLessonRTE(e){
    selector = '#'+$(e.target).parent().parent().parent().find('textarea').attr('id');
    tinymce.init({
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
function enableFileUploader($uploader){
    dropzone = $uploader.attr('data-dropzone');
    progressbar = $uploader.attr('data-progress-bar');
    $uploader.fileupload({
                dropZone: $(dropzone)
            }).on('fileuploadprogress', function (e, data) {
                var $progress = parseInt(data.loaded / data.total * 100, 10);
                console.log($progress);
                $(progressbar).css('width', $progress + '%');
                $(progressbar).find('span').html($progress);
                if($progress=='100') $(progressbar).find('span').html('Upload complete. Processing <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
            }).on('fileuploadfail', function (e, data) {
                $.each(data.files, function (index) {
                    var error = $('<span class="text-danger"/>').text('File upload failed.');
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                });
            }).on('fileuploaddone', function (e,data){
                callback = $uploader.attr('data-callback');
                if( typeof(callback) !=undefined ){
                    window[callback](e, data);
                }
            });
}

function enableBlockFileUploader(e){
    $uploader = $(e.target).parent().parent().parent().find('[type=file]');
    enableFileUploader($uploader);
}

function blockFileUploaded(e, data){
    $(progressbar).find('span').html('');
     $(progressbar).css('width', 0 + '%');
    result = JSON.parse(data.result);
    $(e.target).parent().parent().append(result.html);
}