
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