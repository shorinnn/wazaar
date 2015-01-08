/**
 * Contains form related reusable functions and event listeners
 * @class Courses 
 */

/**
 * Called after course creations, sets the step 2 form action attribute
 * @method prepareCourseDetails
 * @param {type} json
 */
function prepareCourseDetails(json){
    $('#step1').hide();
    $('#edit-course-details-form').attr( 'action', json.updateAction );
    unhide('#step2');
}
