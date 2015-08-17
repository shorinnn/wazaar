@extends('layouts.default')
@section('content')
	<div class="container-fluid new-dashboard top-section">
    	<div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <div class="row">
                    	<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                        	<h2>Activity today<i class="wa-chevron-down"></i></h2>
                        </div>
                    	<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                        	<h2>Activity today<i class="wa-chevron-down"></i></h2>
                        </div>
                    	<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                        	<h2>Activity today<i class="wa-chevron-down"></i></h2>
                        </div>
                    	<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                        	<h2>Activity today<i class="wa-chevron-down"></i></h2>
                        </div>
                    </div>
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
                        	<a href="#teaching" role="tab" id="teaching-tab" data-toggle="tab" aria-controls="enrolled" aria-expanded="true">Teaching</a>
                        </li>
                        <li role="presentation" class="">
                        	<a href="#enrolled" role="tab" id="enrolled-tab" data-toggle="tab" aria-controls="enrolled" aria-expanded="true">Enrolled</a>
                        </li>
                        <li role="presentation">
                        	<a href="#finished" role="tab" id="finished-tab" data-toggle="tab" aria-controls="finished">Finished</a>
                        </li>
                        <li role="presentation" class="dropdown">
                          <a href="#wishlist" role="tab" id="wishlist-tab" data-toggle="tab" aria-controls="wishlist">Wishlist</a>
                        </li>
                    </ul> 
                    <a href="#" class="right add-new-course large-button blue-button"><i class="fa fa-plus"></i> Add new course</a>              
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard dashboardTabs instructor-dashboard">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 pull-right">
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in active" id="enrolled">
                          <div class="row">
                          	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              	  <div class="clearfix enrolled-lesson no-border finished-lesson">
                                      <div class="row">
                                          <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                            <div class="image-wrap">
                                                <img src="https://wazaardev.s3.amazonaws.com/course_preview/54905d8c6ecae.jpg" class="img-responsive" />
                                            </div>
                                          </div>
                                          <div class="col-xs-12 col-sm-8 col-md-7 col-lg-7">
                                            <h4><a href="#">Learn To Code by Making Games</a><span class="lesson-status pending">Pending</span></h4>
                                            <p class="regular-paragraph"><span class="created-on">Created on:</span> 07/09/2015</p>
                                            <p class="regular-paragraph"><span class="status">Status</span> <em class="paid">Paid</em><em class="public">Public</em></p>
                                          </div>
                                          <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                          	<div class="settings activate-dropdown">
                                            	<button aria-expanded="false" data-toggle="dropdown" 
                                                class="catalogue-button dropdown-toggle" type="button" id="btnGroupDrop2">
                                                    <i class="fa fa-cog"></i>
                                                    <i class="wa-chevron-down"></i>
                                                </button>
                                                <div id="" aria-labelledby="btnGroupDrop2" role="menu" class="dropdown-menu">
                                                
                                                </div>
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="finished">...</div>
                      <div role="tabpanel" class="tab-pane fade" id="wishlist">...</div>
                    </div>                
                </div>
            	<div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                	<div class="sidebar">
                        <div class="profile-picture-holder">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" class="img-responsive">
                        </div>
                        <div href="#" class="name">
                            <h2>Saulius Kirklys</h2>
                            <a href="#" class="edit-profile"><i class="fa fa-cog"></i>Edit profile</a>
                        </div>
                        <a href="#" class="message-count message">
                        	<i class="fa fa-comment-o"></i>
                            Messages
                            <span class="count">(2)</span>
                        </a>
                        <a href="#" class="message-preview unread message">
                        	<h4>Jeremy Wong <span class="date">Yesterday</span></h4>
                            <p class="regular-paragraph">I am new to course creation. I have many doubts and i am ... </p>
                        </a>
                        <a href="#" class="message-preview message">
                        	<h4>Jeremy Wong <span class="date">Yesterday</span></h4>
                            <p class="regular-paragraph">I am new to course creation. I have many doubts and i am ... </p>
                        </a>
                        <a href="#" class="message-preview unread message">
                        	<h4>Jeremy Wong <span class="date">Yesterday</span></h4>
                            <p class="regular-paragraph">I am new to course creation. I have many doubts and i am ... </p>
                        </a>
                        <a href="#" class="message-preview message">
                        	<h4>Jeremy Wong <span class="date">Yesterday</span></h4>
                            <p class="regular-paragraph">I am new to course creation. I have many doubts and i am ... </p>
                        </a>
                        <div class="text-center read-message">
                        	<a href="#" class="default-button large-button">Read all messages</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@stop
