/**
 * Contains generic reusable functions and event listeners
 * @class Main 
 */
// JavaScript Document
$(document).ready(function(){
    $(".profile-name > li").removeClass("activate-dropdown");
    $('body').delegate('.slide-toggler', 'click', slideToggle);
    $('body').delegate('a.load-remote', 'click', loadRemote);
    $('body').delegate('a.load-more-ajax', 'click', loadMoreComments);
    $('body').delegate('a.load-remote-cache', 'click', loadRemoteCache);
    $(window).scroll(stepsScrollAnimation);
    _.setTranslation( js_translation_map );
    floatingNav();
    scrollNavigation();
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
    $(elem).css('opacity','0');
    $('.steps-meter').find('p.active').removeClass('active');
    $('[data-target="'+elem+'"]').addClass('active');

    $(elem).animate({
        opacity:1
    }, 1000);
    val = $(elem).prev('.animated-step').outerHeight(true);
    console.log(val);
    $(elem).prev('.animated-step').animate({
        opacity: 0,
        marginTop: -val
    }, 1000, function(){
        $(elem).prev('.animated-step').hide();
    });
}

function reverseUnhide(){
    elem = '#'+$('.animated-step:visible').attr('id');
    if(elem=='#step1') return false;
    prev = '#'+$(elem).prev('.animated-step').attr('id');
    console.log(prev);
    $('.steps-meter').find('p.active').removeClass('active');
    $('[data-target="'+prev+'"]').addClass('active');

    $(elem).animate({
        opacity:0
    }, 1000, function(){
        $(elem).addClass('hidden');
    });
    
   
    $(elem).prev('.animated-step').show();
    $(elem).prev('.animated-step').animate({
        opacity: 1,
        marginTop: 0
    }, 1000, function(){
        
    });
}

/**
 * Slide toggles an element defined by the caller's data-target attribute
 * @method slideToggle
 * @param {event} e The click event
 */
function slideToggle(e){
    e.preventDefault();
    target = $(e.target).attr('data-target');
    $(target).slideToggle('fast', function(){
        var callback = $(e.target).attr('data-callback');
        if( typeof(callback)!= 'undefined'){
            window[callback](e);
        }
    });
}

/**
 * Event handler for a.load-remote<br />
 * It loads the resource specified at data-url into the element specified at data-target
 * @param {event} e Click event
 * @method loadRemote
 */
function loadRemote(e){
    e.preventDefault();
    url = $(e.target).attr('data-url');
    target = $(e.target).attr('data-target');
    var callback = $(e.target).attr('data-callback');
    elem = $(e.target);
    loadMethod = $(e.target).attr('data-load-method');
    while(typeof(url)=='undefined'){
        elem = elem.parent();
        url = elem.attr('data-url');
        target = elem.attr('data-target');
        callback = elem.attr('data-callback');  
        loadMethod = $(e.target).attr('data-load-method');
    }
    
    if(typeof(loadMethod)=='undefined' || loadMethod=='load'){
        $(target).html( _('loading...') + '<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
        $(target).load(url, function(){
            if( typeof(callback)!= 'undefined'){
                window[callback](e);
            }
        });
    }
    else if(loadMethod=='append' || loadMethod=='prepend'){
        $(target).prepend('<p class="remove_this">' + _('loading...') + '<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></p>');
        $.get(url, function(data){
            $('.remove_this').remove();
            if(loadMethod=='append') $(target).append(data);
            else $(target).prepend(data);
            if( typeof(callback)!= 'undefined'){
                window[callback](e);
            }
        });
    }
    else{}
}

function loadMoreComments(e){    
    e.preventDefault();
    url = $(e.target).attr('data-url');
    target = $(e.target).attr('data-target');
    skip = $(e.target).attr('data-skip');
    lesson = $(e.target).attr('data-lesson');
    elem = $(e.target);
    while(typeof(url)=='undefined'){
        elem = elem.parent();
        url = elem.attr('data-url');
        target = elem.attr('data-target');
        callback = elem.attr('data-callback');  
    }
    $(e.target).html( _('Loading...') + '<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
    $.post(url,{lesson:lesson, skip:skip}, function(data) {
        $(e.target).attr('href','#');
        $(e.target).html( _('LOAD MORE') );
        if($.trim(data)==''){
            $(e.target).removeClass('load-more-ajax');
            $(e.target).html( _('No more messages') );
        }
        $(target).append(data).fadeIn('slow');
        skip = 1 * skip + 1 * 2;
        $(e.target).attr('data-skip', skip);
        
    });
}

/**
 * Similar to loadRemote, it loads the resource, but only once, later requests just display the content already loaded
 * @param {event} e Click event
 * @method loadRemoteCache
 */
function loadRemoteCache(e){
    e.preventDefault();
    url = $(e.target).attr('data-url');
    target = $(e.target).attr('data-target');
    var callback = $(e.target).attr('data-callback');
    elem = $(e.target);
    while(typeof(url)=='undefined'){
        elem = elem.parent();
        url = elem.attr('data-url');
        target = elem.attr('data-target');
        callback = elem.attr('data-callback');  
    }
    // load content from the parent container
    $(target).parent().children().hide();
    $(target).show();
    
    if(elem.attr('data-loaded') == '1' ) return false;// content already loaded, just redisplay it
    
    $(target).html( _('loading...') + '<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
    $(target).load(url, function(){
        elem.attr('data-loaded','1');
        if( typeof(callback)!= 'undefined'){
            window[callback](e);
        }
    });
}


scrollAnimationActivated = true;
function stepsScrollAnimation(){
   if($('.animated-step').length==0) return false;
   if(!scrollAnimationActivated) return false;
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
       scrollAnimationActivated = false;
       $('.animated-step:visible').find('.unhide-btn').click();
       setTimeout(function(){
           scrollAnimationActivated = true;
       },2000);
       return false;    
   }
   if($(window).scrollTop() == 0) {
       scrollAnimationActivated = false;
       reverseUnhide();
       setTimeout(function(){
           scrollAnimationActivated = true;
       },2000);
   }
}

/**
 * This function fixes the navigation menu at the top of the page
 * on scroll.
 */
function floatingNav(){
    // this checks the current top position of the nav and stores it in a variable.
    if( $(".main-nav-section").length == 0 )return false;
    var max_scroll = $(".main-nav-section").position().top;
    $(window).scroll(function () {
        var navbar = $(".main-nav-section");

        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        if (scrollTop > max_scroll && !navbar.is(".filterbuttonFixed")) {
            navbar.addClass("filterbuttonFixed");
        }
        else if (scrollTop < max_scroll && navbar.is(".filterbuttonFixed")) {
            navbar.removeClass("filterbuttonFixed");
        }

    });

}

// Function for sliding to each section when nav button is clicked
function scrollNavigation(){
    $('a[href*=#]').each(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
            && location.hostname == this.hostname
            && this.hash.replace(/#/,'') ) {
                var $targetId = $(this.hash), $targetAnchor = $('[name=' + this.hash.slice(1) +']');
                var $target = $targetId.length ? $targetId : $targetAnchor.length ? $targetAnchor : false;
                if ($target) {
                var targetOffset = $target.offset().top;

                //Function for removing and adding the "active" class and scroll to the DIV
                $(this).click(function() {
                    $("#nav li a").removeClass("active");
                    $(this).addClass('active');
                    $('html, body').animate({scrollTop: targetOffset}, 1000);
                    return false;
                });
            }
        }

    });
    $(window).scroll(function(){
        $('.parallax-1, .parallax-2').animate({
            backgroundPosition:"(50% -2000px)"
        }, 480);
    });

}

/**
 * Appends the HTML property of the result of an ajax call to the specified destination element
 * @param {json} json The ajax response
 * @param {event} e the original event
 * @param {bool} prepend if set to true, prepend to list, otherwise append
 * @method addToList
 */
function addToList(json, e, prepend){
    var destination = $(e.target).attr('data-destination');
    if( typeof(prepend)== 'undefined')    $(destination).append( json.html );
    else     $(destination).prepend( json.html );
    // reset the original form
    $(e.target)[0].reset();
}

/**
 * Replace an existing element with the one returned by an upload script
 * @param {event} e the original event
 * @param {json} data the upload result
 * @method replaceElementWithUploaded
 */
function replaceElementWithUploaded(e, data){
    var progressbar = $(e.target).attr('data-progress-bar');
    $(progressbar).find('span').html('');
    $(progressbar).css('width', 0 + '%');
    result = JSON.parse(data.result);
    if(result.status=='error'){
        $(e.target).after("<p class='alert alert-danger ajax-error'>"+result.errors+'</p>');
        return false;
    }
    var to_replace = $(e.target).attr('data-replace');
    $(to_replace).replaceWith(result.html);
}

/**
 * Replace an existing element with the one returned by an ajax script
 * @param {json} result the ajax result
 * @param {e} e the original event
 * @method replaceElementWithReturned
 */
function replaceElementWithReturned(result, e){
    var to_replace = $(e.target).attr('data-replace');
    $(to_replace).replaceWith(result.html);
    console.log(to_replace);
    console.log(result.html);
}

/**
 * jQuery method that scrolls an element to the specified child's position
 * @method scrollToChild
 * @param {string|element} child What element to scroll to
 */
$.fn.scrollToChild = function(child) {
    this.css( "color", "green" );
    this.scrollTop( this.scrollTop() + $(child).position().top - $(child).height() );
};

function postedComment(json, e){
    
    // remove form from page if reply
    if( $(e.target).find('.reply-to').val() > 0){
        // increment reply counter
        count = $(e.target).closest('.comment-form-reply').parent().parent().parent().find('.number-of-replies').html();
        $.trim( count );
        
        count = count.split(' ');
        count = count[0];
        
        count_number = count = count * 1 + 1 * 1;
        count += ' ' + pluralize( _('reply'), count_number );
        $(e.target).closest('.comment-form-reply').parent().parent().parent().find('.number-of-replies').first().html( count );
//        $(e.target).closest('.comment-form-reply').parent().parent().parent().find('.number-of-replies').click();
        $(e.target).closest('.comment-form-reply').remove();
        addToList(json, e);
    }
    else{
        addToList(json, e, true);
    }
}

function collapseComments(e){
    $(e.target).removeClass('load-remote');
    $(e.target).addClass('slide-toggler');
    $(e.target).attr('data-callback','rotateCollapse');
    $(e.target).find(".fa-arrow-down").remove();
    $(e.target).append(" <i class='fa fa-arrow-up fa-animated'></i>");
}

function rotateCollapse(e){
    rotation = rotation==0 ? 180 : 0;
    $(e.target).find('.fa').rotate(rotation);
}

var rotation = 0;

jQuery.fn.rotate = function(degrees) {
    $(this).css({'-webkit-transform' : 'rotate('+ degrees +'deg)',
                 '-moz-transform' : 'rotate('+ degrees +'deg)',
                 '-ms-transform' : 'rotate('+ degrees +'deg)',
                 'transform' : 'rotate('+ degrees +'deg)'});
    return $(this);
};
