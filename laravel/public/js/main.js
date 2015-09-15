/**
 * Contains generic reusable functions and event listeners
 * @class Main 
 */
// JavaScript Document

function isset(variable){
    if( typeof(variable)=='undefined') return false;
    return true;
}
var COCORIUM_APP_PATH = '//'+document.location.hostname+'/';

$(document).ready(function(){
    
//    var canPopState = false;
//    setTimeout(function(){
//        canPopState = true;
//    },20);
//
//    console.log( history.popState );
//    $(window).on("popstate", function(e) {
//        console.log( history.popState );
//          if( !canPopState )return false;
//          window.location = location.href;
//      });

	$("#affiliate-toolbar-tracking").on("focus", function(){
	  $(".fa.fa-plus").hide();
	});
	$("#affiliate-toolbar-tracking").on("blur", function(){
	  $(".fa.fa-plus").show();
	});	

    makeBoxesExpandable();
    if( getCookie('hideAffiliateToolbar')=='true' ) toggleAffiliateToolbar(event);
    $('.countdown').each(function(){
        seconds = $(this).attr('data-final-date-seconds')
        time = moment().add(seconds, 'seconds').format('YYYY/MM/DD HH:mm:ss');
        time = time.toString(); 
        console.log(time);
        $(this).countdown(time, function(event) {
               $(this).html( event.strftime('%D '+_('days')+' %H  '+_('hours')+' %M  '+_('minutes')+' %S '+_('seconds')) );
             } );
    });
	
    $('.tooltipable').tooltip();
    enableClipboard();

    $('#curriculum .lessons').jScrollPane();
    $(".profile-name > li").removeClass("activate-dropdown");
    $('body').delegate('.type-in-elements', 'keyup', typeInElemens);
    $('body').delegate('.characters-left', 'keyup', charactersLeft);
    $('body').delegate('.scroll-to-element', 'click', scrollToElement);
    $('body').delegate('.slide-toggler', 'click', slideToggle);
    $('body').delegate('a.load-remote', 'click', loadRemote);
    $('body').delegate('a.link-to-remote', 'click', linkToRemote);
    $('body').delegate('a.link-to-remote-confirm', 'click', linkToRemoteConfirm);
    $('body').delegate('.form-to-remote-link', 'submit', formToRemoteLink);
    $('body').delegate('.load-remote a', 'click', prepareLoadRemote);
    $('body').delegate('a.load-more-ajax', 'click', loadMoreComments);
    $('body').delegate('a.load-remote-cache', 'click', loadRemoteCache);
    $('body').delegate('.btnLink', 'click', goTo);
    $('body').delegate('#video-grid .boxes', 'mouseenter', videoGridBoxIn);
    $('body').delegate('#video-grid .boxes', 'mouseleave', videoGridBoxOut);
    $('body').delegate('.delayed-keyup', 'keyup', delayedKeyup);
	$('button.join-class').mousedown(function(){
		$(this).addClass('pushdown');
	});
	$('button.join-class').mouseup(function(){
		$(this).removeClass('pushdown');
	});	
	
    $(window).scroll(stepsScrollAnimation);
//    _.setTranslation( js_translation_map );
    floatingNav();
    scrollNavigation();
	fullScreen();
	skinVideoControls();
	insertSelectBorder();
	askTeacherQuestion();
	searchFormFocusStyle();
	showMoreContent();
	toggleSideMenu();
	//stickyFooter();
	rescaleBckgrdOverlay();
	$(window).resize(function() {
	  rescaleBckgrdOverlay();
   	  skinVideoControls();
	});
	
	$(".classroom-view #myVideo").resize(function() {
   	  skinVideoControls();
	});

});

function makeBoxesExpandable(){
    $('body').delegate('textarea', 'keyup', function(){
		var opts = {
			animate: false,
			cloneClass: 'faketextarea'
		};
		$('textarea').autogrow(opts);
	});
	
		/*$(".scroll-pane").customScrollbar({
			skin: "wazaar-skin", 
			hScroll: false,
			updateOnWindowResize: true
		});*/
}

