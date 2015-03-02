@extends('layouts.default')
@section('content')	
	<div class="container course-editor">
    	<div class="row">
        	<div class="col-md-12">
            	<h1>PHP Primer Revisited
                	<span>Course Editor</span>
                </h1>
            </div>
        </div>
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6">
            	<div class="what-to-achieve">
                	<h3>By the end of your course, your student will be able to...</h3>
                    <ul>
                    	<li>Design a complete App design from skretch</li>
                        <li>Something else!</li>
                    </ul>
                </div>
            </div>
        	<div class="col-xs-12 col-sm-12 col-md-6">
            	<div class="who-for">
                	<h3>This is for those who...</h3>
                    <ul>
                    	<li>Beginners that don’t know anything about C++ </li>
                        <li>Existing who want to pick up javascript.</li>
                    </ul>               
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-12">
            	<div class="plan-your-curriculum">
                	<h2>Plan out your curriculum
                    	<span>Outline your modules and lessons that your students will go through.</span>
                    </h2>
                    <div class="new-module-container">
                    	<div class="new-module">
                        	<span>New Module</span>
                            <input type="text" placeholder="Name Module" />
                            <div class="buttons">
                            	<div class="menu">
                                	<span></span>
                                	<span></span>
                                	<span></span>
                                </div>
                                <span class="close-button">x</span>
                            </div>
                        </div>
                        <div class="lesson-container clearfix">
                            <div class="new-lesson green clearfix">
                                <span>New Lesson</span>
                                <input type="text" placeholder="Name Lesson" />
                                <div class="buttons">
                                    <div class="menu">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <span class="close-button">x</span>
                                </div>
                            </div>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                <span class="sr-only">60% Complete</span>
                              </div>
                            </div>                        
                            <div class="new-lesson gray clearfix">
                                <span>New Lesson</span>
                                <input type="text" placeholder="Name Lesson" />
                                <div class="buttons">
                                    <div class="menu">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <span class="close-button">x</span>
                                </div>
                                <div class="video-upload clear">
                                	<button>Upload Video</button>
                                    <p>Lorem ipsum description here</p>
                                </div>
                                <div class="course-create-options clearfix">
                                	<div>
                                        <div class="buttons video active">
                                        	<p>10:36 <em>x</em></p>
                                            <div class="progress">
                                              <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">60% Complete</span>
                                              </div>
                                            </div>  
                                            <em>Processing</em>                                                                  
                                            <span></span>
                                        </div>
                                        <div class="buttons text">
                                            <span></span>                                   
                                        </div>
                                        <div class="buttons file">
                                            <span></span>                                    
                                        </div>
                                        <div class="buttons setting">
                                            <span></span>                                    
                                        </div>
                                        <div class="buttons edit">
                                            <span></span>                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="create-lesson-button">NEW LESSON</span>
                        </div>
                    </div>
                    <div class="new-module-container">
                    	<div class="new-module">
                        	<span>New Module</span>
                            <input type="text" placeholder="Name Module" />
                            <div class="buttons">
                            	<div class="menu">
                                	<span></span>
                                	<span></span>
                                	<span></span>
                                </div>
                                <span class="close-button">x</span>
                            </div>
                        </div>
                        <div class="lesson-container clearfix">
                            <div class="new-lesson gray clearfix">
                                <span>New Lesson</span>
                                <input type="text" placeholder="Name Lesson" />
                                <div class="buttons">
                                    <div class="menu">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <span class="close-button">x</span>
                                </div>
                            </div>
                            <div class="new-lesson gray clearfix">
                                <span>New Lesson</span>
                                <input type="text" placeholder="Name Lesson" />
                                <div class="buttons">
                                    <div class="menu">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <span class="close-button">x</span>
                                </div>
                            </div>
                            <span class="create-lesson-button">NEW LESSON</span>
                        </div>
                    </div>
                    <span class="add-new-module">ADD MODULE</span>
                </div>
            </div>
        </div>
    </div>
@stop
