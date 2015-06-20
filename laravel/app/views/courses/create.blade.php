@extends('layouts.default')
@section('content')	

<section class="container-fluid course-editor create-course-start-page-container">
	<form>
	<div class="container">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
            	<div class="row">
                	<div class="col-lg-12">
                    	<img />
                        <h3 class="text-center">CREATE NEW COURSE</h3>
                    </div>
                </div>
                <div class="row first-row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <span class="step-number">1</span>
                        <h3>Give it a title</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <input type="text" name="title" placeholder="Title...">            
                    </div>
                </div>
                <div class="row second-row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <span class="step-number">2</span>
                        <h3>What is it about?</h3>                    
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    	<select>
                        	<option>Choose a category</option>
                        </select>
                    	<select>
                        	<option>Choose a sub-category</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                	<div class="col-lg-12 text-center">
                    	<button class="blue-button extra-large-button margin-top-30">CREATE COURSE</button>
                    </div>
                </div>
        	</div>
        </div>
     </div>
     </form>
</section>
@stop