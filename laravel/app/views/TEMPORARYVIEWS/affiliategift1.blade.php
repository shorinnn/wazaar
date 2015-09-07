
@extends('layouts.default')
@section('content')
<div class="container-fluid affiliate-top-header">
	<div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <p class="regular-paragraph left">Copy your affialiate link</p>
            <form>
                <input type="text" readonly value="http://www.wazaar.jp/courses/J3dfsa?affid=1223">
            </form>
        </div>
    	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 no-padding">
        	<div class="row">
            	<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
                	<a href="#" class="add-tracking-id"><i class="fa fa-plus"></i>Add Tracking ID</a>
                </div>
            	<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
                	<div class="activate-dropdown">
                    	
                        <button aria-expanded="false" data-toggle="dropdown" class="add-gift dropdown-toggle" type="button" id="add-gift-dropdown">
                            <i class="fa fa-gift"></i>
                            <span>Add Gift</span>
                            <i class="wa-chevron-down"></i>
                        </button>  
                        <div aria-labelledby="add-gift-dropdown" role="menu" class="dropdown-menu">
                        	<span class="arrow-top"></span>
                        	<div class="dropzone">
                            	<i class="fa fa-cloud-upload"></i>
                                <p class="regular-paragraph">Drag & Drop <br> files to upload</p>
                            </div>
                            <div class="uploaded-files">
                            	<ul>
                                	<li>
                                    	<a href="#">
                                        	<span class="file-name">Example.png</span>  
                                            <span class="file-size">236kb</span>
                                        </a>
                                    </li>
                                	<li>
                                    	<a href="#">
                                        	<span class="file-name">Example.png</span>  
                                            <span class="file-size">236kb</span>
                                        </a>
                                    </li>
                                	<li>
                                    	<a href="#">
                                        	<span class="file-name">Example.png</span>  
                                            <span class="file-size">236kb</span>
                                        </a>
                                        <div class="progress-box clearfix">
                                            <span class="progress-label">Uploading 70%</span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="0" 
                                                     data-label="" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                    <span></span>
                                                </div>
                                            </div>  
                                        </div>                                      
                                    </li>
                                </ul>
                            </div>
                            <div class="text-center">                               
                                <form>
                                    <label for="add-gift" class="default-button large-button select-file">
                                        <span><i class="fa fa-paperclip"></i> Select file</span>
                                        <input type="file" hidden="" class='' data-upload-url="" id="add-gift"/>
                                    </label>
                                </form>
							</div>
                        </div>             
                    </div> 
                </div>
            </div>        
        </div>
    </div>
</div>

<div class="container affiliate-gift-wrap">
	<div class="row description-wrap">
    	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-center">
        	<img class="img-responsive gift-coupon inline-block" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/gift-coupon.png" alt="">
        </div>
    	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
        	<div class="description">
                <h3>Course Gift from <span class="name">Saulius Kirklys</span></h3>
                <p>Here's my gift to you that will teach you the bonus technique of achieving the best result of my course!</p>
            </div>
            <div class="open-button-wrap">
            	<span class="open-gift blue-button large-button blue-button-shadow">Open Gift</span>
            </div>
        </div>
    </div>
    <div class="row files-wrap download-files-wrap">
    	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
        	<a href="#collapseExample" class="toggle-button" data-toggle="collapse" data-less-text="Hide files" data-more-text="Show files">
            	<i class="wa-chevron-down"></i>Show files
            </a>
        </div>
    	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
        	<span class="default-button large-button">Download all files in zip</span>
            <span class="file-size">4 files (2,1mb)</span>
        </div>    
    </div>
    <div class="row files-wrap toggle-container collapse" id="collapseExample">
    	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
        </div>
    	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
        	<ul>
            	<li class="file">
                	<a href="#">
                    	<i class="fa fa-file-pdf-o"></i>
                        <span class="file-name regular-paragraph">Video_file_name_2015.mp4 </span>
                        <span class="file-size regular-paragraph">1,2mb</span>
                    </a>
                </li>
            	<li class="file">
                	<a href="#">
                    	<i class="fa fa-file-photo-o"></i>
                        <span class="file-name regular-paragraph">Video_file_name_2015.mp4 </span>
                        <span class="file-size regular-paragraph">1,2mb</span>
                    </a>
                </li>
            	<li class="file">
                	<a href="#">
                    	<i class="fa fa-file-video-o"></i>
                        <span class="file-name regular-paragraph">Video_file_name_2015.mp4 </span>
                        <span class="file-size regular-paragraph">1,2mb</span>
                    </a>
                </li>
            </ul>
        </div>    
    </div>
</div>

