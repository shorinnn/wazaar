@extends('layouts.default')
@section('content')
	<div class="container-fluid new-dashboard top-section">
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
    <div class="container-fluid new-dashboard dashboardTabs-header">
    	<div class="container">
        	<div class="row">
            	<div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active">
                        	<a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Profile</a>
                        </li>
                        <li role="presentation">
                        	<a href="#password" role="tab" id="password-tab" data-toggle="tab" aria-controls="password">Password</a>
                        </li>
                        <li role="presentation">
                        	<a href="#bank-details" role="tab" id="bank-details-tab" data-toggle="tab" aria-controls="bank-details">Bank details</a>
                        </li>
                    </ul>               
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard student-account">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 pull-right margin-top-25">
                    <div class="tab-content">
                      	<div role="tabpanel" class="tab-pane fade in active" id="profile">
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
                    	</div>
                        <div role="tabpanel" class="tab-pane fade in" id="password">
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
                        <div role="tabpanel" class="tab-pane fade in" id="bank-details">
                            <div class="profile-input-rows">
                                <h4>Credit Card Details</h4>
                                <div class="clearfix">
                                    <form>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Credit Card Number</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                <input type="text" placeholder="0000 0000 0000 0000" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>CVV Code <span class="cvv-tip" data-toggle="tooltip" data-placement="top" 
                                                title="3 digit code at the back of your card">?</span></label>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Expiry Date</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                                <input type="text" placeholder="MM / YY" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Name on the Card</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
												<input type="text" placeholder="" />                                            
                                        	</div>
                                        </div>
                                    </form>
                                </div>
                            </div>                        
                        </div>
                	</div>
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
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
