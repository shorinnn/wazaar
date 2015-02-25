@extends('layouts.default')
@section('content')	
	<div class="container account-details">
    	<div class="row">
        	<div class="col-md-12">
            	<div>
                	<h1>Wazaar account
                    	<span>Profile setup wizard</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="row input-form">
        	<div class="col-md-12">
            	<form class="clearfix">
                    <div class="email">
                    	<input type="email" placeholder="Email" id="email-box">
                        <button>Edit</button>
                    </div>
                    <div class="password">
                    	<h3>Change Password</h3>
                    	<input type="password" placeholder="Old Password" id="old-password">
                    	<input type="password" placeholder="New Password" id="new-password">
                    	<input type="password" placeholder="Confirm Password" id="confirm-password">
                        <button>Change Password</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row credit-cards">
        	<div class="col-md-12">
            	<div>
                	<h3>Credit cards</h3>
                    <div>
                    	<h4>Payment Information</h4>
                        <span class="card-logo mastercard"></span>
                        <p class="ending-numbers">Ending with 4182</p>
                        <p class="address">
                        	42 Zukiya street<br>
							Tokyo, Shibuya 92818
                        </p>
                        <div class="buttons">
                        	<a href="#" class="edit-button left">Edit</a>
                            <a href="#" class="delete-button right">Delete</a>
                        </div>
                    </div>
                    <div>
                    	<h4>Payment Information</h4>
                        <span class="card-logo american-express"></span>
                        <p class="ending-numbers">Ending with 4182</p>
                        <p class="address">
                        	42 Zukiya street<br>
							Tokyo, Shibuya 92818
                        </p>
                        <div class="buttons">
                        	<a href="#" class="edit-button left">Edit</a>
                            <a href="#" class="delete-button right">Delete</a>
                        </div>
                    </div>
                    <button>Add credit card</button>
                </div>
            </div>
        </div>
        <div class="row bills">
        	<div class="col-md-12">
            	<div class="bills-table table-responsive">
                	<h3>Bills</h3>
                    <div class="table-head">
                    	<p class="invoice-number">Invoice No.</p>
                        <p class="course">Course</p>
                        <p class="price">Price</p>
                        <p class="details"></p>
                    </div>
                    <div class="table-data">
                    	<p class="invoice-number">0129018871</p>
                        <p class="course">Javascript Advances Techniques class</p>
                        <p class="price">$49</p>
                        <a href="#" class="details">Details</a>
                    </div>
                    <div class="table-data">
                    	<p class="invoice-number">0129018871</p>
                        <p class="course">Javascript Advances Techniques class</p>
                        <p class="price">$49</p>
                        <a href="#" class="details">Details</a>
                    </div>
                    <div class="table-data">
                    	<p class="invoice-number">0129018871</p>
                        <p class="course">Javascript Advances Techniques class</p>
                        <p class="price">$49</p>
                        <a href="#" class="details">Details</a>
                    </div>
                    <div class="table-data">
                    	<p class="invoice-number">0129018871</p>
                        <p class="course">Javascript Advances Techniques class</p>
                        <p class="price">$49</p>
                        <a href="#" class="details">Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
