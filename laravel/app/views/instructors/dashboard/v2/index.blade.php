@extends('layouts.default')
@section('page_title') 売上管理 - Wazaar @stop
@section('content')
	<div class="container-fluid new-dashboard instructor-dashboard top-section">
    	<div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <div class="row activity-today @if(!Input::has('sort')) invisible @endif">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <span class="sales-today">{{trans('analytics.sales')}} <em>{{trans('analytics.today')}}
                                    <!--<i class="wa-chevron-down"></i>--></em></span>
                        </div>
                    </div>
                    <div class="row activity-today @if(!Input::has('sort')) invisible @endif">
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 no-margin">
                            <h2 class="revenue">
                                 ¥{{ number_format( $instructor->money('revenue','today') , Config::get('custom.currency_decimals')) }}
                                 <span class="">{{trans('analytics.revenue')}}</span></h2>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-5 no-margin">
                            <h2 class="profit success">
                                ¥{{ number_format( $instructor->money('profit','today') , Config::get('custom.currency_decimals')) }}
                                <span class="">{{trans('analytics.profit')}}</span></h2>
                        </div>
                    </div>
                    <div class="row activity-today @if(!Input::has('sort')) invisible @endif">
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
                        <li role="presentation" @if(Input::has('sort')) class="active" @endif >
                        	<a href="#teaching" role="tab" id="teaching-tab" data-toggle="tab" aria-controls="teaching"
                                    aria-expanded="true" onclick='toggleNumbers(1); dashUrl("{{url("courses/mycourses/teaching") }}")'>                                  
                                    {{trans('general.dash.teaching')}}
                                </a>
                        </li>
                        <li role="presentation">
                        	<a href="#enrolled" role="tab" id="enrolled-tab" data-toggle="tab" aria-controls="enrolled"  
                                   onclick='toggleNumbers(0); dashUrl("{{url("courses/mycourses/enrolled")}}")'
                                   aria-expanded="true">
                                {{trans('general.dash.enrolled')}}</a>
                        </li>
                        <li role="presentation">
                        	<a href="#finished" role="tab" id="finished-tab" data-toggle="tab" aria-controls="finished"
                                   onclick='toggleNumbers(0); dashUrl("{{url("courses/mycourses/finished") }}")'>
                                 {{trans('general.dash.finished')}}</a>
                        </li>
                        <li role="presentation">
                          <a href="#wishlist" role="tab" id="wishlist-tab" data-toggle="tab"  aria-controls="wishlist"
                             onclick='toggleNumbers(0); dashUrl("{{url("courses/mycourses/wishlist") }}")'>
                           {{trans('general.dash.wishlist')}}</a>
                        </li>
                    </ul> 
                    
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard dashboardTabs instructor-dashboard">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 pull-right">
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in margin-bottom-25  @if(Input::has('sort')) active in @endif" id="teaching">
                          @if( $courses->count() == 0 )
                            <p class="text-center">{{ trans('courses/create.no-courses-yet-create-one') }}</p>
                            
                            <div class="text-center clearfix">
                            <br />
                            </div>
                          @endif
                          
                          @foreach($courses as $course)
                            <div class="row margin-bottom-25 course-row-{{$course->id}}">

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="clearfix teaching-lesson no-border finished-lesson">
                                        <div class="row row-1">
                                        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 column-1">
                                            	<div class="row column-1-row-1">
                                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                      <div class="image-wrap">
                                                           @if($course->previewImage!=null)
                                                            <!--<a href="{{ $course->previewImage->url }}" target="_blank">-->
                                                            <span>
                                                                <img src="{{ $course->previewImage->url }}" class="img-responsive" />
                                                            </span>
                                                            @else
                                                            	<img src="http://placehold.it/360x203" class="img-responsive">
                                                                <!--<p style="margin-top:35px;">{{ trans('courses/create.no-uploaded-image') }}</p>-->
                                                            @endif 
                                                      </div>
        
                                                    </div>
                                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                      <h4>
                                                              <span class="lesson-status {{$course->publish_status}}">
                                                                   {{ trans('courses/general.my-courses-publish.'.$course->publish_status) }}
                                                              </span>
                                                          @if( !$course->publish_status=='approved' )
                                                              {{$course->name}}
                                                          @else
                                                              <a href="{{ action('CoursesController@show', $course->slug) }}">{{$course->name}}</a>
                                                          @endif
                                                      </h4>
                                                      <p class="regular-paragraph">
                                                          <em class="">{{ date('m/d/Y', strtotime($course->created_at)) }}</em>
                                                          <em class="paid"> 
                                                                @if($course->free=='yes')
                                                                    {{ trans('courses/create.free') }}
                                                                @else
                                                                    {{  trans('courses/create.paid') }}
                                                                @endif
                                                          </em>
                                                          <em class="public"> {{ trans('courses/general.my-courses-privacy.'.$course->privacy_status) }}</em>
                                                      </p>
                                                      <!-- price -->
                                                      @if($course->free!='yes' && $course->cost() > 0)
                                                          @if($course->isDiscounted())
                                                                <span class="prev-price"> ¥ {{ number_format( $course->discount_original, Config::get('custom.currency_decimals') ) }}</span>
                                                                <span class="discounted-price">
                                                                    ¥{{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}
                                                                </span>
                                                                <!--{{trans('courses/general.sale')}}-->
                                                            @else

                                                                <span class="price">¥{{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}</span>
                                                            @endif     
                                                        @endif
                                                      <!--/price -->
                                                    </div>
                                                </div>
                                                <div class="row column-1-row-2">
                                                	<div class="col-xs-6 col-sm-6 col-md-5 col-lg-5">
                                                    <p class="revenue">{{trans('analytics.revenue')}} 
                                                    	<span>
                                                    ¥{{ number_format( $course->money('revenue') , Config::get('custom.currency_decimals')) }}
                                                    	</span>
                                                    </p>
                                                    </div>
                                                	<div class="col-xs-6 col-sm-6 col-md-7 col-lg-7 text-right">
                                                    	<a href="{{ action('InstructorDashboardController@course', $course->slug)}}" class="default-button see-stat"><i class="fa fa-line-chart"></i>
                                                            <span class="hidden-xs">{{ trans('analytics.see_statistics') }}</span>
                                                        </a>
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
                                                                             data-url="{{ action('CoursesController@destroy', [ $course->id ]) }}" 
                                                                             data-callback = 'deleteItem' 
                                                                             data-delete = '.course-row-{{$course->id}}' 
                                                                             data-message="{{ trans('crud/labels.you-sure-want-delete') }}">    
                                                                          {{trans('crud/labels.delete')}}</a>
                                                                      </li>
                                                                  @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 column-2">
                                                  <p><i class="fa fa-comments-o"></i>{{ trans('courses/general.discussions') }} 
                                                      <span class="count">
                                                          {{-- $course->newDiscussions($lastVisit) --}} 
                                                          {{ $course->totalDiscussions() }} 
                                                          <em></em> <!--new--></span></p>
                                                  <p><i class="fa fa-shopping-cart"></i>
                                                      {{ trans('courses/general.purchases') }}
                                                      <span class="count">
                                                          {{ $course->enrolledStudents(true) }} <em></em> 
                                                      <!--
                                                      {{ trans('courses/general.purchases') }} <span class="count new">
                                                          {{ $course->sales()->count() + $course->lessonSalesCount() }}--></span>
                                                  </p>
                                                 <p><i class="fa fa-smile-o"></i>{{ trans('analytics.previewers') }} 
                                                     <span class="count new">
                                                         @if( $course->nonBuyerPreviews(true) > 0)
                                                             {{ $course->nonBuyerPreviews(true) }} NEW
                                                             <em> ({{ $course->nonBuyerPreviews() }})</em>
                                                         @else
                                                             <em> {{ $course->nonBuyerPreviews() }}</em>
                                                         @endif
                                                     </span>
                                                 </p>
                                                 
                                                 <p><i class="wa-like"></i>{{ trans('analytics.reviews') }}
                                                     <span class="count">{{ $course->total_reviews }} <em> ({{ $course->reviewsScore() }})</em></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                          @endforeach
                          
                          <!-- summary area -->
                          <div class="row margin-bottom-25 ">

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="clearfix teaching-lesson no-border finished-lesson">
                                        <div class="row row-1">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column-1" style='min-height:50px; padding:0px'>
                                                <table class="table table-borderless" style='margin:0px; margin-top:-25px'>
                                                    <tr>　　　　　　　 
                                                        <td>総売上額</td>
                                                        <td>アフィリエイター報酬</td>
                                                        <td>２ティア報酬</td>
                                                        <td>システム手数料</td>
                                                        <td>販売収入</td>
                                                    </tr>
                                                    <tr>　　　　　　　 
                                                        <td> 
                                                            <span class="wazaar-green-text">¥{{ number_format( $instructor->money('purchase_price','all-time') , Config::get('custom.currency_decimals')) }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="wazaar-green-text">¥{{ number_format( $instructor->money('affiliate_earnings','all-time') , Config::get('custom.currency_decimals')) }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="wazaar-green-text">¥{{ number_format( $instructor->money('second_tier_affiliate_earnings','all-time') , Config::get('custom.currency_decimals')) }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="wazaar-green-text">¥{{ number_format( $instructor->money('total_site_earnings','all-time') , Config::get('custom.currency_decimals')) }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="wazaar-green-text">¥{{ number_format( $instructor->money('instructor_earnings','all-time') , Config::get('custom.currency_decimals')) }}</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">&nbsp;</div>
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <a href="{{action('CoursesController@create')}}" class="add-new-course add-new-from-header large-button blue-button">
                                    <i class="fa fa-plus"></i> 
                                    {{ trans('courses/create.create-btn-instructor') }}
                                </a> 
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"></div>
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <form>
                                    {{ Form::select('sort',[
                                        'date-new' => '作成日 新しい',
                                        'date-old' => '作成日 古い',
                                        'public' => '公開',
                                        'unlisted' => '限定公開',
                                        'private' => '非公開',
                                    ], Input::get('sort'), [ 'onchange' => 'this.form.submit()', 'class' => 'form-control' ] ) }}

                                </form>
                              </div>


                            </div>
                          <!-- /summary area -->
                          
                          {{ $courses->appends( [ 'sort' => Input::get('sort') ] )->links() }}
                          
                      </div>
                      <div role="tabpanel" class="tab-pane fade margin-bottom-25" id="enrolled">
                           @if( $purchasedCourses->count() == 0 )
                                @if(Auth::user()->_profile('Instructor') != null)
                                    @if( trim(Auth::user()->_profile('Instructor')->corporation_name) != '')
                                        <p class="text-center">学んでみたいことはありますか？</p> 
                                        <p class="text-center margin-top-10">Wazaarでコースを探してみましょう！</p>
                                    @else
                                        <!--{{ Auth::user()->_profile('Instructor')->last_name }}-->
                                         <p class="text-center">学んでみたいことはありますか？</p>
                                         <p class="text-center margin-top-10">Wazaarでコースを探してみましょう！</p>
                                    @endif                          
                                @elseif(Auth::user()->_profile('Student') != null)  
                                    <!--{{ Auth::user()->_profile('Student')->last_name }}-->
                                         <p class="text-center">学んでみたいことはありますか？</p>
                                         <p class="text-center margin-top-10">Wazaarでコースを探してみましょう！</p>
                                @else
                                    <p class="text-center">学んでみたいことはありますか？</p>
                                    <p class="text-center margin-top-10">Wazaarでコースを探してみましょう！</p>
                                @endif
                            @endif
                        
                          @foreach($purchasedCourses as $course)
                               {{View::make('student.dashboard.enrolled-course')->with( compact( 'course', 'student' ) ) }}
                          @endforeach
                          
                      </div>
                      <div role="tabpanel" class="tab-pane fade margin-bottom-25" id="finished">
             
                          @foreach($purchasedCourses as $course)
                              <?php
                              $course = $course->product;
                              if( $student->courseProgress( $course ) < 100 ) continue;
                              $completedCourse = true;
                              ?>
                               {{View::make('student.dashboard.completed-course')->with( compact( 'course', 'student' ) ) }}
                          @endforeach
                          
                          @if( !isset($completedCourse) )
                             <p class="text-center">あなたはまだ修了したコースがありません。</p>
                             <p class="text-center margin-top-10"> さあ、コースを探してみよう！</p>
                          @endif
                      </div>
                      <div role="tabpanel" class="tab-pane fade margin-bottom-25" id="wishlist">
                          @if($wishlist->count() == 0 )
                              <p class="text-center">お気に入りのコースはありません。</p>
                          @endif
                          
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
                             
                            @if( !isset($profile->photo) || trim($profile->photo) =='' )
                                <div class="upload-picture-button text-center" style="background-color: transparent; margin-top: 40%; border: none;
                                     margin-left: auto; margin-right: auto;">
                                    <form action="{{url('profile/upload-profile-picture')}}" enctype="multipart/form-data" id='picture-form' method="post">
                                        <label for="upload-new-photo" class="default-button large-button">
                                            <span>{{ trans('general.upload_new_picture') }}</span>
                                            <input type="file" hidden="" class='' id="upload-new-photo" name="profilePicture"/>
                                        </label>
                                        <p class="label-progress-bar label-progress-bar-preview-img"></p>
                                        <div class="progress hidden">
                                            <div class="progress-bar progress-bar-striped active progress-bar-preview" role="progressbar" aria-valuenow="0" 
                                                 data-label=".label-progress-bar-preview-img" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                                <span></span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
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

@section('extra_js')
<script src='{{ url('js/progressbar.min.js')}}'></script>
<script src="{{url('plugins/uploader/js/jquery.fileupload.js')}}"></script>
<script>
    function toggleNumbers(state){
        if(state==1){
            $('.activity-today').removeClass('invisible');
        }
        else{
            $('.activity-today').addClass('invisible');
        }
    }
    
        function showReview(cls){
            $(cls).modal('show');
        }
        
        function dashUrl(page){
            history.pushState({}, '', page);
        }
        
    $(function(){
        @if(count(Request::segments()) == 2)
          @if($purchasedCourses->count() > 0)
            $('[href="#enrolled"]').click(); //a
          @else
            $('[href="#teaching"]').click(); //w
          @endif
        @elseif(count(Request::segments()) >= 3)
          @if( !Input::has('sort'))
            $('[href="#{{Request::segment(3)}}"]').click(); //e
          @endif
        @endif


        //Hide and show the positive and negative review textareas and labels
        $('body').delegate('.yes-button','click',  function(){
                $('.positive-review-wrap').removeClass('hide');
                $('.negative-review-wrap').addClass('hide');
                $(this).addClass('active');
                $('.no-button').removeClass('active');
                $('.long-later-button').hide();
        });
        $('body').delegate('.no-button','click',  function(){
                $('.positive-review-wrap').addClass('hide');
                $('.negative-review-wrap').removeClass('hide');
                $(this).addClass('active');
                $('.yes-button').removeClass('active');
                $('.long-later-button').hide();
        });
        
        $('#upload-new-photo').fileupload()
                .bind('fileuploadprogress', function ($e, data){
                    $progressLabel = $('.label-progress-bar');
                    var $progress = parseInt(data.loaded / data.total * 100, 10);
                    var progressbar = '.progress-bar';
                    $(progressbar).css('width', $progress + '%');
                    if( $progressLabel.length > 0 ) $progressLabel.html($progress);
                    else $(progressbar).find('span').html($progress);
                    if($progress=='100'){
                        console.log( $progressLabel );
                        if( $progressLabel.length > 0 ) $progressLabel.html( _('Upload complete. Processing') + ' <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
                        else $(progressbar).parent().find('span').html( _('Upload complete. Processing') + ' <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
                    }
                }
                )
                .bind('fileuploaddone',function ($e,$data){
                    if ($data.result.success == 1){
                        $('.label-progress-bar').hide();
                        $('.progress-bar').hide();
                        $('#picture-form').remove();
                        $('#img-profile-picture').attr('src',$data.result.photo_url);
                        $('.profile-picture-holder').css('background-image', 'url('+$data.result.photo_url+')') ;
                    }
        });
        
            var hash = window.location.hash;
            if( isset(hash) ){
                $('[href="'+hash+'"]').click();
            }
            
            $('.progress-circle').each(function(){
                var $elem = $(this);
                var text = $elem.attr('data-text');
                var circle = new ProgressBar.Circle( '#'+$elem.attr('id'), {
                    color: $elem.attr('data-color'),
                    strokeWidth: 4,
                    trailWidth: 4,
                    trailColor: $elem.attr('data-trail-color'),
                    duration: 1000,
                    text: {
                        value: '0'
                    },
                    step: function(state, bar) {
                        if( typeof(text) == 'undefined') bar.setText((bar.value() * 100).toFixed(0));
                        else {
                            $elem.find('.progressbar-text').html( text );
                        }
                    }
                });
            progress = $elem.attr('data-progress') / 100;
            circle.animate( progress );
        });
            
    });
</script>
@stop
