function isset(t){return"undefined"==typeof t?!1:!0}function videoGridBoxIn(){TweenMax.to($(this),.3,{zIndex:9,scale:"1.2"})}function videoGridBoxOut(){TweenMax.to($(this),.3,{zIndex:3,scale:"1"})}function enableClipboard(){var t=new ZeroClipboard($(".clipboardable"));$(".clipboardable").closest(".tooltipable").attr("title",_("Copy to clipboard")),$(".clipboardable").closest(".tooltipable").on("mouseout",function(){$(this).attr("title",_("Copy to clipboard")),$(this).attr("data-original-title",_("Copy to clipboard"))}),t.on("ready",function(e){t.on("aftercopy",function(t){$(t.target).closest(".tooltipable").attr("title",_("Copied!")),$(t.target).closest(".tooltipable").attr("data-original-title",_("Copied!")),$(t.target).closest(".tooltipable").tooltip("show")})}),$(".tooltipable").tooltip()}function goTo(t){window.location=$(t.target).attr("data-url")}function convertToSlug(t){return t.toLowerCase().replace(/[^\w ]+/g,"").replace(/ +/g,"-")}function followRedirect(t){window.location=t.url}function uniqueId(){for(id=1e6*Math.random(),id=Math.ceil(id);-1!=unique_numbers.indexOf(id);)id=1e6*Math.random(),id=Math.ceil(id),unique_numbers.push(id);return id}function unhide(t){$(t).removeClass("hidden"),$(t).css("opacity","0"),$(".steps-meter").find("p.active").removeClass("active"),$('[data-target="'+t+'"]').addClass("active"),$(t).animate({opacity:1},1e3),val=$(t).prev(".animated-step").outerHeight(!0),console.log(val),$(t).prev(".animated-step").animate({opacity:0,marginTop:-val},1e3,function(){$(t).prev(".animated-step").hide()})}function reverseUnhide(){return elem="#"+$(".animated-step:visible").attr("id"),"#step1"==elem?!1:(prev="#"+$(elem).prev(".animated-step").attr("id"),console.log(prev),$(".steps-meter").find("p.active").removeClass("active"),$('[data-target="'+prev+'"]').addClass("active"),$(elem).animate({opacity:0},1e3,function(){$(elem).addClass("hidden")}),$(elem).prev(".animated-step").show(),void $(elem).prev(".animated-step").animate({opacity:1,marginTop:0},1e3,function(){}))}function slideToggle(t){t.preventDefault(),target=$(t.target).attr("data-target"),$(target).slideToggle("fast",function(){var e=$(t.target).attr("data-callback");"undefined"!=typeof e&&window[e](t)})}function prepareLoadRemote(t){$(t.target).attr("data-url",$(t.target).attr("href")),"undefined"!=typeof $(t.target).closest(".load-remote").attr("data-callback")&&$(t.target).attr("data-callback",$(t.target).closest(".load-remote").attr("data-callback")),"undefined"!=typeof $(t.target).closest(".load-remote").attr("data-load-method")&&$(t.target).attr("data-load-method",$(t.target).closest(".load-remote").attr("data-load-method")),$(t.target).attr("data-target",$(t.target).closest(".load-remote").attr("data-target")),loadRemote(t)}function formToRemoteLink(t){return url=$(t.target).attr("action"),url+="?"+$(t.target).serialize(),$(t.target).attr("data-url",url),loadRemote(t),!1}function linkToRemote(t){t.preventDefault();var e=$(t.target).attr("data-nofollow");if("undefined"!=typeof e&&1==e)return!1;var a=$(t.target).attr("data-loading");if("undefined"!=typeof a&&1==a)return!1;url=$(t.target).attr("data-url");var o=$(t.target).attr("data-callback");for(elem=$(t.target),preFunction=$(t.target).attr("data-pre-function"),loadingContainer=$(t.target).attr("data-loading-container");"undefined"==typeof url;)elem=elem.parent(),url=elem.attr("data-url"),preFunction=elem.attr("data-pre-function"),o=elem.attr("data-callback"),loadingContainer=elem.attr("data-loading-container"),t.target=elem;isset(loadingContainer)?$(loadingContainer).html('<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />'):($(elem).attr("data-old-label",$(elem).html()),$(elem).html('<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />')),"undefined"!=typeof preFunction&&window[preFunction](t),$.get(url,function(e){$(t.target).attr("data-loading",0),$(elem).html($(elem).attr("data-old-label")),e=JSON.parse(e),"success"==e.status?"undefined"!=typeof o&&window[o](t,e):(console.log(e),$.bootstrapGrowl(_("An Error Occurred."),{align:"center",type:"danger"}))})}function linkToRemoteConfirm(t){for(t.preventDefault(),msg=$(t.target).attr("data-message"),elem=$(t.target);"undefined"==typeof msg;)elem=elem.parent(),msg=elem.attr("data-message");if(!confirm(msg))return!1;var e=$(t.target).attr("data-nofollow");if("undefined"!=typeof e&&1==e)return!1;var a=$(t.target).attr("data-loading");if("undefined"!=typeof a&&1==a)return!1;url=$(t.target).attr("data-url");var o=$(t.target).attr("data-callback");for(elem=$(t.target);"undefined"==typeof url;)elem=elem.parent(),url=elem.attr("data-url"),o=elem.attr("data-callback"),t.target=elem;$(elem).attr("data-old-label",$(elem).html()),$(elem).html('<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />'),$.get(url,function(e){$(t.target).attr("data-loading",0),$(elem).html($(elem).attr("data-old-label")),e=JSON.parse(e),"success"==e.status?"undefined"!=typeof o&&window[o](t,e):(console.log(e),$.bootstrapGrowl(_("An Error Occurred."),{align:"center",type:"danger"}))})}function loadRemote(t){t.preventDefault();var e=$(t.target).attr("data-nofollow");if("undefined"!=typeof e&&1==e)return!1;var a=$(t.target).attr("data-loading");if("undefined"!=typeof a&&1==a)return!1;url=$(t.target).attr("data-url"),target=$(t.target).attr("data-target");var o=$(t.target).attr("data-callback");for(elem=$(t.target),loadMethod=$(t.target).attr("data-load-method"),noPush=$(t.target).attr("data-no-push-state"),indicatorStyle=$(t.target).attr("data-indicator-style"),failSafe=0;"undefined"==typeof url;){if(elem=elem.parent(),url=elem.attr("data-url"),target=elem.attr("data-target"),o=elem.attr("data-callback"),noPush=elem.attr("data-no-push-state"),loadMethod=$(t.target).attr("data-load-method"),indicatorStyle=elem.attr("data-indicator-style"),failSafe>50)return;failSave++}$(t.target).attr("data-loading",1),"undefined"==typeof noPush&&history.pushState({},"",url),"undefined"==typeof loadMethod||"load"==loadMethod?(console.log(url),"undefined"==typeof indicatorStyle?$(target).html('<center><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></center> '):($(target).children("*").css("opacity",.1),$(target).append('<div class="small-overlay"><center><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></center></div>')),$(target).load(url,function(){$(t.target).attr("data-loading",0),"undefined"!=typeof o&&window[o](t)})):"append"==loadMethod||"prepend"==loadMethod?($(target).prepend('<p class="remove_this">'+_("loading...")+'<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></p>'),$.get(url,function(e){$(".remove_this").remove(),$(t.target).attr("data-loading",0),"append"==loadMethod?$(target).append(e):$(target).prepend(e),"undefined"!=typeof o&&window[o](t)})):"fade"==loadMethod&&($(target).addClass("disabled-item"),$(target).after("<div class='overlay-loading'></div>"),mt=$(target).height(),mt/=2,$(".overlay-loading").css("margin-top","-"+mt+"px"),$(target).load(url,function(){$(".overlay-loading").remove(),$(target).removeClass("disabled-item"),$(t.target).attr("data-loading",0),"undefined"!=typeof o&&window[o](t)}))}function loadMoreComments(t){for(t.preventDefault(),url=$(t.target).attr("data-url"),target=$(t.target).attr("data-target"),skip=$(t.target).attr("data-skip"),lesson=$(t.target).attr("data-lesson"),post_field=$(t.target).attr("data-post-field"),id=$(t.target).attr("data-id"),elem=$(t.target);"undefined"==typeof url;)elem=elem.parent(),url=elem.attr("data-url"),target=elem.attr("data-target"),callback=elem.attr("data-callback");var e=0;animationInterval=setInterval(function(){e++,document.getElementById("load-more-ajax-button").innerHTML="Loading."+new Array(e%4).join(".")},500);var a={};a.skip=skip,a[post_field]=id,$.post(url,a,function(e){$(t.target).attr("href","#"),clearInterval(animationInterval),$(t.target).html(_("LOAD MORE")),""==$.trim(e)&&($(t.target).removeClass("load-more-ajax"),$(t.target).html(_("Nothing more to load"))),$(target).append(e).fadeIn("slow"),skip=1*skip+2,$(t.target).attr("data-skip",skip)})}function loadRemoteCache(t){t.preventDefault(),url=$(t.target).attr("data-url"),target=$(t.target).attr("data-target");var e=$(t.target).attr("data-callback"),a=$(t.target).attr("data-cached-callback");for(elem=$(t.target);"undefined"==typeof url;)elem=elem.parent(),url=elem.attr("data-url"),target=elem.attr("data-target"),e=elem.attr("data-callback"),a=elem.attr("data-cached-callback");if($(target).parent().children().hide(),$(target).show(),"1"==elem.attr("data-loaded"))return"undefined"!=typeof a&&window[a](t),!1;gif='<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader-2.gif" />',customGif=$(t.target).attr("data-gif"),"undefined"!=typeof customGif&&(gif='<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/'+customGif+'" />');$(target).html(gif).css({textAlign:"center",marginBottom:0,marginTop:0});$(target).load(url,function(a,o,r){elem.attr("data-loaded","1"),elem.addClass("dataLoaded"),"undefined"!=typeof e&&window[e](t)})}function stepsScrollAnimation(){return 0==$(".animated-step").length?!1:scrollAnimationActivated?$(window).scrollTop()+$(window).height()==$(document).height()?(scrollAnimationActivated=!1,$(".animated-step:visible").find(".unhide-btn").click(),setTimeout(function(){scrollAnimationActivated=!0},2e3),!1):void(0==$(window).scrollTop()&&(scrollAnimationActivated=!1,reverseUnhide(),setTimeout(function(){scrollAnimationActivated=!0},2e3))):!1}function floatingNav(){if(0==$(".main-nav-section, .fixed-menu").length)return!1;var t=$(".main-nav-section, .fixed-menu").position().top;$(window).scroll(function(){var e=$(".main-nav-section, .fixed-menu"),a=document.documentElement.scrollTop||document.body.scrollTop;a>t&&!e.is(".filterbuttonFixed")?e.addClass("filterbuttonFixed"):t>a&&e.is(".filterbuttonFixed")&&e.removeClass("filterbuttonFixed")})}function scrollNavigation(){$(".main-nav-section a[href*=#]").each(function(){if("#video-grid"!=$(this).attr("href")&&location.pathname.replace(/^\//,"")==this.pathname.replace(/^\//,"")&&location.hostname==this.hostname&&this.hash.replace(/#/,"")){var t=$(this.hash),e=$("[name="+this.hash.slice(1)+"]"),a=t.length?t:e.length?e:!1;if(a){var o=a.offset().top;$(this).click(function(){return $("#nav li a").removeClass("active"),$(this).addClass("active"),$("html, body").animate({scrollTop:o},1e3),!1})}}}),$(window).scroll(function(){$(".parallax-1, .parallax-2").animate({backgroundPosition:"(50% -2000px)"},480)})}function addToList(t,e,a){var o=$(e.target).attr("data-destination");"undefined"!=typeof $(e.target).attr("data-prepend")&&(a=$(e.target).attr("data-prepend")),"undefined"==typeof a?$(o).append(t.html):$(o).prepend(t.html),$(e.target)[0].reset()}function updateHTML(t,e){var a=$(t.target).attr("data-target");prop=$(t.target).attr("data-property"),val=e[prop],$(a).html(val)}function showClassroomQuestion(t,e){$("#myVideo").length>0&&$("#myVideo")[0].pause();$(t.target).attr("data-target");prop=$(t.target).attr("data-property"),val=e[prop];bootbox.dialog({title:e.title,message:val})}function replaceElementWithUploaded(t,e){var a=$(t.target).attr("data-progress-bar");if($(a).find("span").html(""),$(a).css("width","0%"),result=JSON.parse(e.result),"error"==result.status)return $(t.target).after("<p class='alert alert-danger ajax-error'>"+result.errors+"</p>"),!1;var o=$(t.target).attr("data-replace");$(o).replaceWith(result.html)}function replaceElementWithReturned(t,e){var a=$(e.target).attr("data-replace");$(a).replaceWith(t.html),console.log(a),console.log(t.html)}function postedComment(t,e){$(e.target).find(".reply-to").val()>0?(count=$(e.target).closest(".comment-form-reply").parent().parent().parent().find(".number-of-replies").html(),$.trim(count),count=count.split(" "),count=count[0],count_number=count=1*count+1,count+=" "+_("reply"),$(e.target).closest(".comment-form-reply").parent().parent().parent().find(".number-of-replies").first().html(count),$(e.target).closest(".comment-form-reply").remove(),addToList(t,e)):1==$(e.target).attr("data-reverse")?addToList(t,e):addToList(t,e,!0)}function collapseComments(t){$(t.target).removeClass("load-remote"),$(t.target).addClass("slide-toggler"),$(t.target).attr("data-callback","rotateCollapse"),$(t.target).find(".fa-arrow-down").remove(),$(t.target).append(" <i class='fa fa-arrow-up fa-animated'></i>")}function rotateCollapse(t){rotation=0==rotation?180:0,$(t.target).find(".fa").rotate(rotation)}function ratedTestimonial(t,e){thumbs=$(e.target).attr("data-total"),thumbs_up=$(e.target).attr("data-up"),thumbs_down=$(e.target).attr("data-down"),id=$(e.target).attr("data-testimonial-id"),rate=$(e.target).attr("data-thumb"),already_rated="undefined"==typeof $(e.target).attr("data-rated")?!1:$(e.target).attr("data-rated"),already_rated?"up"==rate?"negative"==already_rated&&(--thumbs_down,++thumbs_up):"positive"==already_rated&&(++thumbs_down,--thumbs_up):(thumbs++,"up"==rate?++thumbs_up:++thumbs_down),1==thumbs&&($(".testimonial-"+id+"-placeholder").hide(),$(".testimonial-"+id).removeClass("hidden"),"up"==rate?($(".testimonial-"+id).find(".fa-thumbs-o-down").hide(),$(".testimonial-"+id).find(".thumbs-down-label").hide(),$(".testimonial-"+id).find(".fa-thumbs-o-up").show(),$(".testimonial-"+id).find(".thumbs-up-label").show(),$(".testimonial-"+id).find(".not-very").html(_("very"))):($(".testimonial-"+id).find(".fa-thumbs-o-up").hide(),$(".testimonial-"+id).find(".thumbs-up-label").hide(),$(".testimonial-"+id).find(".fa-thumbs-o-down").show(),$(".testimonial-"+id).find(".thumbs-down-label").show(),$(".testimonial-"+id).find(".not-very").html(_("not")))),$(".testimonial-"+id).find(".thumbs-up-label").html(thumbs_up),$(".testimonial-"+id).find(".thumbs-down-label").html(thumbs_down),$(".testimonial-"+id).find(".thumbs-total-label").html(thumbs),$('[data-testimonial-id="'+id+'"]').prop("disabled",!0),$('[data-testimonial-id="'+id+'"]').prop("disabled","disabled")}function fullScreen(){function t(){$(".lessons li a").hide(),TweenMax.to("#curriculum > div",0,{backgroundColor:"#fff"})}function e(){$("#close-button").show(),$("#curriculum > div > div").height($browserHeight),$(".lessons").height("100%"),$("#curriculum .lessons li a").show().css({top:"200px",opacity:"0"}),TweenMax.staggerTo(".module-lesson",.7,{top:"0",opacity:"1",ease:Power4.easeOut},.1),$(".jspContainer").height("90%"),$(".jspPane").css({padding:"0 0 0 1%"}),$(".classrooms-wrapper").css("background-color","#fff"),$(".jspVerticalBar").css("right","1%"),$(".classroom-content .curriculum p.lead").css({"font-size":"22px","text-align":"center","margin-bottom":"0"}),$(".classroom-content .curriculum div.view-previous-lessons").css({"line-height":"0",height:"32px","margin-bottom":"0"}),$("body").css("overflow","hidden")}function a(){$("#view-all-lessons").show(),TweenMax.to("#curriculum > div",0,{backgroundColor:"transparent"})}$browserHeight=$(window).height(),$browserWidth=$(window).width();var o={margin:"0% auto 0",position:"relative",top:"-7%",left:0,right:0,bottom:0,height:"590px",ease:Power4.easeOut},r={position:"fixed",top:"auto",left:0,bottom:0,right:0,opacity:1,margin:"0 auto",width:$browserWidth,height:$browserHeight,onStart:t,onReverseComplete:a,onComplete:e,ease:Power4.easeOut},n=TweenMax.fromTo("#curriculum > div",.7,o,r);n.pause(),$("#view-all-lessons").click(function(){n.play(),$(this).hide()}),$("#close-button").click(function(){n.reverse(),$(this).hide(),$("body").css("overflow","auto"),$(".lessons").height("400px"),$(".jspContainer").height("100%"),$(".jspPane").css({padding:"0"}),$(".classrooms-wrapper").css("background-color","#f8f8f8"),$(".jspVerticalBar").css({right:"0%"}),$(".classroom-content .curriculum p.lead").css({"font-size":"18px","text-align":"left","margin-bottom":"10px"}),$(".classroom-content .curriculum div.view-previous-lessons").css({"line-height":"64px",height:"64px","margin-bottom":"10px"})})}function skinVideoControls(){var t=$("#myVideo");if(0!=$("#myVideo").length){if(t){var e=t.innerWidth(),a=t.innerHeight();console.log("Player height is"+a),console.log("Player Width is"+e);{var o=$(".play-intro-button").outerHeight();$(".course-details-player .control-container").outerHeight()}console.log("Button height is "+o),$(".play-intro-button").css("top",a/2-o/2),(t[0].paused||t[0].ended)&&$(".play-intro-button").show()}t[0].removeAttribute("controls"),$(".control").show(),t.on("loadedmetadata",function(){$(".current").text(c(0))}),t.on("timeupdate",function(){var e=t[0].currentTime,a=t[0].duration,o=100*e/a;$(".timeBar").css("width",o+"%"),$(".current").text(c(e))});var r=function(){console.log("PLAYPAUSE"),t[0].paused||t[0].ended?(console.log("playing the vid"),$(".btnPlay").addClass("playing").removeClass("paused"),$(".btnPlay .wa-play").hide(),$(".btnPlay .wa-pause").show(),t[0].play(),$(".centered-play-button, .play-intro-button").hide()):(console.log("pausing the vid"),$(".btnPlay").removeClass("playing").addClass("paused"),$(".btnPlay .wa-play").show(),$(".btnPlay .wa-pause").hide(),t[0].pause(),$(".centered-play-button, .play-intro-button").show())};t.off("click"),t.on("click",function(){r()}),$(".btnPlay, .centered-play-button, .play-intro-button").off("click"),$(".btnPlay, .centered-play-button, .play-intro-button").on("click",function(){r(),$("#lesson-video-overlay").hide()}),$("#bckgrd-video-container .centered-play-button").on("click",function(){$("#bckgrd-video-container #bckgrd-video-overlay").hide();var e=t[0].videoHeight;$("#bckgrd-video-container").css("height",e+95),$(".video-container .control div.btnFS").hide()}),$(".btnFS").on("click",function(){$.isFunction(t[0].webkitEnterFullscreen)?t[0].webkitEnterFullscreen():$.isFunction(t[0].mozRequestFullScreen)?t[0].mozRequestFullScreen():alert("Your browsers doesn't support fullscreen")}),$(".sound").off("click"),$(".sound").click(function(){console.log("SOUNDCLICKING!"),console.log(t[0].muted),t[0].muted=!t[0].muted,$(this).toggleClass("muted"),console.log(t[0].muted),t[0].muted?($(".volumeBar").css("width",0),$(".wa-sound").hide(),$(".fa.fa-volume-off").show()):($(".volumeBar").css("width",100*t[0].volume+"%"),$(".wa-sound").show(),$(".fa.fa-volume-off").hide())});var n=!1;t.on("canplaythrough",function(){n=!0}),t.on("ended",function(){$(".btnPlay").removeClass("playing"),t[0].pause()}),t.on("seeked",function(){});var i=!1;$(".videoContainer .progress").on("mousedown",function(t){i=!0,l(t.pageX)}),$(document).on("mouseup",function(t){i&&(i=!1,l(t.pageX))}),$(document).on("mousemove",function(t){i&&l(t.pageX)});var l=function(e){var a=$(".videoContainer .progress");t=$("#myVideo");var o=t[0].duration;console.log("MAXDURATION IS "+o);var r=e-a.offset().left,n=100*r/a.width();n>100&&(n=100),0>n&&(n=0),$(".timeBar").css("width",n+"%"),ct=o*n/100,console.log(" CURRENT TIME IS: "+ct),t.currentTime=ct,console.log("Updated TIME IS: "+t.currentTime)},s=!1;$(".volume").on("mousedown",function(e){s=!0,t[0].muted=!1,$(".sound").removeClass("muted"),d(e.pageX)}),$(document).on("mouseup",function(t){s&&(s=!1,d(t.pageX))}),$(document).on("mousemove",function(t){s&&d(t.pageX)});var d=function(e,a){var o,r=$(".volume");if(a)o=100*a;else{var n=e-r.offset().left;o=100*n/r.width()}o>100&&(o=100),0>o&&(o=0),$(".volumeBar").css("width",o+"%"),t[0].volume=o/100,0==t[0].volume?($(".sound").removeClass("sound2").removeClass("sound3").addClass("muted"),$(".wa-sound").hide(),$(".fa.fa-volume-off").show()):t[0].volume>0&&t[0].volume<.6?($(".sound").removeClass("muted").removeClass("sound3").addClass("sound2"),$(".wa-sound").show(),$(".fa.fa-volume-off").hide()):t[0].volume>.6&&($(".sound").removeClass("sound2").removeClass("muted").addClass("sound3"),$(".wa-sound").show(),$(".fa.fa-volume-off").hide())},c=function(t){var e=Math.floor(t/60)<10?"0"+Math.floor(t/60):Math.floor(t/60),a=Math.floor(t-60*e)<10?"0"+Math.floor(t-60*e):Math.floor(t-60*e);return e+":"+a};loop_failsafe=0;var u=function(){t=$("#myVideo"),duration=t[0].duration,console.log("DURATION IS  "+t[0].duration),$(".duration").text(c(t[0].duration)),loop_failsafe++,loop_failsafe>10||isNaN(duration)&&setTimeout(u,100)};return u(),d(0,.7),!0}}function insertSelectBorder(){$(".use-existing-preview .select-border").off("click"),$(".use-existing-preview .select-border").on("click",function(){$(this).toggleClass("display-border"),$(this).hasClass("display-border")&&($(".use-existing-preview .select-border").not(this).removeClass("display-border"),$(this).parent().find('input[type="radio"]').prop("checked",!0))})}function delayedKeyup(t){delay(window[$(t.target).attr("data-callback")],$(t.target).attr("data-delay"),$(t.target))}function askTeacherQuestion(){var t=$("#lesson-ask-teacher-section").height(),e=$("#lesson-ask-teacher-section").width(),a=TweenMax.fromTo(".no-teacher-questions",1e-6,{height:0,width:0},{display:"block",height:t,width:e}),o=TweenMax.to(".no-teacher-questions > div",.3,{transform:"scale(1)"});o.pause(),a.pause(),$("#lesson-ask-teacher-section").show(),$("#show-teacher-questions").on("click",function(){$("#lesson-ask-teacher-section").hasClass("hide-teacher-questions")?($("#lesson-ask-teacher-section").removeClass("hide-teacher-questions"),o.play(),a.play()):($("#lesson-ask-teacher-section").addClass("hide-teacher-questions"),o.reverse(),a.reverse())})}function searchFormFocusStyle(){$(".course-search-section .course-search-form input").on("focus",function(){$(".course-search-section .course-search-form form").css({border:"solid 1px #abd82a",boxShadow:"0px 0px 7px 1px #abd82a"}),$(this).attr("placeholder","")}),$(".course-search-section .course-search-form input").on("blur",function(){$(".course-search-section .course-search-form form").css({border:"solid 1px #fff",boxShadow:"none"}),$(this).attr("placeholder","E.g. Javascript, online business, etc ...")}),$(".comment-section .comment-box form textarea").on("focus",function(){$(this).data("placeholder",$(this).attr("placeholder")),$(this).attr("placeholder","")}),$(".comment-section .comment-box form textarea").on("blur",function(){$(this).attr("placeholder",$(this).data("placeholder"))})}function showMoreContent(){$(".expandable-button").each(function(){var t=$(this),e=t.parent().children(".expandable-content");console.log(t),console.log(e);var a=e[0].clientHeight,o=e[0].scrollHeight-1;e.css("height",a),console.log(o),console.log(a),o>a?t.show():t.hide(),$(".course-description p").each(function(){$(this).text().trim().length||$(this).addClass("no-margin")}),t.is(":visible")?t.parent().find(".fadeout-text").show():t.parent().find(".fadeout-text").hide(),t.html('<i class="fa fa-chevron-down"></i>'+t.attr("data-more-text")),t.on("click",function(){return t.hasClass("show-more")?(t.removeClass("show-more"),t.addClass("show-less"),t.siblings(".fadeout-text").hide(),e.css("max-height","none"),t.html('<i class="fa fa-chevron-up"></i>'+t.attr("data-less-text")),TweenMax.fromTo(e,0,{height:a},{height:o})):t.hasClass("show-less")&&(t.removeClass("show-less"),t.addClass("show-more"),t.siblings(".fadeout-text").show(),t.html('<i class="fa fa-chevron-down"></i>'+t.attr("data-more-text")),TweenMax.fromTo(e,0,{height:o},{height:a})),!1})})}function rescaleBckgrdOverlay(){var t=$("#user-data-bckgrd-img").css("height"),e=$("#user-data-bckgrd-img").css("width");$(".background-image-overlay").css("height",t),$(".background-image-overlay").css("width",e)}function round2(t,e){return Math.round(t/e)*e}function xmlToJson(t){var e={};if(1==t.nodeType){if(t.attributes.length>0){e["@attributes"]={};for(var a=0;a<t.attributes.length;a++){var o=t.attributes.item(a);e["@attributes"][o.nodeName]=o.nodeValue}}}else 3==t.nodeType&&(e=t.nodeValue);if(t.hasChildNodes())for(var r=0;r<t.childNodes.length;r++){var n=t.childNodes.item(r),i=n.nodeName;if("undefined"==typeof e[i])e[i]=xmlToJson(n);else{if("undefined"==typeof e[i].push){var l=e[i];e[i]=[],e[i].push(l)}e[i].push(xmlToJson(n))}}return e}function toggleSideMenu(){$("body").delegate(".slide-menu-toggler","click",function(){$(".slide-menu").toggleClass("in")})}function toggleRightBar(t,e){if(isset(e)&&"undefined"!=typeof t&&"undefined"!=typeof $(t.target).attr("data-property")&&$(".right-slide-menu").hasClass("in")){var a=$(t.target).attr("data-target");return prop=$(t.target).attr("data-property"),val=e[prop],$(a).html(val),!1}if(!isset(e)&&isset(t)&&"undefined"!=typeof $(t.target).attr("data-property")&&$(".right-slide-menu").hasClass("in"))return!1;if($(".play-intro-button").hide(),$(".right-slide-menu").toggleClass("in"),$(".slide-to-left").toggleClass("in"),$("body").toggleClass("discussion-opened"),setTimeout(skinVideoControls,501),!isset(e))return!1;if("undefined"!=typeof t){$("#myVideo").length>0&&$("#myVideo")[0].pause();var a=$(t.target).attr("data-target");prop=$(t.target).attr("data-property"),val=e[prop],$(a).html(val)}}function colorLinks(t){color=$(t.target).attr("data-color"),elem=$(t.target).attr("data-elem"),$(elem).removeClass("active"),$(t.target).addClass("active")}function searchDiscussions(){s=$("#question-search-box").val(),$(".questions-box").hide(),$('span:contains("'+s+'")').parent().show()}function showLessonQuestionForm(){$(".right-slide-menu").html($("#question-form").html()),toggleRightBar()}function LessonQuestionAddToList(t,e){addToList(t,e),toggleRightBar()}function scrollToElement(t){t.preventDefault(),target=$(t.target).attr("data-target"),$("html, body").animate({scrollTop:$(target).offset().top},400)}function toggleAffiliateToolbar(t){$("div.affiliate-toolbar").toggleClass("minimized"),$("div.affiliate-toolbar").toggleClass("tooltipable"),$("div.affiliate-toolbar").toggleClass("affiliate-toolbar-toggler"),$(".affiliate-toolbar-toggler-btn").toggleClass("affiliate-toolbar-toggler"),$(".tooltipable").tooltip(),hideAffiliateToolbar=!hideAffiliateToolbar,document.cookie="hideAffiliateToolbar="+hideAffiliateToolbar}function getCookie(t){for(var e=t+"=",a=document.cookie.split(";"),o=0;o<a.length;o++){for(var r=a[o];" "==r.charAt(0);)r=r.substring(1);if(0==r.indexOf(e))return r.substring(e.length,r.length)}return""}function charactersLeft(t){elem=$(t.target),limit=$(elem).attr("maxlength"),current=$(elem).val().length,remaining=limit-current,display=$(elem).attr("data-target"),$(display).html(remaining)}function enableCharactersLeft(){$(".characters-left").each(function(){$(this).keyup()})}function toggleTheClass(t){$source=$(t.target),dest=$source.attr("data-target"),cls=$source.attr("data-class"),$(dest).toggleClass(cls)}function toggleVisibility(t){$source=$(t.target),dest=$source.attr("data-target"),hide=$source.attr("data-visible"),"hide"==hide?($source.attr("data-visible","show"),$(dest).hide()):($source.attr("data-visible","hide"),$(dest).show())}function typeInElemens(t){elem=$(t.target).attr("data-elements"),$(elem).html($(t.target).val())}function calculateFileSizes(){$(".calculate-file-size").each(function(){id=$(this).attr("data-id"),obj=$(this),$.get(COCORIUM_APP_PATH+"blocks/"+id+"/size",function(t){t=JSON.parse(t),$obj=$(".calculate-file-size-"+t.id),console.log($obj),$obj.html(t.val),console.log(t.val),$obj.removeClass("calculate-file-size")})})}function showFiles(t,e){t.preventDefault(),t.stopPropagation(),$(e).slideToggle()}function enableRTE(t,e){"undefined"==typeof e&&(e=function(){}),tinymce.remove(t),tinymce.init({setup:function(t){t.on("change",e)},menu:{},language:"ja",language_url:COCORIUM_APP_PATH+"js/lang/tinymce/ja.js",autosave_interval:"20s",autosave_restore_when_empty:!0,selector:t,save_onsavecallback:function(){return savingAnimation(0),$(t).closest("form").submit(),savingAnimation(1),!0},plugins:["advlist autolink autosave lists link image charmap print preview anchor","searchreplace visualblocks code fullscreen","insertdatetime media table contextmenu paste save"],toolbar:"bold | bullist numlist",statusbar:!1})}function wishlistChange(t){return t.preventDefault(),t.stopPropagation(),$target=$(t.target),0==$target.attr("data-auth")?($target.attr("data-original-title",_("Login to add to wishlist")),$target.animate({"margin-left":"-5px"},50).animate({"margin-left":"+5px"},50).animate({"margin-left":"-5px"},50).animate({"margin-left":"0px"},50),!1):(url=$target.attr("data-url"),state=1==$target.attr("data-state")?0:1,$target.attr("data-state",state),0==state?($target.addClass("fa-heart-o"),$target.removeClass("fa-heart"),$target.attr("data-original-title",_("Add to wishlist"))):($target.removeClass("fa-heart-o"),$target.addClass("fa-heart"),$target.attr("data-original-title",_("Remove from wishlist"))),void $.get(url+"/"+state,function(){}))}var COCORIUM_APP_PATH="//"+document.location.hostname+"/";$(document).ready(function(){console.log(getCookie("hideAffiliateToolbar")),"true"==getCookie("hideAffiliateToolbar")&&toggleAffiliateToolbar(event),$(".countdown").each(function(){seconds=$(this).attr("data-final-date-seconds"),time=moment().add(seconds,"seconds").format("YYYY/MM/DD HH:mm:ss"),time=time.toString(),console.log(time),$(this).countdown(time,function(t){$(this).html(t.strftime("%D days %H:%M:%S"))})}),$(".tooltipable").tooltip(),enableClipboard(),$("#curriculum .lessons").jScrollPane(),$(".profile-name > li").removeClass("activate-dropdown"),$("body").delegate(".type-in-elements","keyup",typeInElemens),$("body").delegate(".characters-left","keyup",charactersLeft),$("body").delegate(".scroll-to-element","click",scrollToElement),$("body").delegate(".slide-toggler","click",slideToggle),$("body").delegate("a.load-remote","click",loadRemote),$("body").delegate("a.link-to-remote","click",linkToRemote),$("body").delegate("a.link-to-remote-confirm","click",linkToRemoteConfirm),$("body").delegate(".form-to-remote-link","submit",formToRemoteLink),$("body").delegate(".load-remote a","click",prepareLoadRemote),$("body").delegate("a.load-more-ajax","click",loadMoreComments),$("body").delegate("a.load-remote-cache","click",loadRemoteCache),$("body").delegate(".btnLink","click",goTo),$("body").delegate("#video-grid .boxes","mouseenter",videoGridBoxIn),$("body").delegate("#video-grid .boxes","mouseleave",videoGridBoxOut),$("body").delegate(".delayed-keyup","keyup",delayedKeyup),$("button.join-class").mousedown(function(){$(this).addClass("pushdown")}),$("button.join-class").mouseup(function(){$(this).removeClass("pushdown")}),$(window).scroll(stepsScrollAnimation),floatingNav(),scrollNavigation(),fullScreen(),skinVideoControls(),insertSelectBorder(),askTeacherQuestion(),searchFormFocusStyle(),showMoreContent(),toggleSideMenu(),rescaleBckgrdOverlay(),$(window).resize(function(){rescaleBckgrdOverlay(),skinVideoControls()}),$(".classroom-view #myVideo").resize(function(){skinVideoControls()})});var unique_numbers=new Array;scrollAnimationActivated=!0,$.fn.scrollToChild=function(t){this.css("color","green"),this.scrollTop(this.scrollTop()+$(t).position().top-$(t).height())};var rotation=0;jQuery.fn.rotate=function(t){return $(this).css({"-webkit-transform":"rotate("+t+"deg)","-moz-transform":"rotate("+t+"deg)","-ms-transform":"rotate("+t+"deg)",transform:"rotate("+t+"deg)"}),$(this)};var delay=function(){var t=0;return function(e,a,o){clearTimeout(t),t=setTimeout(e,a,o)}}();$.expr[":"].contains=$.expr.createPseudo(function(t){return function(e){return $(e).text().toUpperCase().indexOf(t.toUpperCase())>=0}}),$("body").on("click",".affiliate-toolbar-toggler",toggleAffiliateToolbar);var hideAffiliateToolbar=!1;$("body").delegate(".wishlist-change-button","click",wishlistChange);