function videoGridBoxIn(){
	TweenMax.to($(this), 0.3, {zIndex: 9, scale: '1.2'});
}

function videoGridBoxOut(){
	TweenMax.to($(this), 0.3, {zIndex: 3, scale: '1'});
}

function enableClipboard(){
    var client = new ZeroClipboard($(".clipboardable"));
    $('.clipboardable').closest('.tooltipable').attr('title', _('Copy to clipboard') );
    $('.clipboardable').closest('.tooltipable').on('mouseout', function(){
        $(this).attr('title', _('Copy to clipboard') );
        $(this).attr('data-original-title', _('Copy to clipboard') );
    });
    
    client.on( "ready", function( readyEvent ) {
      client.on( "aftercopy", function( event ) {
          
        $(event.target).closest('.tooltipable').attr('title', _('Copied!') );
        $(event.target).closest('.tooltipable').attr('data-original-title', _('Copied!') );
        $(event.target).closest('.tooltipable').tooltip('show');
      } );      
    } );
    $('.tooltipable').tooltip();
}

function goTo(e){
    window.location = $(e.target).attr('data-url');
}

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


function linkToRemote(e){
    e.preventDefault();
    
    var nofollow = $(e.target).attr('data-nofollow');
    if( typeof(nofollow)!='undefined'&& nofollow==1 ) return false;
    
    var loading = $(e.target).attr('data-loading');
    if( typeof(loading)!='undefined'&& loading==1 ) return false;
    
    url = $(e.target).attr('data-url');
    var callback = $(e.target).attr('data-callback');
    elem = $(e.target);
    preFunction = $(e.target).attr('data-pre-function');
    loadingContainer = $(e.target).attr('data-loading-container');
    while(typeof(url)=='undefined'){
        elem = elem.parent();
        url = elem.attr('data-url');
        preFunction = elem.attr('data-pre-function');
        callback = elem.attr('data-callback');  
        loadingContainer = elem.attr('data-loading-container');  
        e.target = elem;
    }
    
    if( !isset(loadingContainer) ){
        $(elem).attr('data-old-label', $(elem).html() );
        $(elem).html( '<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
    }
    else{
        $(loadingContainer).html('<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
    }
    if( typeof(preFunction) !='undefined') window[preFunction](e);
    url+='#!ajax=true';
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
    url+='#!ajax=true';
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
    var nofollow = $(e.target).attr('data-nofollow');
    if( typeof(nofollow)!='undefined'&& nofollow==1 ) return false;
    var loading = $(e.target).attr('data-loading');
    if( typeof(loading)!='undefined'&& loading==1 ) return false;
    url = $(e.target).attr('data-url');
    target = $(e.target).attr('data-target');
    var callback = $(e.target).attr('data-callback');
    var callback2 = $(e.target).attr('data-callback-2');
    elem = $(e.target);
    loadMethod = $(e.target).attr('data-load-method');
    noPush = $(e.target).attr('data-no-push-state');
    indicatorStyle = $(e.target).attr('data-indicator-style');
    failSafe = 0;
    while(typeof(url)=='undefined'){
        elem = elem.parent();
        url = elem.attr('data-url');
        target = elem.attr('data-target');
        callback = elem.attr('data-callback');  
        callback2 = elem.attr('data-callback-2');  
        noPush = elem.attr('data-no-push-state');  
        loadMethod = $(e.target).attr('data-load-method');
        indicatorStyle = elem.attr('data-indicator-style')
        if(failSafe > 50) return;
        failSave++;
    }

    $(e.target).attr('data-loading', 1);
    
     
    if( typeof( noPush ) == 'undefined'  ){ 
        history.pushState({}, '', url);
    }
    if( url.indexOf('?')== -1 ) url+='?ajax=true';
    else url+='&ajax=true';
    console.log( url );
    if(typeof(loadMethod)=='undefined' || loadMethod=='load'){
       
        if( typeof(indicatorStyle)=='undefined')
            $(target).html( '<center><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></center> ');
        else{
            $(target).children('*').css('opacity', 0.1);
            $(target).append('<div class="small-overlay"><center><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></center></div>');
        }
        
        if( typeof(callback2)!= 'undefined'){
            window[callback2](e);
        }
        
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
	var count = 0;
	animationInterval = setInterval(function(){
	  count++;
	  document.getElementById('load-more-ajax-button').innerHTML = "Loading." + new Array(count % 4).join('.');
	}, 500);
    var json_data = {};
    json_data['skip'] = skip;
    json_data[post_field] = id;
    $.post(url, json_data, function(data) {
        $(e.target).attr('href','#');
		clearInterval(animationInterval);
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
    var cachedCallback = $(e.target).attr('data-cached-callback');
    elem = $(e.target);
    while(typeof(url)=='undefined'){
        elem = elem.parent();
        url = elem.attr('data-url');
        target = elem.attr('data-target');
        callback = elem.attr('data-callback');  
        cachedCallback = elem.attr('data-cached-callback');  
    }
    // load content from the parent container
    $(target).parent().children().hide();
    $(target).show();

    
    if(elem.attr('data-loaded') == '1' ){
        if( typeof(cachedCallback)!= 'undefined'){
            window[cachedCallback](e);
        }
        return false;
    }// content already loaded, just redisplay it
    gif = '<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader-2.gif" />';
    customGif = $(e.target).attr('data-gif');
    if( typeof(customGif)!= 'undefined' ){
        gif = '<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/'+customGif+'" />';
    }
    var loadingGif = $(target).html( gif ).css({
	textAlign: 'center',
	marginBottom: 0,
	marginTop: 0
	});

    $(target).load(url, function(responseText, textStatus, req){
        elem.attr('data-loaded','1');
        elem.addClass('dataLoaded');
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
    $('.main-nav-section a[href*=#]').each(function() {
		if( $(this).attr("href")=="#video-grid") return;
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
    if( typeof( $(e.target).attr('data-prepend')  ) !='undefined') prepend = $(e.target).attr('data-prepend');
    if( typeof(prepend)== 'undefined')    $(destination).append( json.html );
    else     $(destination).prepend( json.html );
    // reset the original form
    $(e.target)[0].reset();
}

function updateHTML(e, json){
    var target = $(e.target).attr('data-target');
    prop = $(e.target).attr('data-property');
    val = json[prop];
    $(target).html( val );
}

function showClassroomQuestion(e, json){
    if( $('#myVideo').length > 0 ) $('#myVideo')[0].pause();
    
    var target = $(e.target).attr('data-target');
    prop = $(e.target).attr('data-property');
    val = json[prop];
    var modal = bootbox.dialog({
        title:json.title,
        message: val
    });
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
        //count += ' ' + pluralize( _('reply'), count_number );
        count += ' ' + ( _('reply') );
        $(e.target).closest('.comment-form-reply').parent().parent().parent().find('.number-of-replies').first().html( count );
//        $(e.target).closest('.comment-form-reply').parent().parent().parent().find('.number-of-replies').click();
        $(e.target).closest('.comment-form-reply').remove();
        addToList(json, e);
    }
    else{
        if( $(e.target).attr('data-reverse') ==1 ){ 
            addToList(json, e);
        }
        else addToList(json, e, true);
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
            $('.testimonial-'+id).find('.not-very').html( _('very') );
        }
        else{
            $('.testimonial-'+id).find('.fa-thumbs-o-up').hide();
            $('.testimonial-'+id).find('.thumbs-up-label').hide();
            $('.testimonial-'+id).find('.fa-thumbs-o-down').show();
            $('.testimonial-'+id).find('.thumbs-down-label').show();
            $('.testimonial-'+id).find('.not-very').html( _('not') );
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
        $("#curriculum .lessons li a").show().css({'top':'200px', 'opacity': '0'});
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
	//INITIALIZE
	var video = $('#myVideo');
    if($('#myVideo').length == 0) return;

	//Set the width of the control to equal video width
	if(video){
        var playerWidth = video.innerWidth();
		var playerHeight = video.innerHeight();
		console.log('Player height is' + playerHeight);
		console.log('Player Width is' + playerWidth);
		var centerPlayButtonHeight = $('.play-intro-button').outerHeight();
		var controlContainerHeight = $('.course-details-player .control-container').outerHeight();
		console.log('Button height is ' + centerPlayButtonHeight);
		//$('.control').css('max-width',playerWidth);
		$('.play-intro-button').css('top', (playerHeight)/2 - centerPlayButtonHeight / 2);
                if(video[0].paused || video[0].ended) {
                    $('.play-intro-button').show();
                }
                

	}
	//remove default control when JS loaded
	// video[0].removeAttribute("controls");
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
		$('.current').text(timeFormat(currentPos) /*+ ' / '*/);	
	});
        
        var playpause = function() {
                console.log('PLAYPAUSE');
		if(video[0].paused || video[0].ended) {
                    console.log('playing the vid');
			$('.btnPlay').addClass('playing').removeClass('paused');
			$('.btnPlay .wa-play').hide();
			$('.btnPlay .wa-pause').show();
			video[0].play();
                        $('.centered-play-button, .play-intro-button').hide();
		}
		else {
                    console.log('pausing the vid');
			$('.btnPlay').removeClass('playing').addClass('paused');
			$('.btnPlay .wa-play').show();
			$('.btnPlay .wa-pause').hide();
			video[0].pause();
                        $('.centered-play-button, .play-intro-button').show();
		}
	};
	
	//CONTROLS EVENTS
	//video screen and play button clicked
        video.off('click');
	video.on('click', function() { playpause(); } );
	$('.btnPlay, .centered-play-button, .play-intro-button').off('click');
	$('.btnPlay, .centered-play-button, .play-intro-button').on('click', function() {
        playpause();
		$('#lesson-video-overlay').hide();
    });

    $('#bckgrd-video-container .centered-play-button').on('click', function() {
        $('#bckgrd-video-container #bckgrd-video-overlay').hide();
        var actualVideoHeight = video[0].videoHeight;
        $('#bckgrd-video-container').css('height', actualVideoHeight + 95);
        $('.video-container .control div.btnFS').hide();
    });

	

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
        $('.sound').off('click');
	$('.sound').click(function() {
                console.log('SOUNDCLICKING!');
                console.log( video[0].muted );
		video[0].muted = !video[0].muted;
		$(this).toggleClass('muted');
                console.log( video[0].muted );
		if(video[0].muted) {
			$('.volumeBar').css('width',0);
			$('.wa-sound').hide();
			$('.fa.fa-volume-off').show();
		}
		else{
			$('.volumeBar').css('width', video[0].volume*100+'%');
			$('.wa-sound').show();
			$('.fa.fa-volume-off').hide();
		}
	});
	
	//VIDEO EVENTS

	//video canplaythrough event
	//solve Chrome cache issue
	var completeloaded = false;
	video.on('canplaythrough', function() {
		completeloaded = true;
	});
	
	//video ended event
	video.on('ended', function() {
		$('.btnPlay').removeClass('playing');
		video[0].pause();
	});

	//video seeked event
	video.on('seeked', function() { });
	

	//VIDEO PROGRESS BAR
	//when video timebar clicked
	var timeDrag = false;	/* check for drag event */
	$('.videoContainer .progress').on('mousedown', function(e) {
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
		var progress = $('.videoContainer .progress');

		//calculate drag position
		//and update video currenttime
		//as well as progress bar
                video = $('#myVideo');
        //console.log(video);
		var maxduration = video[0].duration;
                console.log('MAXDURATION IS '+maxduration);
		var position = x - progress.offset().left;
		var percentage = 100 * position / progress.width();
		if(percentage > 100) {
			percentage = 100;
		}
		if(percentage < 0) {
			percentage = 0;
		}
		$('.timeBar').css('width',percentage+'%');	
                ct =  maxduration * percentage / 100;
                console.log(' CURRENT TIME IS: '+ct);
		video.currentTime = ct;

        console.log('Updated TIME IS: ' + video.currentTime);
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
			$('.wa-sound').hide();
			$('.fa.fa-volume-off').show();
		}
        else if(video[0].volume > 0 && video[0].volume < 0.6){
            $('.sound').removeClass('muted').removeClass('sound3').addClass('sound2');
			$('.wa-sound').show();
			$('.fa.fa-volume-off').hide();
        }
        else if(video[0].volume > 0.6){
			$('.sound').removeClass('sound2').removeClass('muted').addClass('sound3');
			$('.wa-sound').show();
			$('.fa.fa-volume-off').hide();
		}

	};

	//Time format converter - 00:00
	var timeFormat = function(seconds){
		var m = Math.floor(seconds/60)<10 ? "0"+Math.floor(seconds/60) : Math.floor(seconds/60);
		var s = Math.floor(seconds-(m*60))<10 ? "0"+Math.floor(seconds-(m*60)) : Math.floor(seconds-(m*60));
		return m+":"+s;
	};
        loop_failsafe = 0;
        var updateTimeFormat = function(){
            video = $('#myVideo');
            duration = video[0].duration;
            console.log('DURATION IS  '+video[0].duration);
            $('.duration').text( timeFormat( video[0].duration ) );
            loop_failsafe++;
            if(loop_failsafe > 10) return;
            if( isNaN( duration ) ) setTimeout(updateTimeFormat, 100);
        };
    updateTimeFormat();
    updateVolume(0, 0.7);
    
    return true;

}

//Add blue border with a checkmark to selected images
function insertSelectBorder(){
    $('.use-existing-preview .select-border').off('click');
	$('.use-existing-preview .select-border').on('click', function(){
		$(this).toggleClass('display-border');
		if($(this).hasClass('display-border')){
			$('.use-existing-preview .select-border').not(this).removeClass('display-border');
			$(this).parent().find('input[type="radio"]').prop('checked', true);	
			//$(this).siblings('.select-border').toggleClass('hide');	
		}
	});	
}


function delayedKeyup(e){
    delay( window[$(e.target).attr('data-callback')], $(e.target).attr('data-delay'), $(e.target) );
}

var delay = (function () {
	var timer = 0;
	return function (callback, ms, obj) {
		clearTimeout(timer);
		timer = setTimeout(callback, ms, obj);
	};
})();


function askTeacherQuestion(){
	var containerHeight = $('#lesson-ask-teacher-section').height();
	var containerWidth = $('#lesson-ask-teacher-section').width();
	var containerBox = TweenMax.fromTo('.no-teacher-questions', 0.000001, {height: 0, width: 0}, {display: 'block', height: containerHeight, width: containerWidth});
	var tweenBox = TweenMax.to('.no-teacher-questions > div', 0.3, {transform: 'scale(1)'});
	tweenBox.pause();
	containerBox.pause();
	$('#lesson-ask-teacher-section').show();
	$('#show-teacher-questions').on('click', function(){

		//$('#lesson-ask-teacher-section').toggleClass('hide-teacher-questions');
		if($('#lesson-ask-teacher-section').hasClass('hide-teacher-questions')){
			$('#lesson-ask-teacher-section').removeClass('hide-teacher-questions');
			tweenBox.play();
			//tweenBox.delay(0.5);	
			containerBox.play();
		}
		else{
			$('#lesson-ask-teacher-section').addClass('hide-teacher-questions');
			tweenBox.reverse();
			containerBox.reverse();		
		}
		
	});
}

function searchFormFocusStyle(){
	$('.course-search-section .course-search-form input').on('focus', function(){
		$('.course-search-section .course-search-form form').css({
			border: 'solid 1px #abd82a',
			boxShadow: '0px 0px 7px 1px #abd82a'
		});
		$(this).attr("placeholder","");
	});
	$('.course-search-section .course-search-form input').on('blur', function(){
		$('.course-search-section .course-search-form form').css({
			border: 'solid 1px #fff',
			boxShadow: 'none'
		});
		$(this).attr("placeholder","E.g. Javascript, online business, etc ...");
	});
	
	//Remove dashboard textarea placeholder onclick and restore it on blur
	$('.comment-section .comment-box form textarea').on('focus', function(){
		$(this).data('placeholder',$(this).attr('placeholder'));
       	$(this).attr('placeholder','');	
	});
	$('.comment-section .comment-box form textarea').on('blur', function(){
		$(this).attr('placeholder',$(this).data('placeholder'));
	});

}

function showMoreContent(){
    	$(".expandable-button").each(function() {
		var $link = $(this);
		var $content = $link.parent().children('.expandable-content');
	
		console.log($link);
		console.log($content);
	
//		var visibleHeight = $content[0].clientHeight;
		var visibleHeight = $content.height();
		var actualHide = $content[0].scrollHeight - 1; // -1 is needed in this case or you get a 1-line offset.
		$content.height(visibleHeight);
//		$content.css( {
//                    'border' : '1px solid red',
//                    'height': visibleHeight+'px !important'
//                });
		console.log("Actual height is" + actualHide);
		console.log("Visible height is" + visibleHeight);
	
		if (actualHide > visibleHeight) {
			$link.show();
		} else {
			$link.hide();
		}
		
		$(".course-description p").each(function(){
			if (!$(this).text().trim().length) {
				$(this).addClass("no-margin");
			}
		});

		if($link.is(":visible")){
			$link.parent().find('.fadeout-text').show();
		}
		else{
			$link.parent().find('.fadeout-text').hide();						
		}
		
		$link.html(('<i class="fa fa-chevron-down"></i>') + $link.attr('data-more-text'));
		
		$link.on("click", function() {
			if ($link.hasClass('show-more')){
				$link.removeClass('show-more');
				$link.addClass('show-less');
				$link.siblings('.fadeout-text').hide();
				$content.css('max-height', 'none');
				$link.html(('<i class="fa fa-chevron-up"></i>') + $link.attr('data-less-text'));
				TweenMax.fromTo($content, 0, {height: visibleHeight}, {height: actualHide});
				$('[data-toggle="tooltip"]').tooltip();
			} else if($link.hasClass('show-less')){
				$link.removeClass('show-less');
				$link.addClass('show-more');
				$link.siblings('.fadeout-text').show();
				$link.html(('<i class="fa fa-chevron-down"></i>') + $link.attr('data-more-text'));
				TweenMax.fromTo($content, 0, {height: actualHide}, {height: visibleHeight});
			}
		
			return false;
		});
	});
}

function rescaleBckgrdOverlay(){
	var bckgrdImageHeight = $('#user-data-bckgrd-img').css('height');
	var bckgrdImageWidth  = $('#user-data-bckgrd-img').css('width');
	$('.background-image-overlay').css('height', bckgrdImageHeight); 	
	$('.background-image-overlay').css('width', bckgrdImageWidth);	
}

function round2(number, roundTo){
    return (Math.round(number/roundTo)) * roundTo; 
}

function xmlToJson(xml) {
	
	// Create the return object
	var obj = {};

	if (xml.nodeType == 1) { // element
		// do attributes
		if (xml.attributes.length > 0) {
		obj["@attributes"] = {};
			for (var j = 0; j < xml.attributes.length; j++) {
				var attribute = xml.attributes.item(j);
				obj["@attributes"][attribute.nodeName] = attribute.nodeValue;
			}
		}
	} else if (xml.nodeType == 3) { // text
		obj = xml.nodeValue;
	}

	// do children
	if (xml.hasChildNodes()) {
		for(var i = 0; i < xml.childNodes.length; i++) {
			var item = xml.childNodes.item(i);
			var nodeName = item.nodeName;
			if (typeof(obj[nodeName]) == "undefined") {
				obj[nodeName] = xmlToJson(item);
			} else {
				if (typeof(obj[nodeName].push) == "undefined") {
					var old = obj[nodeName];
					obj[nodeName] = [];
					obj[nodeName].push(old);
				}
				obj[nodeName].push(xmlToJson(item));
			}
		}
	}
	return obj;
};

function toggleSideMenu(){
	$('body').delegate('.slide-menu-toggler', 'click', function(){
		$('.slide-menu').toggleClass('in');	
	});	
}

function toggleRightBar(e, json){
    

    $('.ask-question').removeClass('active');
    $('.questions-box').removeClass('active');
    
    if( showingQuestionForm ){
        showingQuestionForm = false;
        $('.ask-question').addClass('active');
    }
    if( isset(json) && typeof(e) !='undefined' && typeof( $(e.target).attr('data-property') ) !='undefined' && $('.right-slide-menu').hasClass('in') ){
        var target = $(e.target).attr('data-target');
        prop = $(e.target).attr('data-property');
        val = json[prop];
        $(target).html( val );
        $(e.target).parent().addClass('active');
        return false;
    }
    if( !isset(json) && isset(e) && typeof( $(e.target).attr('data-property') )!='undefined'  && $('.right-slide-menu').hasClass('in') ) return false;
    $('.play-intro-button').hide();
    $('.right-slide-menu').toggleClass('in');
    if($('.course-question-sidebar').length >= 1){
        $('.course-question-sidebar').toggleClass('in');
    }
    
    if($('.right-slide-menu.in .ask-question-fields .clearfix input[type=text]').length >= 1){
        $('.right-slide-menu.in .ask-question-fields .clearfix input[type=text]').focus();
    }
    $('.slide-to-left').toggleClass('in');
    $('body').toggleClass('discussion-opened');
    setTimeout( skinVideoControls, 501 );
    
    if( !isset(json) ) return false;
    
    if( typeof(e) !='undefined' ){
        if( $('#myVideo').length > 0 ) $('#myVideo')[0].pause();
        
        var target = $(e.target).attr('data-target');
        prop = $(e.target).attr('data-property');
        val = json[prop];
        $(target).html( val );
    }
}


function colorLinks(e){
    color = $(e.target).attr('data-color');
    elem = $(e.target).attr('data-elem');
//    $(elem).removeAttr('style');
//    $(e.target).css('color', color);
    $(elem).removeClass('active');
    $(e.target).addClass('active');
}

$.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});

function searchDiscussions(){
    s = $('#question-search-box').val();
    $('.questions-box').hide();
    $('span.question-title:contains("'+s+'")').parent().parent().show();
}

var showingQuestionForm = false;
function showLessonQuestionForm(){
    $('.right-slide-menu').html( $('#question-form').html() );
    showingQuestionForm = true;
    toggleRightBar();
}

function LessonQuestionAddToList(json, e){
    addToList(json, e);
    toggleRightBar();
}

function scrollToElement(e){
    e.preventDefault();
    target = $(e.target).attr('data-target');
     $('html, body').animate({
        scrollTop: $(target).offset().top
    }, 400);
}

$('body').on('click', '.affiliate-toolbar-toggler', toggleAffiliateToolbar);
var hideAffiliateToolbar = false;
function toggleAffiliateToolbar(e){
    $('div.affiliate-toolbar').toggleClass( 'minimized' );
    $('div.affiliate-toolbar').toggleClass( 'tooltipable' );
    $('div.affiliate-toolbar').toggleClass( 'affiliate-toolbar-toggler' );
    $('.affiliate-toolbar-toggler-btn').toggleClass( 'affiliate-toolbar-toggler' );
    $('.tooltipable').tooltip();
    hideAffiliateToolbar = !hideAffiliateToolbar;
    document.cookie="hideAffiliateToolbar="+hideAffiliateToolbar; 
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}
    
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

function showFiles(e, elem){
    e.preventDefault();
    e.stopPropagation();
    $(elem).slideToggle();
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
        statusbar: false,
        paste_as_text: true
    });
}

$('body').delegate('.wishlist-change-button', 'click', wishlistChange);
function wishlistChange(e){
    e.preventDefault();
    e.stopPropagation();
    $target = $(e.target);
    iconHolder = $target.attr('data-icon-holder');
    console.log(iconHolder);
    textHolder = $target.attr('data-text-holder');
    if( $target.attr('data-auth')==0 ){
        $target.attr('data-original-title',  _( 'Login to add to wishlist' ) );
        $target.animate({'margin-left':'-5px'},50).
                animate({'margin-left':'+5px'},50).
                animate({'margin-left':'-5px'},50).
                animate({'margin-left':'0px'},50);
        return false;
    }
    url = $target.attr('data-url');
    state = $target.attr('data-state') == 1 ? 0 : 1;
    if( isset(iconHolder) ){
      $('.wishlist-change-button').attr('data-state', state);
    }
    $target.attr('data-state', state);
    
    if( state == 0 ){
        if( isset(iconHolder) ){
            console.log('has icon holder');
            $(iconHolder).addClass('fa-heart-o');
            $(iconHolder).removeClass('fa-heart');
            $('.wishlist-change-button').attr('data-original-title',  _('Add to wishlist') );
            $('.wishlist-change-button').parent().attr('data-original-title',  _('Add to wishlist') );
            $(textHolder).html(_('Add to wishlist') );
        }
        else{
            $target.addClass('fa-heart-o');
            $target.removeClass('fa-heart');
            $target.attr('data-original-title',  _('Add to wishlist') );
        }
        
        
    }
    else{
        if( isset(iconHolder) ){
            console.log('has icon holder');
            $(iconHolder).removeClass('fa-heart-o');
            $(iconHolder).addClass('fa-heart');
            $('.wishlist-change-button').attr('data-original-title',  _('Remove from wishlist') );
            $('.wishlist-change-button').parent().attr('data-original-title',  _('Remove from wishlist') );
            $(textHolder).html(_('Remove from wishlist') );
        }
        else{
            $target.removeClass('fa-heart-o');
            $target.addClass('fa-heart');
            $target.attr('data-original-title',  _('Remove from wishlist') );
        }
        
        
    }
    $.get(url+'/'+state,function(){});
}
void function $getLines($){    
    function countLines($element){
        var lines          = 0;
        var greatestOffset = void 0;

        $element.find('character').each(function(){
            if(!greatestOffset || this.offsetTop > greatestOffset){
                greatestOffset = this.offsetTop;
                ++lines;
            }
        });
        
        return lines;
    }
    
    $.fn.getLines = function $getLines(){
        var lines = 0;
        var clean = this;
        var dirty = this.clone();
        
        (function wrapCharacters(fragment){
            var parent = fragment;
            
            $(fragment).contents().each(function(){                
                if(this.nodeType === Node.ELEMENT_NODE){
                    wrapCharacters(this);
                }
                else if(this.nodeType === Node.TEXT_NODE){
                    void function replaceNode(text){
                        var characters = document.createDocumentFragment();
                        
                        text.nodeValue.replace(/[\s\S]/gm, function wrapCharacter(character){
                            characters.appendChild($('<character>' + character + '</>')[0]);
                        });
                        
                        parent.replaceChild(characters, text);
                    }(this);
                }
            });
        }(dirty[0]));
        
        clean.replaceWith(dirty);

        lines = countLines(dirty);
        
        dirty.replaceWith(clean);
        
        return lines;
    };
}(jQuery);

function scrollToAjaxcontentcontainer(){
    $(document).animate({scrollTop:$('.homepage-header').position().top});
    console.log($('.homepage-header').position().top)
}

function ajaxifyPagination(e){
    $('.pagination-container a').each(function(){
        $(this).addClass( 'load-remote' );
        $(this).attr( 'data-url', $(this).attr('href') );
        $(this).attr( 'data-callback', 'ajaxifyPagination' );
        $(this).attr( 'data-callback-2', 'scrollToElement' );
        $(this).attr( 'data-target', '.ajax-content' );
    });
}
