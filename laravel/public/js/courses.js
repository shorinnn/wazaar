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