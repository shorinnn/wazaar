    @extends('layouts.default')
    @section('content')	
    
        <div class="classrooms-wrapper questions">
        	<div class="fixed-menu">
            	<div class="clearfix">
                	<div class="instructor">
                    	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/teacher-avater.png" />
                        <h3>Melissa Quan<span></span></h3>
                        <p>Lead programmer, Wazaar</p>
                    </div>
                    <div class="buttons">
                    	<a href="#" class="contact-button">contact</a>
                    	<a href="#" class="follow-button">follow</a>
                    </div>
                </div>
            </div>
            <section class="classroom-content container">
            	<div class="row">
                	<div class="col-md-12">
                    	<div class="top-buttons clearfix">
                        	<a href="#" class="dashboard-button">Dashboard</a>
                        	<a href="#" class="questions-button">Questions<span class="notification">3</span></a>
                        	<a href="#" class="comments-button">Comments</a>
                        	<a href="#" class="compliments-button">Compliments</a>
                        </div>
                        <div class="dropdown-container clearfix">
                            <div class="menu-dropdown dropdown-2">
                                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" id="btnGroupDrop1">
                                </button>
                                <ul aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu">
                                    <li>
                                        <a class="#" href="#">Dropdown text</a>
                                    </li>
                                    <li>
                                        <a class="#" href="#">Dropdown text</a>
                                    </li>
                                    <li>
                                        <a class="#" href="#">Dropdown text</a>
                                    </li>
                                    <li>
                                        <a class="#" href="#">Dropdown text</a>
                                    </li>
                                </ul>
                            </div>                        
                        </div>
                    </div>
                </div>
               <div class="row">
                	<div class="col-md-12">
                    	<div class="users-comments clearfix">
                            <div class="title clearfix">
                                <p class="lesson-chapter">Lesson: Chapter 1 - Loops</p>
                                <a href="#" class="view-in-lesson">VIEW IN LESSON</a>
                            </div>
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
                            <a href="#" class="reply-button">REPLY</a>
	                        <a href="#" class="mark-as-resolved">MARK AS RESOLVED</a>
                        </div>
                    </div>
                </div>
               <div class="row">
                	<div class="col-md-12">
                    	<div class="users-comments clearfix">
                            <div class="title clearfix">
                                <p class="lesson-chapter">Lesson: Chapter 1 - Loops</p>
                                <a href="#" class="view-in-lesson">VIEW IN LESSON</a>
                            </div>
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
                            </div>
                            <a href="#" class="reply-button">REPLY</a>
                        </div>
                    </div>
                </div>
	            <a href="#" class="load-more-comments">LOAD MORE</a>
                <div class="row"> <div data-load-method="fade" data-target=".ajax-content" class="col-md-12 load-remote"> <div class="pagination pagination-container clearfix">
                    <div class="page-numbers-container clearfix">
                        <ul class="clearfix">
                        	<li>
                            	<a href="" class="prev"></a>
                            </li>
                            <li>
                            	<a class="active" href="">1</a>
                            </li>
                            <li>
                            	<a href="http://wazaar.dev/administration/members?page=2">2</a>
                            </li>
                            <li>
                            	<a href="http://wazaar.dev/administration/members?page=3">3</a>
                            </li>
                            <li>
                            	<a href="http://wazaar.dev/administration/members?page=4">4</a>
                            </li>
                            <li>
                            	<a href="http://wazaar.dev/administration/members?page=5">5</a>
                            </li>
                            <li>
                            	<a href="http://wazaar.dev/administration/members?page=6">6</a>
                            </li>
                            <li>
                            	<a href="http://wazaar.dev/administration/members?page=2" class="next"></a>
                            </li>            
                    	</ul>
                    </div>
            	</div>
            </section>
                        
            @if(Auth::guest() || !Auth::user()->hasRole('Instructor'))
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
            @endif
        </div>

@stop
