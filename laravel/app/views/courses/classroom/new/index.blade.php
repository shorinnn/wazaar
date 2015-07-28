@extends('layouts.default')
@section('content')
    <div class="container-fluid classroom-view">
        <style>
            header, footer{
                display: none;
            }
        </style>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <div class="classroom-header row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <span class="left-menu slide-menu-toggler">
                            <i class="wa-hamburger"></i>
                        </span>
                        <a href="3" class="logo">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive">
                        </a>
                        <h4 class="lesson-title">1.1. {{$course->modules->first()->lessons->first()->name}}</h4>
                        <div class="navigate-lessons-buttons">
                            <a href="#" class="prev-button"><i class="wa-chevron-left"></i></a>
                            <a href="#" class="next-button">Next lesson <i class="wa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="video-player video-container classroom-video" style="background:none; text-align: right">
                            <div class="videoContainer">
                                <video id="myVideo" preload="auto">
                                    <source src="#" type="video/mp4">
                                    <p>Your browser does not support the video tag.</p>
                                </video>
                                <div class="control-container clearfix">
                                    <div class="control">

                                        <div class="btmControl clearfix">
                                            <div class="btnPlay btn" title="Play/Pause video">
                                                <i class="wa-play"></i>
                                                <i class="wa-pause"></i>
                                            </div>
                                            <div class="time hidden-xs">
                                                <span class="current"></span>
                                            </div>
                                            <div class="topControl">
                                                <div class="progress">
                                                    <span class="bufferBar"></span>
                                                    <span class="timeBar"></span>
                                                </div>
                                                <div class="add-video-note">
                                                    <span class="note-number">11</span>
                                                    <form>
                                                        <input type="text" placeholder=" Add note ...">
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="volume-container">
                                                <div class="volume" title="Set volume">
                                                        <span class="volumeBar">
                                                            <em></em>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="time hidden-xs">
                                                <span class="duration"></span>
                                            </div>
                                            <div class="sound sound2 btn hidden-xs" title="Mute/Unmute sound">
                                                <i class="wa-sound"></i>
                                                <i class="fa fa-volume-off"></i>
                                            </div>
                                            <div class="btnFS btn" title="Switch to full screen"><i class="wa-expand"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="loading"></div>
                            </div>
                            <!--<div id="lesson-video-overlay">
                                <div>
                                </div>
                            </div>-->
                            <span class="play-intro-button"><i class="wa-play"></i><em>{{ trans("courses/general.play-intro") }}</em></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="questions-sidebar">
                    <div class="header clearfix">
                        <a href="#" class="questions-tab-header active">45 Questions</a>
                        <a href="#" class="notes-tab-header">10 Notes</a>
                    </div>
                    <div class="tab-contents clear">
                        <div class="rows search-discussion-form">
                            <form>
                                <div>
                                    <input type="search" placeholder="Search discussion ...">
                                    <button><i class="wa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="rows questions-box">
                            <span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="rows questions-box">
                            <span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="rows questions-box">
                            <span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="rows questions-box">
                            <span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="rows questions-box">
                            <span class="question-title">What are the most influential UX design blogs?</span>
                            <span class="replies-count">2 Replies  </span>
                        </div>
                        <div class="ask-question">
                            <div class="img-container">
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                            </div>
                            <span>Ask a question</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="slide-menu">
            <div class="header">
                <div class="clearfix">
                    <a href="#" class="course"><i class="wa-chevron-left"></i>Course</a>
                    <span class="toggler slide-menu-toggler"><i class="wa-hamburger-close"></i></span>
                </div>
                <h2 class="clear">{{$course->name}}</h2>
                <div class="progress-box">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {{ $student->courseProgress($course)  }}%;">
                            <span></span>
                        </div>
                    </div>
                    <span class="progress-count">{{ $student->courseProgress($course)  }}%</span>
                </div>
            </div>

            @foreach($course->modules as $index => $module)
                <div class="course-topics-box">
                    <div class="topic-header clearfix">
                        <h3 class="left"><em>{{$index+1}}. </em> {{$module->name}}</h3>
                        <span class="right">1/5</span>
                    </div>
                    <div class="topics">
                        <ul>
                            @foreach($module->lessons as $lesson)
                                @if( $student->purchased($course) || $student->purchased( $lesson ) )
                                    <li @if( $student->isLessonViewed($lesson) ) class="viewed" @endif>
                                        <a href="#">{{$lesson->name}}<span><em></em><i class="wa-check"></i></span></a>
                                    </li>
                                @endif
                            @endforeach

                        </ul>
                    </div>
                </div>
            @endforeach

    </div>

@stop
