@extends('layouts.default')
@section('content')
    <div class="container-fluid student-dashboard student-messages">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 message-preview-wrap">
                	<div class="row message-header">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <h3>Messages</h3>
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            <form>
                                <div>
                                    <input type="search" placeholder="Search conversations ..." />
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
                    <div class="row conversation">
                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                        	<span class="date"><em>Yesterday</em></span>                        
                        </div>
                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row margin-bottom-25">
                            	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
									<div class="avatar">
                                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                    </div>
                                    <div class="replies-box">
                                        <p class="regular-paragraph">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                        UI/UX designers, and just interesting philosophical works that inform awesome modern/current web UIs/UXs (like Quora's!).</p>
                                        
                                        <span class="arrow-left"> </span>
                                    </div> 
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-md-offset-1 col-lg-offset-1 no-padding">
                                	<span class="message-time">12:34</span>
                                </div>
                            </div>
                            <div class="row margin-bottom-25">
                            	<div class="col-xs-10 col-sm-10 col-md-11 col-lg-11">
                                    <div class="student-reply">
                                        <p class="regular-paragraph">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                        UI/UX designers</p>
                                        
                                        <span class="arrow-right"> </span>
                                    </div> 
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 no-padding">
                                	<span class="message-time">12:34</span>
                                </div>
                            </div>
                            <div class="row margin-bottom-25">
                            	<div class="col-xs-10 col-sm-10 col-md-11 col-lg-11">
                                    <div class="student-reply">
                                        <p class="regular-paragraph">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                        UI/UX designers</p>
                                        
                                        <span class="arrow-right"> </span>
                                    </div> 
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 no-padding">
                                	<span class="message-time">12:34</span>
                                </div>
                            </div>
                            <div class="row margin-bottom-25">
                            	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
									<div class="avatar">
                                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                    </div>
                                    <div class="replies-box">
                                        <p class="regular-paragraph">You are welcome!</p>
                                        
                                        <span class="arrow-left"> </span>
                                    </div> 
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-md-offset-1 col-lg-offset-1 no-padding">
                                	<span class="message-time">12:34</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row conversation">
                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                        	<span class="date"><em>Today</em></span>                        
                        </div>
                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row margin-bottom-25">
                            	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
									<div class="avatar">
                                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                    </div>
                                    <div class="replies-box">
                                        <p class="regular-paragraph">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                        UI/UX designers, and just interesting philosophical works that inform awesome modern/current web UIs/UXs (like Quora's!).</p>
                                        
                                        <span class="arrow-left"> </span>
                                    </div> 
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-md-offset-1 col-lg-offset-1 no-padding">
                                	<span class="message-time">12:34</span>
                                </div>
                            </div>
                            <div class="row margin-bottom-25">
                            	<div class="col-xs-10 col-sm-10 col-md-11 col-lg-11">
                                    <div class="student-reply">
                                        <p class="regular-paragraph">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                        UI/UX designers</p>
                                        
                                        <span class="arrow-right"> </span>
                                    </div> 
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 no-padding">
                                	<span class="message-time">12:34</span>
                                </div>
                            </div>
                            <div class="row margin-bottom-25">
                            	<div class="col-xs-10 col-sm-10 col-md-11 col-lg-11">
                                    <div class="student-reply">
                                        <p class="regular-paragraph">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                        UI/UX designers</p>
                                        
                                        <span class="arrow-right"> </span>
                                    </div> 
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 no-padding">
                                	<span class="message-time">12:34</span>
                                </div>
                            </div>
                            <div class="row margin-bottom-25">
                            	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
									<div class="avatar">
                                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                    </div>
                                    <div class="replies-box">
                                        <p class="regular-paragraph">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                        UI/UX designers, and just interesting philosophical works that inform awesome modern/current web UIs/UXs (like Quora's!).</p>
                                        
                                        <span class="arrow-left"> </span>
                                    </div> 
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-md-offset-1 col-lg-offset-1 no-padding">
                                	<span class="message-time">12:34</span>
                                </div>
                            </div>
                            <div class="row discussion-sidebar-footer-wrap">
                                <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
                                    <div class="discussion-sidebar-footer clearfix">
                                        <div class="avatar">
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                        </div>
                                        <form>
                                            <input type="text" placeholder="Write a message">
                                        </form>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@stop