<div class="container">
	<div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1 no-padding gift-modal no-padding">
        	<h3>Gifts</h3>
            <i class="fa fa-times close-button"></i>
            <div class="wrap">
                <h6> TITLE <span class="delete-button"><i class="fa fa-trash"></i>Delete</span></h6>
                <form>
                    <input type="text" placeholder="Gift 1" />
                </form>
                <h6> TITLE <span class="characters-left">178 Characters left</span></h6>
                <form>
                    <input type="text" placeholder="What do you have to say?" />
                </form>
                <h6>Gift link</h6>
                <form class="relative">
                    <input type="text" readonly="readonly" class="copy-link" value="http://cocorium.com/courses/cJio3?aid=&gid=5ac2F" />
                    <a href="#" class="copy">Copy</a>
                </form>
                <div class="dropzone">
                	<i class="fa fa-cloud-upload"></i>
                    <p class="regular-paragraph">
                    	<span class="semibold-text block">Drag & Drop</span>
                        files to upload
                    </p>
                    <form>
                        <label for="add-gift" class="default-button large-button select-file">
                            <span><i class="fa fa-paperclip"></i> Select file</span>
                            <input type="file" hidden="" class='hide' data-upload-url="" id="add-gift"/>
                        </label>
                    </form>
                </div>
            </div>
            <div class="create-another-gift">
            	<a href="#"><i class="fa fa-plus"></i>Create another gift</a>
            </div>
        </div>
    </div>
	<div class="row margin-top-20">
    	<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1 gift-modal no-padding">
        	<h3>Gifts</h3>
            <i class="fa fa-times close-button"></i>
            <div class="wrap">
                <h6> TITLE <span class="delete-button"><i class="fa fa-trash"></i>Delete</span></h6>
                <form>
                    <input type="text" placeholder="Gift 1" />
                </form>
                <h6> TITLE <span class="characters-left">178 Characters left</span></h6>
                <form>
                    <input type="text" placeholder="What do you have to say?" />
                </form>
                <h6>Gift link</h6>
                <form class="relative">
                    <input type="text" readonly="readonly" class="copy-link" value="http://cocorium.com/courses/cJio3?aid=&gid=5ac2F" />
                    <a href="#" class="copy">Copy</a>
                </form>
            </div>
            <div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="dropzone">
                        <i class="fa fa-cloud-upload"></i>
                        <p class="regular-paragraph">
                            <span class="semibold-text block">Drag & Drop</span>
                            files to upload
                        </p>
                        <form>
                            <label for="add-gift" class="default-button large-button select-file">
                                <span><i class="fa fa-paperclip"></i> Select file</span>
                                <input type="file" hidden="" class='hide' data-upload-url="" id="add-gift"/>
                            </label>
                        </form>
                    </div>
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 uploaded-files">
                    <ul>
                        <li>
                            <a href="#">
                                <span class="file-name">Video_long_title_1080p_year2015.mp4 </span>  
                                <span class="file-size">1,2mb</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="file-name">Example.png</span>  
                                <span class="file-size">236kb</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="file-name">Another_example_with_really_lon...e.jpg </span>  
                                <span class="file-size">144kb</span>
                            </a>
                            <div class="progress-box clearfix">
                                <span class="progress-label">Uploading 70%</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" 
                                         data-label="" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                        <span></span>
                                    </div>
                                </div>  
                            </div>                                      
                        </li>
                    </ul>                	
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.create-another-gift{
	padding: 23px 0 13px;
	text-align: center;
	background: #fff;
}
.create-another-gift button,
.create-another-gift a{
	font-size: 12px;
	font-weight: bold;
	color: #119bf8;
	background: none;
	border: none;
}
.create-another-gift i.fa.fa-plus{
	margin-right: 5px;
}
.checkout-modal{
	width: 460px;
	margin: 0 auto;
}
.checkout-modal .modal-header{
	background: #fff;
	padding: 24px 60px;
}
.checkout-modal .profile-image{
	height: 57px;
	width: 100px;
	background: #e3e5e6;
	border-radius: 4px;
	overflow: hidden;
	margin-right: 19px;
	float: left;
}
.checkout-modal .modal-header .description{
	font-size: 13px;
	color: #798794;
	margin: 4px 0 0;
}
.checkout-modal .modal-header .price{
	font-size: 26px;
	color: #0099ff;
	margin: 0 0 8px;
	line-height: 26px;
}
.checkout-modal .modal-body{
	background: #f7f9fa;
	padding: 24px 60px 60px;
}
.radio-style-2 input[type='radio']{
	display: none;
	margin: 0;
	opacity: 0;
}
.radio-style-2 label{
	border: solid 2px #cfd8df;
	background: #fff;
	height: 14px;
	width: 14px;
	margin: 0;
	position: relative;
	border-radius: 14px;
}

.radio-style-2 label::before {
    background: #fff;
    border-radius: 8px;
    content: "";
    height: 8px;
    left: 1px;
    position: absolute;
    top: 1px;
    width: 8px;
    z-index: 1;
}
.radio-style-2 input[type="radio"]:checked ~ label{
	background: #0099ff;
	border-color: #0099ff;
}
.checkout-modal .cards-wrap{
	padding: 24px;
	border: solid transparent;
	border-width: 1px;
	border-bottom-color: #e3e5e6;
	border-radius: 0;
}
.checkout-modal .cards-wrap.active{
	background: #fff;
	border: solid #e3e5e6;
	border-width: 1px;
	border-radius: 4px;
}
.checkout-modal .cc-card-button{
	float: left;
	margin-right: 25px;
}
.checkout-modal .cards-wrap h4{
	color: #303941;
	margin: 0;
	line-height: 22px;
}
.checkout-modal .cards-wrap p{
	color: #798794;
	margin: 0;
}
.checkout-modal .card-details{
	float: left;
}
.checkout-modal .card-logo{
	float: right;
	display: block;
	height: 26px;
	width: 35px;
	background-image: url('https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/credit-card-icons.png');
	background-repeat: no-repeat;
}
.checkout-modal .card-logo.mastercard{
	background-position: 0 0;
}

