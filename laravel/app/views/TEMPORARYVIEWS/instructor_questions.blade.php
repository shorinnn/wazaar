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
    <div class="container-fluid new-dashboard student-messages">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 message-preview-wrap">
                	<div class="row message-header">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <h3>Questions</h3>
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            <form>
                                <div>
                                    <input type="search" placeholder="Search discussions ..." />
                                    <button><i class="wa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row message-preview">
                    	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            <div class="avatar">
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                            </div>
                        </div>
                    	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        	<div class="message">
                            	<h4>Saulius Patrick</h4>
                                <p class="regular-paragraph">I am new to course creation. I have many doubts and i am in need of some guidance from ... 
                                experts like you all. So, here is few of them.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row message-preview">
                    	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            <div class="avatar">
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                            </div>
                        </div>
                    	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        	<div class="message">
                            	<h4>Saulius Patrick</h4>
                                <p class="regular-paragraph">I am new to course creation. I have many doubts and i am in need of some guidance from ... 
                                experts like you all. So, here is few of them.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row message-preview">
                    	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            <div class="avatar">
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                            </div>
                        </div>
                    	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        	<div class="message">
                            	<h4>Saulius Patrick</h4>
                                <p class="regular-paragraph">I am new to course creation. I have many doubts and i am in need of some guidance from ... 
                                experts like you all. So, here is few of them.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row message-preview">
                    	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            <div class="avatar">
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                            </div>
                        </div>
                    	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        	<div class="message">
                            	<h4>Saulius Patrick</h4>
                                <p class="regular-paragraph">I am new to course creation. I have many doubts and i am in need of some guidance from ... 
                                experts like you all. So, here is few of them.</p>
                            </div>
                        </div>
                    </div>
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 full-messages">
                	<div class="row conversing-with">
                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="avatar">
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                            </div>
							<p class="regular-paragraph"><span class="name">Brad Frost,</span> Visual designer</p>                        
                        </div>
                    </div>
                	<div class="question-answer-wrap">
                        <div class="row question-answer">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row question no-margin">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                                        <h3>What are the best resources for learning bleeding-edge web, UI and UX design?</h3>
                                        <p class="regular-paragraph">
                                        I'm looking for any kind of resource, including those that are highly technical, those directed to 
                                        experienced UI/UX designers, and just interesting philosophical works that inform awesome modern/current 
                                        web UIs/UXs (like Quora's!).
                                        </p>
                                    </div>
                                </div>
                                <div class="row answer no-margin margin-bottom-10">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="avatar">
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                        </div>
                                        <div class="replies-box">
                                            <div class="clearfix">
                                                <span class="name">Mac Chinedu</span>
                                                <div class="role teacher">Teacher</div>
                                            </div>
                                            <p class="reply">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                            UI/UX designers</p>
                                        </div>                                
                                    </div>
                                </div>
                                <div class="row answer no-margin margin-bottom-10">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="avatar">
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                        </div>
                                        <div class="replies-box">
                                            <div class="clearfix">
                                                <span class="name">Mac Chinedu</span>
                                                <div class="role others">Co-founder @ trydesignlab.com</div>
                                            </div>
                                            <p class="reply">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                            UI/UX designers, and just interesting</p>
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
    </div>
@stop
