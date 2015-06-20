@extends('layouts.default')
@section('content')	
<div class="course-editor">
	<section class="container-fluid create-course-description-header">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<h1>Edit: course name</h1>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<a href="#" class="blue-button large-button disabled-button right">Submit for approval</a>
                <a href="#" class="default-button large-button right">Preview course</a>
            </div>
        </div>
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<a href="#" class="header-tabs regular-paragraph active">Course description</a>
            	<a href="#" class="header-tabs regular-paragraph">Curriculum</a>
            	<a href="#" class="header-tabs regular-paragraph">Settings</a>
                
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<div class="right">
                	<p class="regular-paragraph">
                    	Complete <span>2 steps</span> to submit course 
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="container create-course-description-main">
    	<form>
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 left-content">
            	<div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <p class="intro-paragraph">Fill in the details which will be seen on public course page. Keep it clean and informative.</p>
                        <h4>
                        Short description
                        <span class="lead">Will be used for listings description and introduction.</span>
                        </h4>
                        <textarea>
                        
                        </textarea>
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h4>
                        Full description
                        <span class="lead">Will be used on course description page.</span>
                        </h4>
                        <textarea>
                        
                        </textarea>                    
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h4>Requirements
                        	<span class="leas">What user need to know in order to complete course.</span>
                        </h4>
                        <div class="relative">
                        	<input type="text" name="requirement-1" placeholder="List item 1">
                            <span class="remove-input"></span>
                        </div>
                        <div class="relative">
                        	<input type="text" name="requirement-2" placeholder="List item 2">
                            <span class="remove-input"></span>
                        </div>
                        <a href="#" class="transparent-button add-input">add</a>
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h4>Who is this for?
                        	<span class="lead">Who may get the best benefit from your course?</span>
                        </h4>
                        <div class="relative">
                        	<input type="text" name="requirement-1" placeholder="List item 1">
                            <span class="remove-input"></span>
                        </div>
                        <div class="relative">
                        	<input type="text" name="requirement-2" placeholder="List item 2">
                            <span class="remove-input"></span>
                        </div>
                        <a href="#" class="transparent-button add-input">add</a>
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h4>
                        	By the end of course you will be able to...
                            <span class="lead">What skills will student learn after a course?</span>
                        </h4>
                        <div class="relative">
                        	<input type="text" name="requirement-1" placeholder="List item 1">
                            <span class="remove-input"></span>
                        </div>
                        <div class="relative">
                        	<input type="text" name="requirement-2" placeholder="List item 2">
                            <span class="remove-input"></span>
                        </div>
                        <a href="#" class="transparent-button add-input">add</a>
                    </div>
                </div>
            </div>
        	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 right-content">
            	<div class="row category-row">
                	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    	<p class="regular-paragraph">Category</p>
                    	<p class="regular-paragraph">Sub-category</p>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    	<p class="regular-paragraph semibold-text">IT & WEB</p>
                    	<p class="regular-paragraph semibold-text">Websites</p>
                    </div>
                </div>
                <div class="row upload-box listing-image">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>
                        Listing image (thumbnail)
                        	<span class="lead">Image used for listings thumbnail</span>
                        </h4>
                        <div class="file-details">
                        	<p class="regular-paragraph">Recommended size 1080x680</p>
							<p class="regular-paragraph">Available formats png or jpg.</p>
                            <button class="default-button large-button">Upload Image</button>
                        </div>
                    </div>
                </div>
                <div class="row upload-box listing-video">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>
                        	Introduction video
                        	<span class="lead">Video on public course page</span>
                        </h4>
                        <div class="file-details">
                        	<p class="regular-paragraph">Video should be 16:9 or</p>
							<p class="regular-paragraph">else it will be cropped</p>
                            <button class="default-button large-button">Upload Video</button>
                        </div>
                    </div>
                </div>
                <div class="row next-step-button">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<button class="blue-button extra-large-button">NEXT STEP</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>
</div>
@stop