.checkout-modal .card-logo.visa{
	background-position: right 0;
}
.checkout-modal .new-card .cc-card-button{
	visibility: hidden;
}
.checkout-modal .new-card .add-new-card{
	cursor: pointer;
}
.checkout-modal .pay-button{
	margin-top: 24px;
	display: block;
	width: 100%;
	text-transform: uppercase;
}
.checkout-modal .new-cc-form{
	padding-top: 12px;
}
.checkout-modal .new-cc-form label{
	margin: 0 0 10px;
	font-size: 11px;
	font-weight: bold;
	color: #8f9dab;
	text-transform: uppercase;
}
.checkout-modal .new-cc-form input{
	background: #fff;
	margin-bottom: 23px;
}
.checkout-modal .ccv-code,
.checkout-modal .expiry-date{
	width: 134px;
}
.checkout-modal .modal-footer{
	margin: 0;
	display: none;
}
</style>

<div class="modal-content checkout-modal">
	<div class="modal-header">
		<button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
    	<div class="profile-image"></div>
        <p class="intro-paragraph description">売却益20％を狙う金貨・銀貨アンテ ...</p>
        <span class="price">¥ 7,200</span>
    </div>
	<div class="modal-body clearfix"> 
        <div class="bootbox-body">
            <section>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                    <div class="">
                        <div class="row">
                            <div>
                            	<form>
                            	<div class="cards-wrap clearfix active">
                                	<span class="cc-card-button radio-style-2">
                                        <input type="radio" name="credit-card-id" id="card-1">
                                        <label class="small-radio-2" for="card-1"></label>
                                    </span>
                                    <div class="card-details">
                                    	<h4>Mastercard ending 7569</h4>
                                        <p class="regular-paragraph">Expires 12/16</p>
                                    </div>
                                    <span class="card-logo mastercard">
                                    
                                    </span>
                                </div>
                            	<div class="cards-wrap clearfix">
                                	<span class="cc-card-button radio-style-2">
                                        <input type="radio" name="credit-card-id" id="card-2">
                                        <label class="small-radio-2" for="card-2"></label>
                                    </span>
                                    <div class="card-details">
                                    	<h4>Visa ending 7569</h4>
                                        <p class="regular-paragraph">Expires 12/16</p>
                                    </div>
                                    <span class="card-logo visa">
                                    
                                    </span>
                                </div>
                            	<div class="cards-wrap clearfix new-card">
                                	<span class="cc-card-button radio-style-2">
                                        <input type="radio" name="credit-card-id" id="card-2">
                                        <label class="small-radio-2" for="card-2"></label>
                                    </span>
                                    <div class="card-details">
                                    	<h4 class="add-new-card">Add new credit card</h4>
                                    </div>
                                    <span class="card-logo hide">
                                    
                                    </span>
                                    <div class="clear new-cc-form">
                                    	<div>
                                        	<label>Credit Card number</label>
                                            <input type="text" placeholder="0000 0000 0000 0000">
                                        </div>
                                        <div>
                                            <div class="left ccv-code">
                                                <label>CCV Code <span>?</span></label>
                                                <input type="text" placeholder="">
                                            </div>
                                            <div class="right expiry-date">
                                                <label>Expiry date</label>
                                                <input type="date" placeholder="">
                                            </div>
                                        </div>
                                    	<div>
                                        	<label>Name on the card</label>
                                            <input type="text" class="no-margin" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="button text-center">
                                	<button type="submit" class="blue-button large-button pay-button"><i class="fa fa-padlock"></i>Pay ¥7,200</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section> 
        </div>
    </div>
    <div class="modal-footer">
    
    </div>
</div>  
@stop
@section('extra_js')
<script>

	$(document).ready(function(){ 
		$(".toggle-button").addClass("show-more");
		$(".toggle-button").click(function(){
			$(".toggle-container").toggleClass("show");
			
			$(this).toggleClass('show-more');
			
			if ($(this).hasClass('show-more')) {
				$(this).html(('<i class="fa fa-chevron-down"></i>') + $(this).attr('data-more-text'));
			} else {
				$(this).html(('<i class="fa fa-chevron-up"></i>') + $(this).attr('data-less-text'));       
			}

			return false; 		
		});
		
		$(".open-gift").click(function(){
			$(".download-files-wrap").show();
			$(".open-button-wrap").hide();
			$(".affiliate-gift-wrap .description").css({width: "100%"});
		});
	});

</script>
@stop