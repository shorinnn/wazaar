/**
 * Contains generic reusable functions and event listeners
 * @class Main 
 */
// JavaScript Document
$(document).ready(function(){
    $('.lessons').jScrollPane();
    $(".profile-name > li").removeClass("activate-dropdown");
    $('body').delegate('.slide-toggler', 'click', slideToggle);
    $('body').delegate('a.load-remote', 'click', loadRemote);
    $('body').delegate('.form-to-remote-link', 'submit', formToRemoteLink);
    $('body').delegate('.load-remote a', 'click', prepareLoadRemote);
    $('body').delegate('a.load-more-ajax', 'click', loadMoreComments);
    $('body').delegate('a.load-remote-cache', 'click', loadRemoteCache);
	$('button.join-class').mousedown(function(){
		$(this).addClass('pushdown');
	});
	$('button.join-class').mouseup(function(){
		$(this).removeClass('pushdown');
	});
    $(window).scroll(stepsScrollAnimation);
    _.setTranslation( js_translation_map );
    floatingNav();
    scrollNavigation();
	fullScreen();
	skinVideoControls();
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
 * Hides the current .animated-step element, unhides the next one and triggers a slideup animation
 * @method unhide
 * @param {string} elem CSS selector
 * @param {string} data-target the element to display
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

/**
 * Reverses the unhide method
 * @method reverseUnhide
 * @param {string} data-target The element to display
 */
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
 * @param {string} data-target The element to toggle
 * @param {string} data-callback The function to call when the toggle animation finishes
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
 * Makes the element clicked inside the .load-remoteelement inherit load-remote
 * properties then fires loadRemote on it
 * @param {event} e Clickevent
 * @param {string} data-url The url to use in the ajax call
 * @param {string} data-callback The function to call after the ajax call succeedes
 * @param {string} data-load-method How to add the new content to the target (load|append|prepend|fade)
 * @param {string} data-target CSS selector of the element that receives the new content
 * @method prepareLoadRemote
 */
function prepareLoadRemote(e){
    $(e.target).attr('data-url', $(e.target).attr('href'));
    if( typeof( $(e.target).closest('.load-remote').attr('data-callback') )!='undefined'){
        $(e.target).attr('data-callback', $(e.target).closest('.load-remote').attr('data-callback'));
    }
    if( typeof( $(e.target).closest('.load-remote').attr('data-load-method') )!='undefined'){
        $(e.target).attr('data-load-method', $(e.target).closest('.load-remote').attr('data-load-method'));
    }
    $(e.target).attr('data-target', $(e.target).closest('.load-remote').attr('data-target'));
//    history.pushState({}, '', $(e.target).attr("href"));
    loadRemote(e);
}

/**
 * Sends the form's request as a GET request using the loadRemote function (simulating a link click)
 * @see loadRemote
 * @method formToRemoteLink
 * @param {event} e Click event
 * @param {string} data-url The url to use in the ajax call
 * @param {string} data-load-method How to add the new content to the target (load|append|prepend|fade)
 * @param {string} data-target CSS selector of the element that receives the new content
 */
function formToRemoteLink(e){
    url = $(e.target).attr('action');
    url+= '?'+$(e.target).serialize() ;
    $(e.target).attr('data-url', url);    
    loadRemote(e);
    return false;
}
/**
 * Event handler for a.load-remote<br />
 * It loads the resource specified at data-url into the element specified at data-target
 * @param {event} e Click event
 * @param {string} data-url The url to use in the ajax call
 * @param {string} data-callback The function to call after the ajax call succeedes
 * @param {string} data-load-method How to add the new content to the target (load|append|prepend|fade)
 * @param {string} data-target CSS selector of the element that receives the new content
 * @method loadRemote
 */
function loadRemote(e){
    e.preventDefault();
    var loading = $(e.target).attr('data-loading');
    if( typeof(loading)!='undefined'&& loading==1 ) return false;
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
    $(e.target).attr('data-loading', 1);
    history.pushState({}, '', url);
    if(typeof(loadMethod)=='undefined' || loadMethod=='load'){
        $(target).html( _('loading...') + '<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
        $(target).load(url, function(){
            $(e.target).attr('data-loading', 0);
            if( typeof(callback)!= 'undefined'){
                window[callback](e);
            }
        });
    }
    else if(loadMethod=='append' || loadMethod=='prepend'){
        $(target).prepend('<p class="remove_this">' + _('loading...') + '<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></p>');
        $.get(url, function(data){
            $('.remove_this').remove();
            $(e.target).attr('data-loading', 0);
            if(loadMethod=='append') $(target).append(data);
            else $(target).prepend(data);
            if( typeof(callback)!= 'undefined'){
                window[callback](e);
            }
        });
    }
    else if(loadMethod=='fade'){
        $(target).addClass('disabled-item');
        $(target).after("<div class='overlay-loading'></div>");
        mt = $(target).height();
        mt /=2;
        $('.overlay-loading').css('margin-top', "-"+mt+"px");
        $(target).load(url, function(){
            $('.overlay-loading').remove();
            $(target).removeClass('disabled-item');
            $(e.target).attr('data-loading', 0);
            if( typeof(callback)!= 'undefined'){
                window[callback](e);
            }
        });
    }
    else{}
}

/**
 * Loads more comments via ajax and appends them to the container
 * @param {event} e Click event
 * @param {string} data-url The url to use in the ajax call
 * @param {string} data-callback The function to call after the ajax call succeedes
 * @param {string} data-target CSS selector of the element that receives the new content
 * @param {string} data-skip How many items to skip in the fetch query
 * @param {string} data-post-field The name of the POST field containing the id
 * @param {string} data-id The ID value
 * @method loadMoreComments
 */
function loadMoreComments(e){    
    e.preventDefault();
    url = $(e.target).attr('data-url');
    target = $(e.target).attr('data-target');
    skip = $(e.target).attr('data-skip');
    lesson = $(e.target).attr('data-lesson');
    post_field = $(e.target).attr('data-post-field');
    id = $(e.target).attr('data-id');
    elem = $(e.target);
    while(typeof(url)=='undefined'){
        elem = elem.parent();
        url = elem.attr('data-url');
        target = elem.attr('data-target');
        callback = elem.attr('data-callback');  
    }
    $(e.target).html( _('Loading...') + '<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
    var json_data = {};
    json_data['skip'] = skip;
    json_data[post_field] = id;
    $.post(url, json_data, function(data) {
        $(e.target).attr('href','#');
        $(e.target).html( _('LOAD MORE') );
        if($.trim(data)==''){
            $(e.target).removeClass('load-more-ajax');
            $(e.target).html( _('Nothing more to load') );
        }
        $(target).append(data).fadeIn('slow');
        skip = 1 * skip + 1 * 2;
        $(e.target).attr('data-skip', skip);
        
    });
}

/**
 * Similar to loadRemote, it loads the resource, but only once, later requests just display the content already loaded
 * @param {event} e Click event
 * @param {string} data-url The url to use in the ajax call
 * @param {string} data-callback The function to call after the ajax call succeedes
 * @param {string} data-target CSS selector of the element that receives the new content
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


/**
 * Flag, set to true if the scrolling unhide/reverseUnhide animation is running
 * @property scrollAnimationActivated
 * @type {Boolean}
 */
scrollAnimationActivated = true;
/**
 * Fires the unhide method when scrolled to the bottom of the page and reverseUnhide
 * method when scrolled to the top of the page
 * @method stepsScrollAnimation
 */
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
 * @method floatingNav
 */
function floatingNav(){
    // this checks the current top position of the nav and stores it in a variable.
    if( $(".main-nav-section, .fixed-menu").length == 0 )return false;
    var max_scroll = $(".main-nav-section, .fixed-menu").position().top;
    $(window).scroll(function () {
        var navbar = $(".main-nav-section, .fixed-menu");

        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        if (scrollTop > max_scroll && !navbar.is(".filterbuttonFixed")) {
            navbar.addClass("filterbuttonFixed");
        }
        else if (scrollTop < max_scroll && navbar.is(".filterbuttonFixed")) {
            navbar.removeClass("filterbuttonFixed");
        }

    });

}

/**
 * Function for sliding to each section when nav button is clicked
 * @method scrollNavigation
 */ 
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
 * @param {string} data-destination CSS selector of the element that receives the new content
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
 * @param {string} data-progress-bar The progress bar used in the upload process (so we can reset it)
 * @param {string} data-replace CSS selector of the element to be replaced by the new stuff
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
 * @param {string} data-replace CSS selector of the element to be replaced by the new stuff
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

/**
 * Callback fired after posting a comment
 * @param {object} json The json response of the post ajax call
 * @param {type} e The original event (form submit)
 * @method postedComment
 */
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

/**
 * Expands/collapses a comment's reply box
 * @param {event} e The click event
 * @method collapseComments
 */
function collapseComments(e){
    $(e.target).removeClass('load-remote');
    $(e.target).addClass('slide-toggler');
    $(e.target).attr('data-callback','rotateCollapse');
    $(e.target).find(".fa-arrow-down").remove();
    $(e.target).append(" <i class='fa fa-arrow-up fa-animated'></i>");
}

/**
 * Used by rotateCollapse it stores the arrow glyph rotation value (0 or 180)
 * @property rotation
 * @type {Number}
 */
var rotation = 0;

/**
 * Fired when a comment area is expanded/collapsed, it rotates the arrow glyph
 * contained in the link element that triggeres the event
 * @param {event} e The collapseComments click event
 * @method rotateCollapses
 */
function rotateCollapse(e){
    rotation = rotation==0 ? 180 : 0;
    $(e.target).find('.fa').rotate(rotation);
}


/**
 * jQuery method that sets an element rotate property to the given value
 * @param {number} degrees The value of the rotate property
 * @method jQuery.rotate
 */
jQuery.fn.rotate = function(degrees) {
    $(this).css({'-webkit-transform' : 'rotate('+ degrees +'deg)',
                 '-moz-transform' : 'rotate('+ degrees +'deg)',
                 '-ms-transform' : 'rotate('+ degrees +'deg)',
                 'transform' : 'rotate('+ degrees +'deg)'});
    return $(this);
};


/**
 * Callback - updates the ThumbsUp/ThumbsDown text after rating a testimonial
 * @param {json} result The rating json response
 * @param {event} e The original form submit event
 * @method ratedTestimonial
 */
function ratedTestimonial(result, e){
    thumbs = $(e.target).attr('data-total');
    thumbs_up = $(e.target).attr('data-up');
    thumbs_down = $(e.target).attr('data-down');
    id = $(e.target).attr('data-testimonial-id');
    rate = $(e.target).attr('data-thumb');
    already_rated = typeof( $(e.target).attr('data-rated') ) == 'undefined' ? false : $(e.target).attr('data-rated');
 
    if( !already_rated ){
        thumbs++;
        if( rate=='up') ++thumbs_up;
        else ++thumbs_down;
    }
    else{
        if( rate=='up'){
             if( already_rated=='negative' ){
                 --thumbs_down;
                 ++thumbs_up;
             }
        }
        else{
            if( already_rated=='positive' ){
                ++thumbs_down;
                --thumbs_up;
            }
        }
    }
    if(thumbs==1){
        $('.testimonial-'+id+'-placeholder').hide();
        $('.testimonial-'+id).removeClass('hidden');
        if( rate=='up' ){
            $('.testimonial-'+id).find('.fa-thumbs-o-down').hide();
            $('.testimonial-'+id).find('.thumbs-down-label').hide();
            $('.testimonial-'+id).find('.fa-thumbs-o-up').show();
            $('.testimonial-'+id).find('.thumbs-up-label').show();
            $('.testimonial-'+id).find('.not-very').html('very');
        }
        else{
            $('.testimonial-'+id).find('.fa-thumbs-o-up').hide();
            $('.testimonial-'+id).find('.thumbs-up-label').hide();
            $('.testimonial-'+id).find('.fa-thumbs-o-down').show();
            $('.testimonial-'+id).find('.thumbs-down-label').show();
            $('.testimonial-'+id).find('.not-very').html('not');
        }
    }

    $('.testimonial-'+id).find('.thumbs-up-label').html(thumbs_up);
    $('.testimonial-'+id).find('.thumbs-down-label').html(thumbs_down);
    $('.testimonial-'+id).find('.thumbs-total-label').html(thumbs);

    $('[data-testimonial-id="'+id+'"]').prop('disabled', true);
    $('[data-testimonial-id="'+id+'"]').prop('disabled', 'disabled');
}

function fullScreen(){
    //Get the height and width of the browser
    $browserHeight = $(window).height();
    $browserWidth = $(window).width();

    //Properties to animate from
    var initialState = {
        margin: "0% auto 0",
        position: "relative",
        top: "-7%",
        left: 0,
        right: 0,
        bottom: 0,
        height: "590px",
        ease:Power4.easeOut
    }

    //Properties to animate to
    var finalState = {
        position: "fixed",
        top: "auto",
        left: 0,
        bottom: 0,
        right: 0,
        opacity: 1,
        margin: "0 auto",
        width: $browserWidth,
        height: $browserHeight,
        onStart: hideModules,
        onReverseComplete: removeBackground,
        onComplete: showContents,
        ease:Power4.easeOut
    }

    //Initialize and store the animation in a variable
    var expandCurriculum = TweenMax.fromTo("#curriculum > div", 0.7, initialState, finalState);
    function hideModules(){
        //Hide the lesson modules
        $(".lessons li a").hide();

        //Give the box a white background before animation starts
        TweenMax.to("#curriculum > div", 0, {backgroundColor: '#fff'});
    }

    function showContents(){
        //show the close button when animation is complete
        $("#close-button").show();

        //Adjust some elements' properties to adapt on fullscreen
        $('#curriculum > div > div').height($browserHeight);
        $('.lessons').height('100%');
        $(".lessons li a").show().css({'top':'200px', 'opacity': '0'});
        TweenMax.staggerTo(('.module-lesson'), 0.7, {top: '0', opacity: '1', ease:Power4.easeOut}, 0.1);
        $('.jspContainer').height('90%');
        $('.jspPane').css({'padding': '0 0 0 1%'});
        $('.classrooms-wrapper').css('background-color', '#fff');
        $('.jspVerticalBar').css('right', '1%');
        $('.classroom-content .curriculum p.lead').css({'font-size': '22px', 'text-align': 'center', 'margin-bottom': '0'});
        $('.classroom-content .curriculum div.view-previous-lessons').css({'line-height': '0', 'height': '32px', 'margin-bottom': '0'});

        //Remove default browser scrollbar
        $('body').css('overflow', 'hidden');
        //Hide the "View all" button on Full screen
    }

    function removeBackground(){
        $("#view-all-lessons").show();

        //Remove the white background on animation reverse
        TweenMax.to("#curriculum > div", 0, {backgroundColor: 'transparent'});
    }

    //Override the default "Play state" and pause the animation until a button is clicked
    expandCurriculum.pause();

    $("#view-all-lessons").click(function(){
        //Make the box fullscreen on button click
        expandCurriculum.play();
        $(this).hide();
    });

    $("#close-button").click(function(){
        //Restore to the initial state when the close button is clicked
        expandCurriculum.reverse();

        //And then hide the close button when not in fullscreen mode
        $(this).hide();;

        $('body').css('overflow', 'auto');

        //Revert adjusted properties to adapt on normal screen
        $('.lessons').height('400px');
        $('.jspContainer').height('100%');
        $('.jspPane').css({'padding': '0'});
        $('.classrooms-wrapper').css('background-color', '#f8f8f8');
        $('.jspVerticalBar').css({'right': '0%'});
        $('.classroom-content .curriculum p.lead').css({'font-size': '18px', 'text-align': 'left', 'margin-bottom': '10px'});
        $('.classroom-content .curriculum div.view-previous-lessons').css({'line-height': '64px', 'height': '64px', 'margin-bottom': '10px'});

    });

}

function skinVideoControls(){
    if( $('video').length==0) return;
	//INITIALIZE
	var video = $('#myVideo');

	//Set the width of the control to equal video width
	if(video){
        var playerWidth = video.innerWidth();
		$('.control').width(playerWidth);
	}
	//remove default control when JS loaded
	video[0].removeAttribute("controls");
	$('.control').show();

	//before everything get started
	video.on('loadedmetadata', function() {
		//set video properties
		$('.current').text(timeFormat(0));

	});
	
	//display current video play time
	video.on('timeupdate', function() {
		var currentPos = video[0].currentTime;
		var maxduration = video[0].duration;
		var perc = 100 * currentPos / maxduration;
		$('.timeBar').css('width',perc+'%');	
		$('.current').text(timeFormat(currentPos));	
	});
	
	//CONTROLS EVENTS
	//video screen and play button clicked
	video.on('click', function() { playpause(); } );
	$('.btnPlay, .centered-play-button').on('click', function() {
        playpause();
    });
	var playpause = function() {
		if(video[0].paused || video[0].ended) {
			$('.btnPlay').addClass('paused');
			video[0].play();
            $('.centered-play-button').hide();
		}
		else {
			$('.btnPlay').removeClass('paused');
			video[0].pause();
            $('.centered-play-button').show();
		}
	};

	//fullscreen button clicked
    $('.btnFS').on('click', function() {
        if($.isFunction(video[0].webkitEnterFullscreen)) {
            video[0].webkitEnterFullscreen();
        }
        else if ($.isFunction(video[0].mozRequestFullScreen)) {
            video[0].mozRequestFullScreen();
        }
        else {
            alert('Your browsers doesn\'t support fullscreen');
        }
    });
	
	//sound button clicked
	$('.sound').click(function() {
		video[0].muted = !video[0].muted;
		$(this).toggleClass('muted');
		if(video[0].muted) {
			$('.volumeBar').css('width',0);
		}
		else{
			$('.volumeBar').css('width', video[0].volume*100+'%');
		}
	});
	
	//VIDEO EVENTS
	//video canplay event
	video.on('canplay', function() {
		$('.loading').fadeOut(100);
	});
	
	//video canplaythrough event
	//solve Chrome cache issue
	var completeloaded = false;
	video.on('canplaythrough', function() {
		completeloaded = true;
	});
	
	//video ended event
	video.on('ended', function() {
		$('.btnPlay').removeClass('paused');
		video[0].pause();
	});

	//video seeking event
	video.on('seeking', function() {
		//if video fully loaded, ignore loading screen
		if(!completeloaded) { 
			$('.loading').fadeIn(200);
		}	
	});
	
	//video seeked event
	video.on('seeked', function() { });
	
	//video waiting for more data event
	video.on('waiting', function() {
		$('.loading').fadeIn(200);
	});
	
	//VIDEO PROGRESS BAR
	//when video timebar clicked
	var timeDrag = false;	/* check for drag event */
	$('.progress').on('mousedown', function(e) {
		timeDrag = true;
		updatebar(e.pageX);
	});
	$(document).on('mouseup', function(e) {
		if(timeDrag) {
			timeDrag = false;
			updatebar(e.pageX);
		}
	});
	$(document).on('mousemove', function(e) {
		if(timeDrag) {
			updatebar(e.pageX);
		}
	});
	var updatebar = function(x) {
		var progress = $('.progress');
		
		//calculate drag position
		//and update video currenttime
		//as well as progress bar
		var maxduration = video[0].duration;
		var position = x - progress.offset().left;
		var percentage = 100 * position / progress.width();
		if(percentage > 100) {
			percentage = 100;
		}
		if(percentage < 0) {
			percentage = 0;
		}
		$('.timeBar').css('width',percentage+'%');	
		video[0].currentTime = maxduration * percentage / 100;
	};

	//VOLUME BAR
	//volume bar event
	var volumeDrag = false;
	$('.volume').on('mousedown', function(e) {
		volumeDrag = true;
		video[0].muted = false;
		$('.sound').removeClass('muted');
		updateVolume(e.pageX);
	});
	$(document).on('mouseup', function(e) {
		if(volumeDrag) {
			volumeDrag = false;
			updateVolume(e.pageX);
		}
	});
	$(document).on('mousemove', function(e) {
		if(volumeDrag) {
			updateVolume(e.pageX);
		}
	});
	var updateVolume = function(x, vol) {
		var volume = $('.volume');
		var percentage;
		//if only volume have specificed
		//then direct update volume
		if(vol) {
			percentage = vol * 100;
		}
		else {
			var position = x - volume.offset().left;
			percentage = 100 * position / volume.width();
		}
		
		if(percentage > 100) {
			percentage = 100;
		}
		if(percentage < 0) {
			percentage = 0;
		}
		
		//update volume bar and video volume
		$('.volumeBar').css('width',percentage+'%');
		video[0].volume = percentage / 100;
		
		//change sound icon based on volume
		if(video[0].volume == 0){
			$('.sound').removeClass('sound2').removeClass('sound3').addClass('muted');
		}
        else if(video[0].volume > 0 && video[0].volume < 0.6){
            $('.sound').removeClass('muted').removeClass('sound3').addClass('sound2');
        }
        else if(video[0].volume > 0.6){
			$('.sound').removeClass('sound2').removeClass('muted').addClass('sound3');
		}

	};

	//Time format converter - 00:00
	var timeFormat = function(seconds){
		var m = Math.floor(seconds/60)<10 ? "0"+Math.floor(seconds/60) : Math.floor(seconds/60);
		var s = Math.floor(seconds-(m*60))<10 ? "0"+Math.floor(seconds-(m*60)) : Math.floor(seconds-(m*60));
		return m+":"+s;
	};
    $('.duration').text(timeFormat(video[0].duration));
    updateVolume(0, 0.7);

}
