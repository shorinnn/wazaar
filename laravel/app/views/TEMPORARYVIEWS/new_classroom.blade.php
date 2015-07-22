@extends('layouts.default')
@section('content')	
	<div class="container-fluid classroom-view">
    	<style>
			header, footer{
				display: none;
			}
		</style>
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            	<div class="classroom-header row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <span class="left-menu">
                            <i class="wa-hamburger"></i>
                        </span>
                        <a href="3" class="logo">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive">
                        </a>
                        <h4 class="lesson-title">1.1. Welcome to Marketing in a Digital world</h4>
                        <div class="navigate-lessons-buttons">
                            <a href="#" class="prev-button"><i class="wa-chevron-left"></i></a>
                            <a href="#" class="next-button">Next lesson <i class="wa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="video-player video-container classroom-video" style="background:none; text-align: right">
                                <div class="videoContainer">
                                    <video id="myVideo" preload="auto">
                                        <source src="#" type="video/mp4">
                                        <p>Your browser does not support the video tag.</p>
                                    </video> 
                                    <div class="control-container clearfix">                       
                                        <div class="control">
                                            
                                            <div class="btmControl clearfix">
                                                <div class="btnPlay btn" title="Play/Pause video">
                                                	<i class="wa-play"></i>
                                                    <i class="wa-pause"></i>
                                                </div>
                                                <div class="time hidden-xs">
                                                    <span class="current"></span>
                                                </div>
                                                <div class="topControl">
                                                    <div class="progress">
                                                        <span class="bufferBar"></span>
                                                        <span class="timeBar"></span>
                                                    </div>
                                                <div class="add-video-note">
                                                	<span class="note-number">11</span>
                                                    <form>
                                                    	<input type="text" placeholder=" Add note ...">
                                                    </form>
                                                </div>
                                                </div>
                                                <div class="volume-container">
                                                    <div class="volume" title="Set volume">
                                                        <span class="volumeBar">
                                                            <em></em>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="time hidden-xs">
                                                    <span class="duration"></span> 
                                                </div>
                                                <div class="sound sound2 btn hidden-xs" title="Mute/Unmute sound">
                                                	<i class="wa-sound"></i>
                                                    <i class="fa fa-volume-off"></i>
                                                </div>
                                                <div class="btnFS btn" title="Switch to full screen"><i class="wa-expand"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="loading"></div>
                                </div>
                                <!--<div id="lesson-video-overlay">
                                    <div>
                                    </div>
                                </div>-->
                                <span class="play-intro-button"><i class="wa-play"></i><em>{{ trans("courses/general.play-intro") }}</em></span>
                       	</div>                    
                    </div>
                </div>
            </div>
        	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            	<div class="questions-sidebar">
                	<div class="header clearfix">
                    	<a href="#" class="questions-tab-header active">45 Questions</a>
                        <a href="#" class="notes-tab-header">10 Notes</a>
                    </div>
                    <div class="tab-contents clear">
                    	<div class="rows search-discussion-form">
                        	<form>
                            	<div>
                                	<input type="search" placeholder="Search discussion ...">
                                    <button><i class="wa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="rows questions-box">
                        	<span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="rows questions-box">
                        	<span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="rows questions-box">
                        	<span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="rows questions-box">
                        	<span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="rows questions-box">
                        	<span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="ask-question">
                        	<div class="img-container">
                        		<img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                            </div>
                            <span>Ask a question</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="container-fluid classroom-view margin-top-20">
    	<style>
			header, footer{
				display: none;
			}
		</style>
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 vcenter">
            	<div class="classroom-header row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <span class="left-menu">
                            <i class="wa-hamburger"></i>
                        </span>
                        <a href="3" class="logo">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive">
                        </a>
                        <h4 class="lesson-title">1.1. Welcome to Marketing in a Digital world</h4>
                        <div class="navigate-lessons-buttons hide">
                            <a href="#" class="prev-button"><i class="wa-chevron-left"></i></a>
                            <a href="#" class="next-button">Next lesson <i class="wa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="video-player video-container classroom-video" style="background:none; text-align: right">
                                <div class="videoContainer">
                                    <video id="myVideo" preload="auto">
                                        <source src="#" type="video/mp4">
                                        <p>Your browser does not support the video tag.</p>
                                    </video> 
                                    <div class="control-container clearfix hide">                       
                                        <div class="control">
                                            
                                            <div class="btmControl clearfix">
                                                <div class="btnPlay btn" title="Play/Pause video">
                                                	<i class="wa-play"></i>
                                                    <i class="wa-pause"></i>
                                                </div>
                                                <div class="time hidden-xs">
                                                    <span class="current"></span>
                                                </div>
                                                <div class="topControl">
                                                    <div class="progress">
                                                        <span class="bufferBar"></span>
                                                        <span class="timeBar"></span>
                                                    </div>
                                                <div class="add-video-note">
                                                	<span class="note-number">11</span>
                                                    <form>
                                                    	<input type="text" placeholder=" Add note ...">
                                                    </form>
                                                </div>
                                                </div>
                                                <div class="volume-container">
                                                    <div class="volume" title="Set volume">
                                                        <span class="volumeBar">
                                                            <em></em>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="time hidden-xs">
                                                    <span class="duration"></span> 
                                                </div>
                                                <div class="sound sound2 btn hidden-xs" title="Mute/Unmute sound">
                                                	<i class="wa-sound"></i>
                                                    <i class="fa fa-volume-off"></i>
                                                </div>
                                                <div class="btnFS btn" title="Switch to full screen"><i class="wa-expand"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="loading"></div>
                                </div>
                                <!--<div id="lesson-video-overlay">
                                    <div>
                                    </div>
                                </div>-->
                                <!--<span class="play-intro-button"><i class="wa-play"></i><em>{{ trans("courses/general.play-intro") }}</em></span>-->
                       	</div>                    
                    </div>
                </div>
            </div>
        	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            	<div class="questions-sidebar">
                	<div class="header clearfix">
                    	<a href="#" class="questions-tab-header active">45 Questions</a>
                        <a href="#" class="notes-tab-header">10 Notes</a>
                    </div>
                    <div class="tab-contents clear">
                    	<div class="rows search-discussion-form">
                        	<form>
                            	<div>
                                	<input type="search" placeholder="Search discussion ...">
                                    <button><i class="wa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="rows questions-box">
                        	<span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="rows questions-box">
                        	<span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="rows questions-box">
                        	<span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="rows questions-box">
                        	<span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="rows questions-box">
                        	<span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="ask-question">
                        	<div class="img-container">
                        		<img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                            </div>
                            <span>Ask a question</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 no-padding">
            	<div class="discussion-sidebar">
                	<div class="discussion-sidebar-header">
                    	<h2>What are the best resources for learning bleeding-edge web, UI and UX design?</h2>
                        <span class="close-tab"><i class="fa fa-times"></i></span>
                    </div>
                    <div class="questioner">
                    	<div class="questioner-info">
                            <div class="avatar">
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                            </div>
                            <span class="name block">Mac Chinedu</span>
                            <span class="role">Web Developer</span>
                            <div class="question clear">
                                <p class="regular-paragraph">
                                    I'm looking for any kind of resource, including those that are highly technical, those directed to 
                                    experienced UI/UX designers, and just interesting philosophical works that inform awesome modern/current 
                                    web UIs/UXs (like Quora's!).
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="replies-container clearfix">
                        <div class="avatar">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                        </div>
                        <div class="replies-box">
                            <div class="clearfix">
                                <span class="name">Mac Chinedu</span>
                                <div class="role teacher">Teacher</div>
                            </div>
                            <p class="reply">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                            UI/UX designers, and just interesting philosophical works that inform awesome modern/current web UIs/UXs (like Quora's!).</p>
                            <p class="reply">There is a difference between UI design and UX design. </p>
                        </div>
                    </div>
                    <div class="replies-container clearfix">
                        <div class="avatar">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                        </div>
                        <div class="replies-box">
                            <div class="clearfix">
                                <span class="name">Mac Chinedu</span>
                                <div class="role others">Co-founder @ trydesignlab.com</div>
                            </div>
                            <p class="reply">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                            UI/UX designers, and just interesting philosophical works that inform awesome modern/current web UIs/UXs (like Quora's!).</p>
                            <p class="reply">There is a difference between UI design and UX design. </p>
                        </div>
                    </div>
                    <div class="replies-container clearfix">
                        <div class="avatar">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                        </div>
                        <div class="replies-box">
                            <div class="clearfix">
                                <span class="name">Mac Chinedu</span>
                                <div class="role others">Co-founder @ trydesignlab.com</div>
                            </div>
                            <p class="reply">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                            UI/UX designers, and just interesting philosophical works that inform awesome modern/current web UIs/UXs (like Quora's!).</p>
                            <p class="reply">There is a difference between UI design and UX design. </p>
                        </div>
                    </div>
                    <div class="discussion-sidebar-footer">
                        <div class="avatar">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                        </div>
                        <form>
                        	<input type="text" placeholder="Write you answer" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
