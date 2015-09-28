    @extends('layouts.default')
    @section('content')	
    <div class="wrapper classroom-dashboard">
    	<div class="container classroom-stats">
        	<div class="row today">
            	<div class="col-md-6 col-sm-6 col-xs-12">
                	<div class="today-stat">
                    	<h2>Today
                        	<span>43</span>
                        </h2>
                        <h4>NEW STUDENTS</h4>
                        <ul>
                        	<li id="monday" class="clearfix">
                            	<span>Monday</span>
                                <div><span></span></div>
                                <em>5</em>
                            </li>
                        	<li id="tuesday" class="clearfix">
                            	<span>Tuesday</span>
                                <div><span></span></div>
                                <em>2</em>
                            </li>
                        	<li id="wednesday" class="clearfix">
                            	<span>Wednesday</span>
                                <div><span></span></div>
                                <em>1</em>
                            </li>
                        	<li id="thursday" class="clearfix">
                            	<span>Thursday</span>
                                <div><span></span></div>
                                <em>52</em>
                            </li>
                        	<li id="friday" class="clearfix">
                            	<span>Friday</span>
                                <div><span></span></div>
                                <em>12</em>
                            </li>
                        </ul>
                    </div>
                </div>
            	<div class="col-md-6 col-sm-6 col-xs-12">
                	<div class="today-stat">
                    	<h2>Today
                        	<span>57</span>
                        </h2>
                        <h4>{{ trans('courses/dashboard.lessons_completed') }}</h4>
                        <ul>
                        	<li id="monday" class="clearfix">
                            	<span>Monday</span>
                                <div><span></span></div>
                                <em>5</em>
                            </li>
                        	<li id="tuesday" class="clearfix">
                            	<span>Tuesday</span>
                                <div><span></span></div>
                                <em>2</em>
                            </li>
                        	<li id="wednesday" class="clearfix">
                            	<span>Wednesday</span>
                                <div><span></span></div>
                                <em>1</em>
                            </li>
                        	<li id="thursday" class="clearfix">
                            	<span>Thursday</span>
                                <div><span></span></div>
                                <em>52</em>
                            </li>
                        	<li id="friday" class="clearfix">
                            	<span>Friday</span>
                                <div><span></span></div>
                                <em>12</em>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row classroom-modules">
            	<div class="col-md-12">
                	<div class="classroom-module-wrapper">
                    	<div class="module">
                        	<span class="progress"><p>Module 1</p><em>50%</em></span>
                        </div>
                        <div class="lesson-variables clearfix">
                        	<span class="progress"><p>Lesson 2 - Variables</p><em>45%</em></span>                        
                        </div>
                        <div class="lesson-variables clearfix">
                        	<span class="progress"><p>Lesson 2 - Variables</p><em>45%</em></span>                        
                        </div>
                        <div class="lesson-variables clearfix">
                        	<span class="progress"><p>Lesson 2 - Variables</p><em>45%</em></span>                        
                        </div>
                        <div class="lesson-variables last clearfix">
                        	<span class="progress"><p>Lesson 2 - Variables</p><em>45%</em></span>                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="row classroom-modules">
            	<div class="col-md-12">
                	<div class="classroom-module-wrapper">
                    	<div class="module">
                        	<span class="progress"><p>Module 1</p><em>50%</em></span>
                        </div>
                        <div class="lesson-variables clearfix">
                        	<span class="progress"><p>Lesson 2 - Variables</p><em>45%</em></span>                        
                        </div>
                        <div class="lesson-variables clearfix">
                        	<span class="progress"><p>Lesson 2 - Variables</p><em>45%</em></span>                        
                        </div>
                        <div class="lesson-variables clearfix">
                        	<span class="progress"><p>Lesson 2 - Variables</p><em>45%</em></span>                        
                        </div>
                        <div class="lesson-variables last clearfix">
                        	<span class="progress"><p>Lesson 2 - Variables</p><em>45%</em></span>                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="row classroom-modules">
            	<div class="col-md-12">
                	<div class="classroom-module-wrapper">
                    	<div class="module">
                        	<span class="progress"><p>Module 1</p><em>50%</em></span>
                        </div>
                        <div class="lesson-variables clearfix">
                        	<span class="progress"><p>Lesson 2 - Variables</p><em>45%</em></span>                        
                        </div>
                        <div class="lesson-variables clearfix">
                        	<span class="progress"><p>Lesson 2 - Variables</p><em>45%</em></span>                        
                        </div>
                        <div class="lesson-variables clearfix">
                        	<span class="progress"><p>Lesson 2 - Variables</p><em>45%</em></span>                        
                        </div>
                        <div class="lesson-variables last clearfix">
                        	<span class="progress"><p>Lesson 2 - Variables</p><em>45%</em></span>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="container-fluid become-an-instructor affiliate">
            <div class="container">
              <div class="row">
                <div class="col-xs-12">
                  <h1>BECOME</h1>
                  <h2>AN INSTRUCTOR</h2>
                  <a href="{{ action('InstructorsController@become') }}"><span>{{trans('site/homepage.get-started')}}</span></a>
                </div>
              </div>
          </div>
        </section>
    </div>
    @stop