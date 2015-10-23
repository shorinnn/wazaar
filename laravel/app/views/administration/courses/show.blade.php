@extends('layouts.default')

@section('content')
<style>
	.img-container img{
		margin: 0px auto;
	}
    .course-stats{
        border: 1px solid #E0E1E2;
        border-radius: 4px;
    }
    .date-filter .panel-heading{
    	padding: 5px;
    }
    .date-filter .large-button{
        padding-top: 7px;
        padding-bottom: 7px;
    }

    .course-stats .course-summary-block{
        border:0px;
    }
    .buttons-container,
    .actions-buttons-container{
        padding: 10px 0px;
    }
    .buttons-container div{
        margin-bottom: 10px;
    }
    .buttons-container div:last-child{
        margin-bottom: 0px;
    }
</style>
<div class="col-lg-10 col-lg-offset-1 show-course">
	<div class="row" style="margin-bottom:20px;">
    	<div class="col-md-12">
			<h1 class="icon img-container">
				@if(isset($course->previewImage->url) && !empty($course->previewImage->url))
				<img src="{{$course->previewImage->url}}" class="img-responsive" />
				@else
				<img src="{{ url('splash/logo.png') }}" class="img-responsive" />
				@endif
			</h1>
			<h1 class="text-center">{{$course->name}}</h1>
        </div>
    </div>
    <div class="container">
    	<div class="panel panel-default date-filter no-padding">
    		<div class="panel-heading">
    			<button type="button" class="pull-right blue-button large-button" style="margin-left: 10px" onclick="Analytics.ApplyCoursePageTableDateFilter(); return false;" >{{trans('analytics.applyFilter')}}</button>
	            <div id="reportrange" class="pull-right text-center" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
	                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
	                <span></span> <b class="caret"></b>
	            </div>
	            <div class="clearfix"></div>
    		</div>
    	</div>

	    <div class="panel panel-default course-stats no-padding">
	    	<div class="panel-heading">
				<h3 class="panel-title text-center">{{trans('analytics.salesStatistics')}}</h3>
			</div>
	        <div class="stats-block">
	            <div class="table-stats-wrapper">
	                <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
	            </div>
	            <div class="clearfix"></div>
	        </div>
	    </div>

	    <div class="panel panel-default top-course-stats no-padding">
	    	<div class="panel-heading">
				<h3 class="panel-title text-center">{{trans('analytics.topAffiliates')}}</h3>
			</div>
	        <div class="affiliate-block">
	            <div class="table-affiliates-wrapper">
					<div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
				</div>
	            <div class="clearfix"></div>
	        </div>
	    </div>
        <div class="details-container">
            <div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">{{ trans('administration.courses.label.lesson_duration' )}}</div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-left">{{$course->videoDuration()}}</div>
                <div class="clearfix"></div>
            </div>
            <div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">{{ trans('administration.courses.label.price' )}}</div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                    @if($course->free == 'no')
                        ¥ {{number_format($course->price)}}
                    @else
                        {{ trans('administration.courses.label.free' )}}
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>
            <div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">{{ trans('administration.courses.label.instructor' )}}</div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-left">{{$course->instructor->last_name.' '.$course->instructor->first_name}}</div>
                <div class="clearfix"></div>
            </div>
            <div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">{{ trans('administration.courses.label.instructor_email' )}}</div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-left">{{$course->instructor->email}}</div>
                <div class="clearfix"></div>
            </div>
            <div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">{{ trans('administration.courses.label.category' )}}</div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-left">{{$course->courseCategory->name}}</div>
                <div class="clearfix"></div>
            </div>
            <div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">{{ trans('administration.courses.label.subcategory' )}}</div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-left">{{$course->courseSubcategory->name}}</div>
                <div class="clearfix"></div>
            </div>
            <div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">{{ trans('administration.courses.label.date_submitted' )}}</div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-left">{{$course->created_at->diffForHumans()}}</div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="buttons-container">
            <div class="text-center col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-12">
                <a href="#" class="btn btn-default btn-block">View Description Page</a>
            </div>
            <div class="text-center col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-12">
                <a href="#" class="btn btn-default btn-block">Preview Course</a>
            </div>
            <div class="text-center col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-12">
                <a href="#" class="btn btn-default btn-block">View Individual Sales</a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="actions-buttons-container">
            <div class="text-center col-md-4 col-sm-4 col-xs-12">
                <a href="#" class="btn btn-primary btn-block">Edit</a>
            </div>
            <div class="text-center col-md-4 col-sm-4 col-xs-12">
                <a href="#" class="btn btn-success btn-block">Approve</a>
            </div>
            <div class="text-center col-md-4 col-sm-4 col-xs-12">
                <a href="#" class="btn btn-danger btn-block">Disapprove</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
@stop

@section('extra_css')
    <link rel="stylesheet" href="{{url('resources/select2-dist/select2.css')}}"/>
    <link rel="stylesheet" href="{{url('resources/select2-dist/select2-bootstrap.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('plugins/daterangepicker/daterangepicker.css')}}"/>
@stop

@section('extra_js')
    <script type="text/javascript" src="{{url('resources/select2-dist/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('js/instructor-analytics.js')}}"></script>
    <script type="text/javascript" src="{{url('js/admin.dashboard.js')}}"></script>
    <script src="{{url('resources/moment/min/moment.min.js')}}"></script>

    <script type="text/javascript" src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{url('js/instructor-analytics.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            Analytics.CourseId = '{{$course->id}}';
            Analytics.StatisticsUrl = 'analytics/course/stats/';
            Analytics.AffiliateUrl = 'analytics/course/affiliates/';
            Analytics.InitCalendarFilter();
            Analytics.InitCoursePage();
        });
    </script>
@stop