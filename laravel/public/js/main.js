/**
 * Contains generic reusable functions and event listeners
 * @class Main 
 */
// JavaScript Document
$(document).ready(function(){
    $(".profile-name > li").removeClass("activate-dropdown");
    
});

/**
 * Returns a slug version of the supplied string
 * @method convertToSlug
 * @param {string} text
 * @return {string} the slug
 */
function convertToSlug(text){
     return text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
}

/**
 * Redirects the window to the specified URL
 * @method followRedirect
 * @param {object} An ovject with an URL property, usually a JSON response
 */
function followRedirect(json){
    window.location = json.url;
}


/**
 * Static unique numbers holder. Used to keep track of used numbers
 * @property unique_numbers
 * @type {Array}
 */

var unique_numbers = new Array();
/**
 * Returns a document-wide unique number
 * @method uniqueID
 * @return {Number} The unique number
 */
function uniqueId(){
    id = Math.random()*1000000;
    id = Math.ceil(id);
    while( unique_numbers.indexOf(id) != -1){
        id = Math.random()*1000000;
        id = Math.ceil(id);
        unique_numbers.push(id);
    }
    return id;
}

/**
 * Removes the hidden class of the supplied identifier and scrolls to it
 * @param {string} elem CSS selector
 */
function unhide(elem){
    $(elem).removeClass('hidden');
    $('.steps-meter').find('p.active').removeClass('active');
    $('[data-target="'+elem+'"]').addClass('active');
    $('html, body').animate({
        scrollTop: $(elem).offset().top
    }, 200);
}
