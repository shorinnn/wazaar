@extends('layouts.default')
@section('content')
<section class="container-fluid contact-us header">
	<div class="container">
    	<h2>Contact Us</h2>
    </div>
</section>

<section class="container-fluid contact-us main">
	<div class="container">
		<div class="row input-row">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            	<label>Type of issue</label>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
            	<select>
                	<option>Question</option>
                </select>
                <em class="block tip">Description about types, which to choose.</em>
            </div>
        </div>
		<div class="row input-row">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            	<label>Your name</label>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
            	<input type="text" placeholder="Enter name...">
            </div>
        </div>
		<div class="row input-row">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            	<label>Email</label>
            
            </div>
            <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
            	<input type="text" placeholder="Enter email...">
            
            </div>
        </div>
		<div class="row input-row">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            	<label>Subject</label>
            
            </div>
            <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
            	<input type="text" placeholder="Enter subject...">
            
            </div>
        </div>
		<div class="row input-row">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            	<label>Message</label>
            
            </div>
            <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
            	<textarea placeholder="Enter message..."></textarea>
            </div>
        </div>
		<div class="row input-row">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            
            </div>
            <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
            	<button class="large-button blue-button send">Send</button>
            </div>
        </div>
    </div>
</section>
@stop