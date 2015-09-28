@extends('layouts.default')
@section('content')
	<div class="container-fluid new-dashboard top-section">
    	<div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 lesson-description">
                    <div class="row">
                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        	<h2>Go back where you left it</h2>
                        </div>
                    </div>
                    <div class="row margin-top-30">
                    	<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                        	<div class="img-wrap">
                            	<img src="https://wazaardev.s3.amazonaws.com/course_preview/54905d8c6ecae.jpg" class="img-responsive" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-7 col-lg-7">
                        	<h3>Welcome to Marketing in a Digital World</h3>
                            <p class="regular-paragraph">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p> 
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
                            <div class="radial-progress">
                                <div class="progress-radial progress-45">
                                  <div class="overlay">45%</div>
                                </div>
                                <a href="#" class="blue-button large-button"><i class="wa-play"></i>Resume</a>
                            </div>
                        </div>
                    </div>
                    <div class="row current-lesson-row">
                    	<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                        	<h6 class="current-lesson text-right">{{ trans('courses/dashboard.current_lesson') }} (32/60): </h6>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                        	<p class="regular-paragraph current-lesson-title">3.3. Understanding the importance of Marketing in Digital ...</p>
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
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active">
                        	<a href="#enrolled" role="tab" id="enrolled-tab" data-toggle="tab" aria-controls="enrolled" aria-expanded="true">Enrolled</a>
                        </li>
                        <li role="presentation">
                        	<a href="#finished" role="tab" id="finished-tab" data-toggle="tab" aria-controls="finished">{{trans('general.finished')}}</a>
                        </li>
                        <li role="presentation" class="dropdown">
                          <a href="#wishlist" role="tab" id="wishlist-tab" data-toggle="tab" aria-controls="wishlist">Wishlist</a>
                        </li>
                    </ul>               
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard dashboardTabs">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 pull-right">
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in active" id="enrolled">
                          <div class="row">
                          	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              	  <div class="clearfix enrolled-lesson no-border">
                                      <div class="row">
                                          <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                            <div class="image-wrap">
                                                <img src="https://wazaardev.s3.amazonaws.com/course_preview/54905d8c6ecae.jpg" class="img-responsive" />
                                            </div>
                                          </div>
                                          <div class="col-xs-12 col-sm-8 col-md-7 col-lg-7">
                                            <h4><a href="#">Learn To Code by Making Games</a></h4>
                                            <p class="regular-paragraph">32 / 60 {{ trans('courses/dashboard.lessons_completed') }}</p>
                                            <p class="regular-paragraph">{{ trans('courses/dashboard.current_lesson') }}: <a href="#">3.3. Understand the importance of ...</a></p>
                                          </div>
                                          <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                            <div class="enrolled-lessons-progress">
                                                <span class="finished block"><i class="wa-check"></i>{{trans('general.finished')}}</span>
                                                <span class="review regular-paragraph">{{ trans('courses/general.review') }}</span>
                                                <span class="progress-value">52%</span>
                                                <img src="../images/radial-progress.png">
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                          	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              	  <div class="clearfix enrolled-lesson no-border">
                                      <div class="row">
                                          <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                            <div class="image-wrap">
                                                <img src="https://wazaardev.s3.amazonaws.com/course_preview/54905d8c6ecae.jpg" class="img-responsive" />
                                            </div>
                                          </div>
                                          <div class="col-xs-12 col-sm-8 col-md-7 col-lg-7">
                                            <h4><a href="#">Learn To Code by Making Games</a></h4>
                                            <p class="regular-paragraph">32 / 60 {{ trans('courses/dashboard.lessons_completed') }}</p>
                                            <p class="regular-paragraph">{{ trans('courses/dashboard.current_lesson') }}: <a href="#">3.3. Understand the importance of ...</a></p>
                                          </div>
                                          <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                            <div class="enrolled-lessons-progress">
                                                <span class="finished block"><i class="wa-check"></i>{{trans('general.finished')}}</span>
                                                <span class="review regular-paragraph">{{ trans('courses/general.review') }}</span>
                                                <span class="progress-value">52%</span>
                                                <img src="../images/radial-progress.png">
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                          	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              	  <div class="clearfix enrolled-lesson no-border">
                                      <div class="row">
                                          <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                            <div class="image-wrap">
                                                <img src="https://wazaardev.s3.amazonaws.com/course_preview/54905d8c6ecae.jpg" class="img-responsive" />
                                            </div>
                                          </div>
                                          <div class="col-xs-12 col-sm-8 col-md-7 col-lg-7">
                                            <h4><a href="#">Learn To Code by Making Games</a></h4>
                                            <p class="regular-paragraph">32 / 60 {{ trans('courses/dashboard.lessons_completed') }}</p>
                                            <p class="regular-paragraph">{{ trans('courses/dashboard.current_lesson') }}: <a href="#">3.3. Understand the importance of ...</a></p>
                                          </div>
                                          <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                            <div class="enrolled-lessons-progress">
                                                <span class="finished block"><i class="wa-check"></i>{{trans('general.finished')}}</span>
                                                <span class="review regular-paragraph">{{ trans('courses/general.review') }}</span>
                                                <span class="progress-value">52%</span>
                                                <img src="../images/radial-progress.png">
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                          	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              	  <div class="clearfix enrolled-lesson no-border">
                                      <div class="row">
                                          <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                            <div class="image-wrap">
                                                <img src="https://wazaardev.s3.amazonaws.com/course_preview/54905d8c6ecae.jpg" class="img-responsive" />
                                            </div>
                                          </div>
                                          <div class="col-xs-12 col-sm-8 col-md-7 col-lg-7">
                                            <h4><a href="#">Learn To Code by Making Games</a></h4>
                                            <p class="regular-paragraph">32 / 60 {{ trans('courses/dashboard.lessons_completed') }}</p>
                                            <p class="regular-paragraph">{{ trans('courses/dashboard.current_lesson') }}: <a href="#">3.3. Understand the importance of ...</a></p>
                                          </div>
                                          <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                            <div class="enrolled-lessons-progress">
                                                <span class="finished block"><i class="wa-check"></i>{{trans('general.finished')}}</span>
                                                <span class="review regular-paragraph">{{ trans('courses/general.review') }}</span>
                                                <span class="progress-value">52%</span>
                                                <img src="../images/radial-progress.png">
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
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
                                            <h4><a href="#">Learn To Code by Making Games</a></h4>
                                            <p class="regular-paragraph">32 / 60 {{ trans('courses/dashboard.lessons_completed') }}</p>
                                            <p class="regular-paragraph">{{ trans('courses/dashboard.current_lesson') }}: <a href="#">3.3. Understand the importance of ...</a></p>
                                          </div>
                                          <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                              <div class="enrolled-lessons-progress">
                                                  <span class="finished block"><i class="wa-check"></i>{{trans('general.finished')}}</span>
                                                  <span class="review regular-paragraph">{{ trans('courses/general.review') }}</span>
                                                  <span class="progress-value">52%</span>
                                                  <img src="../images/radial-progress.png">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                          	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              	  <div class="clearfix enrolled-lesson no-border">
                                      <div class="row">
                                          <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                            <div class="image-wrap">
                                                <img src="https://wazaardev.s3.amazonaws.com/course_preview/54905d8c6ecae.jpg" class="img-responsive" />
                                            </div>
                                          </div>
                                          <div class="col-xs-12 col-sm-8 col-md-7 col-lg-7">
                                            <h4><a href="#">Learn To Code by Making Games</a></h4>
                                            <p class="regular-paragraph">32 / 60 {{ trans('courses/dashboard.lessons_completed') }}</p>
                                            <p class="regular-paragraph">{{ trans('courses/dashboard.current_lesson') }}: <a href="#">3.3. Understand the importance of ...</a></p>
                                          </div>
                                          <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                            <div class="enrolled-lessons-progress">
                                                <span class="finished block"><i class="wa-check"></i>{{trans('general.finished')}}</span>
                                                <span class="review regular-paragraph">{{ trans('courses/general.review') }}</span>
                                                <span class="progress-value">52%</span>
                                                <img src="../images/radial-progress.png">
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
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
                                            <h4><a href="#">Learn To Code by Making Games</a></h4>
                                            <p class="regular-paragraph">32 / 60 {{ trans('courses/dashboard.lessons_completed') }}</p>
                                            <p class="regular-paragraph">{{ trans('courses/dashboard.current_lesson') }}: <a href="#">3.3. Understand the importance of ...</a></p>
                                          </div>
                                          <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                              <div class="enrolled-lessons-progress">
                                                  <span class="finished block"><i class="wa-check"></i>{{trans('general.finished')}}</span>
                                                  <span class="review regular-paragraph">{{ trans('courses/general.review') }}</span>
                                                  <span class="progress-value">52%</span>
                                                  <img src="../images/radial-progress.png">
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
            	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
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
