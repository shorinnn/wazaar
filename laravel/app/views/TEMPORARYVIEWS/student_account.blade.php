@extends('layouts.default')
@section('content')
	<div class="container-fluid student-dashboard top-section">
    	<div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                	<h1>Your account</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid student-dashboard student-account">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 pull-right margin-top-25">
                	<div class="profile-input-rows">
                    	<h4>Profile</h4>
                        <div class="clearfix">
                        	<form>
                                <div class="row no-margin">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label>First name</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                    	<input type="text" placeholder="Max" />
                                    </div>
                                </div>
                                <div class="row no-margin">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label>Last name</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                    	<input type="text" placeholder="Maxinator" />
                                    </div>
                                </div>
                                <div class="row no-margin">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label>Email address</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                    	<input type="text" placeholder="macclinson@gmail.com" />
                                    </div>
                                </div>
                                <div class="row no-margin">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label>Describe yourself</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                    	<textarea>
                                        
                                        </textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                	<div class="profile-input-rows">
                    	<h4>Change password</h4>
                        <div class="clearfix">
                        	<form>
                                <div class="row no-margin">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label>Current password</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                    	<input type="password" placeholder="*********" />
                                    </div>
                                </div>
                                <div class="row no-margin">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label>New password</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                    	<input type="password" placeholder="" />
                                    </div>
                                </div>
                                <div class="row no-margin">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label>Repeat password</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                    	<input type="password" placeholder="" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            	<div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                	<div class="sidebar">
                        <div class="profile-picture-holder">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" class="img-responsive">
                        </div>
                        <div class="upload-picture-button text-center">
                            <label for="upload-new-photo" class="default-button large-button">
                                <span>{{ trans('general.upload_new_picture') }}</span>
                                <input type="file" hidden="" class='' id="upload-new-photo" name=""/>
                            </label>
                        </div>
                        <a href="#" class="message-count message">
                        	<i class="fa fa-comment-o"></i>
                            Messages
                            <span class="count">(2)</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@stop
