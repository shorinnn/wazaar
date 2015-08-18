@extends('layouts.default')
@section('content')
	<div class="container-fluid new-dashboard instructor-course top-section">
    	<div class="container">
            <div class="row">
                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                    <div class="profile-picture-holder">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" class="img-responsive">
                    </div>
                </div>
                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9">
                	<a href="#" class="back-to-courses"><i class="wa-chevron-left"></i>Back to courses</a>
                	<h1>UX Design fundamentals</h1>
                    <p>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard dashboardTabs-header">
    	<div class="container">
        	<div class="row">
            	<div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <ul class="nav nav-pills left" role="tablist">
                        <li role="presentation" class="active">
                        	<a href="#discussions" role="tab" id="teaching-tab" data-toggle="tab" aria-controls="enrolled" aria-expanded="true">246 Discussions</a>
                        </li>
                        <li role="presentation" class="">
                        	<a href="#questions" role="tab" id="enrolled-tab" data-toggle="tab" aria-controls="enrolled" aria-expanded="true">5 Questions</a>
                        </li>
                        <li role="presentation">
                        	<a href="#students" role="tab" id="finished-tab" data-toggle="tab" aria-controls="finished">118 Students</a>
                        </li>
                    </ul> 
                    <a href="#" class="right add-new-course large-button blue-button"><i class="fa fa-edit"></i> Edit course</a>              
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard instructor-course">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="tab-content margin-top-25">
                      <div role="tabpanel" class="tab-pane fade in active" id="discussions">
                        <div class="row no-margin">
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 no-margin message-preview-wrap">
                                <div class="row message-header">
                                    <div class="col-xs-3 col-sm-3 col-md-4 col-lg-4">
                                        <h3>Topics</h3>
                                    </div>
                                    <div class="col-xs-9 col-sm-9 col-md-8 col-lg-8">
                                        <form>
                                            <div>
                                                <input type="search" placeholder="Search conversations ..." />
                                                <button><i class="wa-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row message-preview active">
                                	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                    	<div class="">
                                        	<h3><a href="#">Help with course creation</a></h3>
                                            <p>By <span class="name">Jeremy Wong</span> <span class="last-reply">Last reply 2 days ago</span></p>
                                        </div>
                                    </div>
                                	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    	<span class="number-of-replies">47<i class="fa fa-reply"></i></span>
                                    </div>
                                </div>
                                <div class="row message-preview unread">
                                	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                    	<div class="">
                                        	<h3><a href="#">Help with course creation</a></h3>
                                            <p>By <span class="name">Jeremy Wong</span> <span class="last-reply">Last reply 2 days ago</span></p>
                                        </div>
                                    </div>
                                	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    	<span class="number-of-replies">47<i class="fa fa-reply"></i></span>
                                    </div>
                                </div>
                                <div class="row message-preview">
                                	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                    	<div class="">
                                        	<h3><a href="#">Help with course creation</a></h3>
                                            <p>By <span class="name">Jeremy Wong</span> <span class="last-reply">Last reply 2 days ago</span></p>
                                        </div>
                                    </div>
                                	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    	<span class="number-of-replies">47<i class="fa fa-reply"></i></span>
                                    </div>
                                </div>
                                <div class="row message-preview unread">
                                	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                    	<div class="">
                                        	<h3><a href="#">Help with course creation</a></h3>
                                            <p>By <span class="name">Jeremy Wong</span> <span class="last-reply">Last reply 2 days ago</span></p>
                                        </div>
                                    </div>
                                	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    	<span class="number-of-replies">47<i class="fa fa-reply"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 no-padding-left no-padding-right">
                                <div class="question-answer-wrap">
                                    <div class="row question-answer">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="row question no-margin">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="avatar">
                                                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                                    </div>
                                                    <div class="replies-box">
                                                        <div class="clearfix">
                                                            <span class="name">Mac Chinedu <em class="lead">asks</em></span>
                                                            <span class="date">July 21, 2015</span>
                                                        </div>
                                                       	<h2>What are the best resources for learning bleeding-edge web, UI and UX design?</h2>
                                                        <p class="reply">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                                        UI/UX designers, and just interesting philosophical works that inform awesome modern/current web UIs/UXs (like Quora's!).</p>
                                                    </div>                                
                                                </div>
                                            </div>
                                            <div class="row answer">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="avatar">
                                                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                                    </div>
                                                    <div class="replies-box">
                                                        <div class="clearfix">
                                                            <span class="name">Mac Chinedu</span>
                                                            <div class="role others">Co-founder @ trydesignlab.com</div>
                                                            <span class="date">July 21, 2015</span>
                                                        </div>
                                                        <p class="reply">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                                        UI/UX designers, and just interesting philosophical works that inform awesome modern/current web UIs/UXs (like Quora's!).</p>
                                                        <p class="reply">There is a difference between UI design and UX design. </p>
                                                        <div class="clearfix vote-reply">
                                                            <span class="vote-count">45</span>
                                                            <a href="#"><i class="wa-chevron-down"></i></a> | 
                                                            <a href="#"><i class="wa-chevron-up"></i></a>
                                                            <a href="#" class="reply-button">Reply</a>
                                                        </div>                                
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row answer">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="avatar">
                                                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                                    </div>
                                                    <div class="replies-box">
                                                        <div class="clearfix">
                                                            <span class="name">Mac Chinedu</span>
                                                            <div class="role others">Co-founder @ trydesignlab.com</div>
                                                            <span class="date">July 21, 2015</span>
                                                        </div>
                                                        <p class="reply">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                                        UI/UX designers, and just interesting philosophical works that inform awesome modern/current web UIs/UXs (like Quora's!).</p>
                                                        <p class="reply">There is a difference between UI design and UX design. </p>
                                                        <div class="clearfix vote-reply">
                                                            <span class="vote-count">45</span>
                                                            <a href="#"><i class="wa-chevron-down"></i></a> | 
                                                            <a href="#"><i class="wa-chevron-up"></i></a>
                                                            <a href="#" class="reply-button">Reply</a>
                                                        </div>                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="discussion-sidebar-footer clearfix">
                                                <div class="avatar">
                                                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                                </div>
                                                <form>
                                                    <input type="text" placeholder="Write you answer">
                                                </form>
                                            </div>  
                                        </div>
                                    </div>
                                </div>              
                            </div>
                        </div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="questions">...</div>
                      <div role="tabpanel" class="tab-pane fade" id="students">...</div>
                    </div>                
                </div>
    <div class="container-fluid new-dashboard student-course">
    	<div class="container">
        </div>    
    </div>
@stop
