    @extends('layouts.default')
    @section('content')	
        <div class="classrooms-wrapper">
        	<section class="video-container">
                <!--<video>
                
                </video>-->
                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/sample-video-poster.jpg" class="img-responsive" alt="">
                <span class="centered-play-button"></span>
                <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                    <span class="sr-only">60% Complete</span>
                  </div>
                </div>
                <div class="video-controls">
                	<div>
                        <div class="volume-control">
                            <div>
                                <div class="volume-bar">
                                    <span></span>
                                </div>
                            </div>
                            <span class="caret"></span>
                        </div>
                    	<span class="play-button"></span>
                        <span class="volume-button"></span>
                        <span class="full-screen-button"></span>
                    </div>
                </div>
            </section>
            <section class="classroom-content container">
            	<div class="row">
                	<div class="col-md-6">
                    	<div class="header blue clearfix">
                        	<h2>ASK<small>THE TEACHER</small></h2>
                            <div class="avater hidden-xs">
                            	<p class="quote">You can ask me anything!</p>
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/teacher-avater-2.png" 
                                class="img-circle img-responsive">
                            </div>                        	
                        </div>
                        <p class="lead">Lesson Notes</p>
                        <div class="white-box">
                        	<div class="clearfix">
                            	<p class="lead"><span>Lesson 1</span>	Making your first splash page</p>
                                <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod te
								tmpor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
                                laboris nisi ut aliquip ex
                                </p>
                            	<p class="lead"><span>Lesson 1</span>	Making your first splash page</p>
                                <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod te
								tmpor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                </p>
                            </div>
                            <span class="view-curriculum">Vieuw full curriculum</span>
                        </div>
                    </div>
                	<div class="col-md-6">
                    	<div class="header green clearfix">
                        	<h2>BEGIN<small>FIRST LESSON</small></h2>
                        </div>
                        <p class="lead">In the next lesson you will learn</p>
                        <div class="white-box">
                        	<ul>
                            	<li>What javascript is</li>
                            	<li>What is the next web</li>
                            	<li>How does it all work</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row classmate-conversations-heading">
                	<div class="col-md-12">
                        <p class="lead">Classmate conversations</p>
                    </div>
                </div>
                <div class="row comment-section clearfix">
                	<div class="col-md-12">
                    	<div class="comment-box clearfix">
                        	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-1.png" 
                            class="img-circle img-responsive" alt="">
                        	<form>
                                <textarea></textarea>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-12">
                    	<div class="users-comments">
                        	<div class="clearfix">
                                <div class="comment clearfix clear">
                                    <div class="info clearfix clear">
                                        <span class="name">Bas Mooreland</span>
                                        <a href="#" class="reply-link">Reply</a>
                                        <span class="number-of-replies">14 others replied</span>
                                        <span class="time-of-reply">10 hours ago</span>
                                    </div>
                                    <div class="main clearfix clear">
                                        <img class="img-responsive img-circle" alt="" 
                                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-2.png">
                                        <span>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore 
                                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
                                        </span>
                                    </div>
                                </div>
                                <div class="comment reply clearfix clear">
                                    <div class="info clearfix clear">
                                        <span class="name">Anabelle Jackson</span>
                                        <a href="#" class="reply-link">Reply</a>
                                        <span class="time-of-reply">10 hours ago</span>
                                    </div>
                                    <div class="main clearfix clear">
                                        <img class="img-responsive img-circle" alt="" 
                                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-3.png">
                                        <span>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore 
                                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                        </span>
                                    </div>
                                </div>
                                <div class="comment clearfix clear">
                                    <div class="info clearfix clear">
                                        <span class="name">Bas Mooreland</span>
                                        <a href="#" class="reply-link">Reply</a>
                                        <span class="number-of-replies">14 others replied</span>
                                        <span class="time-of-reply">10 hours ago</span>
                                    </div>
                                    <div class="main clearfix clear">
                                        <img class="img-responsive img-circle" alt="" 
                                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-2.png">
                                        <span>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore 
                                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="load-more-comments">LOAD MORE</span>
                    </div>
                </div>
                <div class="row curriculum">
                	<div class="col-md-12">
                    	<div>
                        	<p class="lead">Curriculum</p>
                            <div class="view-previous-lessons">view previous lessons</div>
                            <ul class="lessons">
                                <li>
                                    <a href="#" class="lesson-1">
                                        <span>Lesson 1</span>
                                        <p>Creating a splash screen with javascript</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="lesson-2">
                                        <span>Lesson 2</span>
                                        <p>Introduction</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="lesson-3">
                                        <span>Lesson 3</span>
                                        <p>Your very first</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="lesson-4">
                                        <span>Lesson 4</span>
                                        <p>Time to show it off!</p>
                                    </a>
                                </li>
                            </ul>
                            <div class="custom-scrollbar">
                            	<span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="container-fluid become-an-instructor">
                <div class="container">
                  <div class="row">
                    <div class="col-xs-12">
                      <h1>BECOME</h1>
                      <h2>AN INSTRUCTOR</h2>
                      <a href="{{ action('InstructorsController@become') }}"><span>{{trans('site/homepage.get-started')}}</span></a>
                    </div>
                  </div>
              </div>
            </section>
        </div>

    @stop