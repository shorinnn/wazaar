@extends('layouts.default')
@section('content')
	<div class="container-fluid new-dashboard instructor-dashboard top-section">
    	<div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <div class="row activity-today">
                    	<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 hide">
                        	<h2>{{trans('general.activity-today')}}<i class="wa-chevron-down"></i></h2>
                        </div>
                    	<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 hide">
                        	<span class="count">-</span>
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/small-graph.png" class="small-graph">
                            <p>{{trans('general.new-users')}}</p>
                        </div>
                    	<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 hide">
                        	<span class="count">-</span>
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/small-graph.png" class="small-graph">
                            <p>{{trans('general.new-questions')}}</p>
                        </div>
                    	<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 hide">
                        	<span class="count">-</span>
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/small-graph.png" class="small-graph">
                            <p>{{trans('general.new-discussions')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard instructor-dashboard dashboardTabs-header">
    	<div class="container">
        	<div class="row">
            	<div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 no-padding">
                    <ul class="nav nav-pills left" role="tablist">
                        <li role="presentation" class="active">
                        	<a href="#teaching" role="tab" id="teaching-tab" data-toggle="tab" aria-controls="enrolled" aria-expanded="true">
                                    {{trans('general.dash.teaching')}}
                                </a>
                        </li>
                        <li role="presentation" class="">
                        	<a href="#enrolled" role="tab" id="enrolled-tab" data-toggle="tab" aria-controls="enrolled" aria-expanded="true">
                                {{trans('general.dash.enrolled')}}</a>
                        </li>
                        <li role="presentation">
                        	<a href="#finished" role="tab" id="finished-tab" data-toggle="tab" aria-controls="finished">
                                 {{trans('general.dash.finished')}}</a>
                        </li>
                        <li role="presentation" class="dropdown">
                          <a href="#wishlist" role="tab" id="wishlist-tab" data-toggle="tab" aria-controls="wishlist">
                           {{trans('general.dash.wishlist')}}</a>
                        </li>
                    </ul> 
                    @if( $courses->count() > 0 )
                        <a href="{{action('CoursesController@create')}}" class="right add-new-course add-new-from-header large-button blue-button">
                            <i class="fa fa-plus"></i> 
                            {{ trans('courses/create.create-btn-instructor') }}
                        </a>    
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard dashboardTabs instructor-dashboard">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 pull-right">
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in active margin-bottom-25" id="teaching">
                          @if( $courses->count() == 0 )
                            {{ trans('courses/create.no-courses-yet-create-one') }}
                            
                            <a href="{{action('CoursesController@create')}}" class="right add-new-course large-button blue-button">
                                <i class="fa fa-plus"></i> 
                                {{ trans('courses/create.create-btn-instructor') }}
                            </a>  
                          @endif
                          
                          @foreach($courses as $course)
                            <div class="row margin-bottom-25 course-row-{{$course->id}}">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="clearfix teaching-lesson no-border finished-lesson">
                                        <div class="row row-1">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                              <div class="image-wrap">
                                                   @if($course->previewImage!=null)
                                                    <a href="{{ $course->previewImage->url }}" target="_blank">
                                                        <img src="{{ $course->previewImage->url }}" class="img-responsive" />
                                                    </a>
                                                    @else
                                                        <p style="margin-top:35px;">{{ trans('courses/create.no-uploaded-image') }}</p>
                                                    @endif 
                                              </div>

                                            </div>
                                            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                              <h4>
                                                  @if( !$course->publish_status=='approved' )
                                                      {{$course->name}}
                                                  @else
                                                      <a href="{{ action('CoursesController@show', $course->slug) }}">{{$course->name}}</a>
                                                  @endif
                                                      <span class="lesson-status {{$course->publish_status}}">
                                                           {{ trans('courses/general.my-courses-publish.'.$course->publish_status) }}
                                                      </span>
                                              </h4>
                                              <p class="regular-paragraph"><span class="created-on">
                                                      {{ trans('general.created-on') }}
                                                      :</span> {{ date('m/d/Y', strtotime($course->created_at)) }}</p>
                                              <p class="regular-paragraph">
                                                  <span class="status">{{ trans('general.status') }}</span>
                                                  <em class="paid"> 
                                                        @if($course->free=='yes')
                                                            {{ trans('courses/create.free') }}
                                                        @else
                                                            {{  trans('courses/create.paid') }}
                                                        @endif
                                                  </em>
                                                  <em class="public"> {{ trans('courses/general.my-courses-privacy.'.$course->privacy_status) }}</em>
                                              </p>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                  <div class="settings activate-dropdown">
                                                  <button aria-expanded="false" data-toggle="dropdown" 
                                                  class="settings-button dropdown-toggle" type="button" id="btnGroupDrop2">
                                                      <i class="fa fa-cog"></i>
                                                      <i class="wa-chevron-down"></i>
                                                  </button>
                                                  <div id="" aria-labelledby="btnGroupDrop2" role="menu" class="dropdown-menu">
                                                          <ul>
                                                          <li>
                                                                  <a target='_blank' href="{{ action('CoursesController@show', $course->slug) }}?preview=1">{{ trans('courses/general.preview_course') }}</a>
                                                          </li>
                                                          <li>
                                                                  <a target='_blank' href="{{ action('ClassroomController@dashboard', $course->slug) }}">{{ trans('courses/general.go-to-dashboard') }}</a>
                                                          </li>
                                                          <li>
                                                                  <a href="{{ action('CoursesController@edit', $course->slug) }}">{{ trans('courses/general.edit') }}</a>
                                                          </li>
                                                         
                                                         @if( $course->student_count == 0)
                                                            <li>
                                                                <a href="{{ action('CoursesController@destroy', [ $course->id ]) }}" 
                                                                   class="delete link-to-remote-confirm"
                   data-url="{{ action('CoursesController@destroy', [ $course->id ]) }}" data-callback = 'deleteItem' 
                   data-delete = '.course-row-{{$course->id}}' data-message="{{ trans('crud/labels.you-sure-want-delete') }}">    
                                                                {{trans('crud/labels.delete')}}</a>
                                                            </li>
                                                        @endif
                                                      </ul>
                                                  </div>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="row row-2">
                                          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
                                                  <p><i class="fa fa-comments-o"></i>{{ trans('courses/general.discussions') }} 
                                                      <span class="count new">{{ $course->newDiscussions($lastVisit) }} <!--new--></span></p>
                                          </div>
                                          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
                                                  <!--<p><i class="fa fa-comment-o"></i>questions <span class="count">24</span></p>-->
                                                  <!--<p><i class="fa fa-comment-o"></i>questions <span class="count">24</span></p>-->
                                                 <p><i class="fa fa-smile-o"></i>{{ trans('courses/general.non-buyer-previewers') }} 
                                                     <span class="count new">{{ $course->nonBuyerPreviews() }}</span></p>

                                          </div>
                                          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
                                                  <p><i class="fa fa-shopping-cart"></i>
                                                      {{ trans('courses/general.purchases') }}
                                                      <span class="count new">
                                                          {{ $course->enrolledStudents(true) }} 
                                                      <!--
                                                      {{ trans('courses/general.purchases') }} <span class="count new">
                                                          {{ $course->sales()->count() + $course->lessonSalesCount() }} </span>
                                                      --></p>

                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          @endforeach
                          
                          {{ $courses->links() }}
                          
                      </div>
                      <div role="tabpanel" class="tab-pane fade margin-bottom-25" id="enrolled">
                        @if(Auth::user()->_profile('Instructor') != null)
                            @if( trim(Auth::user()->_profile('Instructor')->corporation_name) != '')
                                学んでみたいことはありますか？ Wazaarでコースを探してみましょう！
                            @else
                                {{ Auth::user()->_profile('Instructor')->last_name }}
                                 さん、学んでみたいことはありますか？ Wazaarでコースを探してみましょう！
                            @endif                          
                        @elseif(Auth::user()->_profile('Student') != null)  
                        
                            {{ Auth::user()->_profile('Student')->last_name }}
                                     さん、学んでみたいことはありますか？ Wazaarでコースを探してみましょう！
                        @else
                            さん、学んでみたいことはありますか？ Wazaarでコースを探してみましょう！
                        @endif
                        
                          @foreach($purchasedCourses as $course)
                               {{View::make('student.dashboard.enrolled-course')->with( compact( 'course', 'student' ) ) }}
                          @endforeach
                      </div>
                      <div role="tabpanel" class="tab-pane fade margin-bottom-25" id="finished">
                          あなたはまだ修了したコースがありません。 さあ、コースを探してみよう！
                          
                          @foreach($purchasedCourses as $course)
                              <?php
                              $course = $course->product;
                              if( $student->courseProgress( $course ) < 100 ) continue;
                              ?>
                               {{View::make('student.dashboard.completed-course')->with( compact( 'course', 'student' ) ) }}
                          @endforeach
                      </div>
                      <div role="tabpanel" class="tab-pane fade margin-bottom-25" id="wishlist">
                          お気に入りのコースはありません。
                          
                          @foreach($wishlist as $course)
                               {{View::make('student.dashboard.wishlist-course')->with( compact( 'course', 'student' ) ) }}
                          @endforeach
                      </div>
                    </div>                
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                	<div class="sidebar">
                        <div class="profile-picture-holder"
                             style='background:url(
                             @if( isset($profile->photo) && trim($profile->photo) !='' )
                                {{ $profile->photo }}
                            @else
                                http://s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg
                            @endif
                            ) no-repeat center center; background-color:white; background-size:100%'
                             >
                        </div>
                        <div href="#" class="name">
                            <h2>{{ Auth::user()->commentName('instructor') }}</h2>
                            <a href="{{action('ProfileController@index')}}" class="edit-profile"><i class="fa fa-cog"></i>{{ trans('general.edit-profile') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@stop
