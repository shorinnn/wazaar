<?php
    $date = new DateTime();
    $date->setTimezone(new DateTimeZone('Asia/Tokyo'));
    $now = strtotime( $date->format('Y-m-d H:i:s') ) ;
    $show_on = strtotime( '2015-09-10 17:15:00' );
?>
<section class="course-description-container container-fluid clearfix">
    @if($course->bannerImage==='has banner bro')
        <img src='{{$course->bannerImage->url}}' />
    @endif
    <div class="main-content container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8">
                @if (Session::get('success'))
                    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
                @endif
                @if (Session::get('error'))
                    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
                @endif
                <div class="course-description no-margin-top module-box padding-top-30 padding-bottom-20">
                    <h2>{{ trans('courses/general.about-this-course') }}</h2>
                    <p class="intro-paragraph short-text">
                        {{ strip_tags_and_attributes($course->description, "<p><b><ol><ul><li><u><br>")}}
                    </p>
                    <!--<div class="fadeout-text"></div>-->
                    <!--<span class="show-full-description"> {{ trans("courses/general.show-full-description") }}</span>-->
                </div>
                <div class="what-you-will-learn no-margin-top module-box padding-top-30 padding-bottom-20">
                    <h2>{{ trans('courses/general.what-you-will-learn') }}</h2>
                    <ul>
                        @if($achievements = json2Array($course->what_will_you_achieve))
                            @foreach($achievements as $achievement)
                                <li>{{ $achievement }}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div class="who-its-for no-margin-top module-box padding-top-30 padding-bottom-20">
                    <h2>{{ trans('courses/general.who_is_this_for?') }}</h2>
                    @if($who_for = json2Array($course->who_is_this_for))
                        <ul>
                            @foreach($who_for as $who)
                                <li>{{$who}}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="requirements no-margin-top module-box padding-top-30 padding-bottom-20">
                    <h2>{{ trans('courses/general.requirements') }}</h2>
                    @if($requirements = json2Array($course->requirements))
                        <ul>
                            @foreach($requirements as $requirement)
                                <li>{{ $requirement }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                @foreach($course->modules as $module)
                    <div class="module-box">
                        <h2>{{ $module->order }}. {{ $module->name }}</h2>
                        <p class="regular-paragraph">
                            <!--A short description of the module goes here...-->
                        </p>
                        <ul class="lesson-topics expandable-content clearfix">
                            @foreach($module->lessons as $i=>$lesson)
                                <li class="lessons lesson-1 bordered clearfix">
                                    <span class="hidden-xs"><i class="wa-play"></i></span>
                                    <!--{{ Str::limit( $lesson->name, Config::get('custom.course-desc-lesson-chars') )  }}-->
                                    <a class="clearfix lesson-name" data-toggle="tooltip" title="{{$lesson->name}}" @if($i == 0) data-placement="bottom" @endif>{{$lesson->name}}</a>
                                    <!--<em>Type of lesson</em>-->
                                    <div class="buttons">
                                        @if($lesson->blocks()->where('type','video')->first() != null
                                            && VideoFormat::where('video_id', $lesson->blocks()->where('type','video')->first()->content )
                                                    ->first() !=null
                                            )
                                            <a href="#" class="default-button reading-button large-button">
                                                {{
                                                    VideoFormat::where('video_id', $lesson->blocks()->where('type','video')->first()->content )->first()
                                                            ->duration
                                                }}</a>
                                        @endif

                                        @if( $lesson->free_preview == 'yes' )
                                            <!--<a href="#" class="default-button preview-button large-button">Preview</a>-->
                                                @if( Auth::check() && Student::find(Auth::user()->id)->purchased($lesson)  )
                                                        <a href='{{ action( 'ClassroomController@lesson', 
                                                        [ 'course' => $lesson->module->course->slug, 'module' => $lesson->module->slug, 
                                                    'lesson' => $lesson->slug ] )}}' class='blue-button preview-button large-button' >Enter</a>
                                                @else
                                                <!-- to purchase -->
                                                    @if($now > $show_on)
                                                        {{ Form::open( [ 'action' => ['CoursesController@crashLesson', $course->slug, $lesson->slug ], 'class' => 'inline-form' ] ) }}
                                                    @else
                                                        {{ Form::open( [  'class' => 'inline-form' ] ) }}
                                                    @endif
                                                    <button type="submit" class='blue-button preview-button large-button'
                                                    @if( $now<$show_on || 
                                                    (Auth::check() && ( !Auth::user()->canPurchase($course) || !Auth::user()->canPurchase($lesson) ) ) )
                                                            disabled="disabled" data-crash-disabled='1'
                                                            @endif
                                                            ><small class="hidden-xs">{{ trans('courses/general.free_preview') }}</small><i class="fa fa-eye hidden-sm hidden-md hidden-lg"></i></button>
                                                      {{ Form::close() }}
                                                      <!-- / to purchase -->
                                                @endif
                                        @else
                                            @if( $lesson->individual_sale == 'yes' )
                                                <!--<a href="#" class="blue-button buy-button large-button">Buy</a>-->
                                                    @if( Auth::check() && Student::find(Auth::user()->id)->purchased($lesson)  )
                                                            <a href='{{ action( 'ClassroomController@lesson', 
                                                            [ 'course' => $lesson->module->course->slug, 'module' => $lesson->module->slug, 
                                                        'lesson' => $lesson->slug ] )}}' class='blue-button preview-button large-button' >Enter</a>
                                                        @else
                                                            <!-- can purchase -->
                                                            @if($now > $show_on)
                                                                {{ Form::open( [ 'action' => ['CoursesController@purchaseLesson', $course->slug, $lesson->slug ], 'class' => 'inline-form' ] ) }}
                                                            @else
                                                                {{ Form::open( [ 'class' => 'inline-form' ] ) }}
                                                            @endif
                                                            <button class="blue-button buy-button large-button"
                                                             @if( $now<$show_on || 
                                                                (Auth::check() && ( !Auth::user()->canPurchase($course) || !Auth::user()->canPurchase($lesson) ) ) )
                                                                    disabled="disabled" data-crash-disabled='1'
                                                                    @endif
                                                                    >{{ trans('courses/general.purchase') }}</button>
                                                            {{ Form::close() }}
                                                            @endif
                                                            <!-- / can purchase -->
                                                        @endif
                                                      
                                        @endif



                                    </div>
                                </li>

                            @endforeach
                        </ul>
                            <!--<span class="hide-lesson-topics">{{ trans('courses/general.show-more-lessons') }}</span>-->
                    </div>
                @endforeach
                
                @if( $gift != null )
                
                    <div class="affiliate-gift-wrap">
                                    <div class="row description-wrap no-margin">
                                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-center">
                                            <img class="img-responsive gift-coupon inline-block" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/gift-coupon.png" alt="">
                                    </div>
                                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                        <div class="description">
                                            <h3>
                                                {{ trans('affiliates.gifts.included-course-gift-from-name', ['name' => $gift->affiliate->fullName()] ) }}
                                            </h3>
                                            <p>{{ $gift->text }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                @endif
					<div class="reviews instructed-by clearfix module-box">
                        <div class="row no-margin">
                            <div class="user-thumb col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            	<div class="img-wrap">
                                                                    <img class="img-responsive" src="https://wazaar.s3-ap-northeast-1.amazonaws.com/profile_pictures/e1R1KMzoiZzH2rfp.png">
                                                                    </div>
                                                                    
                                                            </div>
                            <div class="user-review col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <div class="clearfix margin-bottom-20">
                                    <h4>Instructed By<em class="name"> 高梨 陽一郎</em></h4>
                                    <span class="role"></span>
                                </div>
                                <p class="regular-paragraph expandable-content">
                                    株式会社GLOBAL POWER EXPERT代表取締役社長 / 通販エキスパートコーチ

経歴： 株式会社アクディア&#12288;代表取締役社長  / 
株式会社ピーズ&#12288;代表取締役社長  / 
グローバルメディカル研究所株式会社&#12288;代表取締役社長  / RIZAP株式会社&#12288;取締役  / 株式会社GLOBAL POWER EXPERT 代表取締役社長   / 

1974年千葉県生まれ。中学でアメリカンフットボールと出逢い、以降高校・大学・社会人実業団トップのXリーグに至るまで17年間プレイ。その間2チームにて主将を経験。組織プレイスポーツのトップリーダーとして活躍した。24歳の時に9億円もの借金を抱え父が他界。「金持ち父さん、貧乏父さん」（ロバートキヨサキ）の影響を受け
株式投資・自己投資に多額の資金を投入し、後にインターネットビジネスと出会う。情報販売、アフィリエイト等で月100万程度稼ぐも情熱が感じられずインフォプレナーを引退。その時に唯一残った「35歳でハワイに住む」という夢を追いかけ
自身が作成した目標達成法で3年早く達成。その後9億円の借金を独自の戦略と交渉術で13年間で解消。&ensp;夢を更に大きくするために当時社長が28歳で上場させた企業に一般社員として入社後
1ヶ月でグループ会社の幹部、そして3ヶ月後に社長に就任。他2社のグループ会社代表を経験。同時に化粧品ブランドのブランドオーナーを2期経験し通販のみで年間売上72億の事業にする。

&ensp;メディアマーケティング、ダイレクトレスンポンスマーケティング、インバウンドマーケティング等インターネットだけに留まらず、あらゆる広告媒体を軸としたクロスメディアマーケティングを熟知。2014年4月に独立し同時に株式会社GLOBAL POWER EXPERT代表取締役に就任。  / 
現在は、通販コンサル、コーチング、セミナー業、塾の運営、コンテンツ事業、通信販売業他様々な事業を手がけている。

&ensp;自身の最大の強みは「事業会社での経験」と「人と違った行動」。BtoCビジネスを長く経験しており、インターネットだけでなくTV・紙媒体・ラジオ・交通広告等を使いモノやサービスを売るという経験が豊富。商品開発・マーケティング・クリエイティブ制作・広告購買・販売・CRM施策・
顧客サービス・物流関連等、通販におけるあらゆる分野を経験しており、表面的な代理業等ではなく事業会社として生きた数字を取り扱ってきた。

&ensp;また、企業文化の創造・育成・理念経営を行い部下の育成とともに会社を成長させることに従事。
社内外でもセミナー・コーチングをしており、
あらゆる視点から人とコミュニケーションをすることを得意とする。

&ensp;尊敬する人物：
健康コーポレーション株式会社&#12288;代表取締役社長&#12288;瀬戸 健 / 株式会社リッツコンサルティング&#12288;代表取締役社長&#12288;井口 晃 / 米マクドナルド創始者&#12288;レイ・クロック

&ensp;座右の銘：「勇気を持って、誰よりも先に、人と違ったことをする！」（レイ・クロック）/
「夢は逃げない。逃げるのはいつも自分だ！」（高橋歩）/「世界に変化を望むなら、自らがその変化となれ！」（マハトマ・ガンジー）
/「勇気と情熱を持って全力で生きよう！」（高梨陽一郎）

                                </p>
                                <div class="fadeout-text"></div>
                                <span class="view-more-reviews expandable-button show-more" data-less-text='Less' data-more-text='More'>more</span>
                            </div>
                        </div>
                    </div>
                @if( $course->assignedInstructor != null && $course->assignedInstructor->profile !=null  )
                    <div class="reviews instructed-by clearfix module-box">
                        <div class="row no-margin">
                            <div class="user-thumb col-xs-3 col-sm-2 col-md-2 col-lg-2">
                            	<div class="img-wrap">
                                @if($course->assignedInstructor->profile == null || $course->assignedInstructor->profile->photo == '')
                                    <img src="{{cloudfrontUrl("//s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg")}}"
                                         class="img-responsive" />
                                @else
                                    <img src="{{cloudfrontUrl( $course->assignedInstructor->profile->photo )}}"
                                         class="img-responsive" />
                                @endif
                                </div>
                            </div>
                            <div class="user-review col-xs-9 col-sm-10 col-md-10 col-lg-10">
                                <div class="clearfix margin-bottom-20">
                                    <h4>{{trans('courses/general.instructed-by') }}<em class="name"> {{ $course->assignedInstructor->fullName() }}</em></h4>
                                    <span class="role">{{ $course->assignedInstructor->profile->title }}</span>
                                </div>
                                <p class="regular-paragraph expandable-content">
                                    {{ $course->assignedInstructor->profile->bio }}
                                </p>
                                <div class="fadeout-text"></div>
                                <span class="view-more-reviews expandable-button show-more" data-more-text="More" data-less-text="Less">{{ trans("courses/general.profile-more") }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if($course->allTestimonials->count() > 0)
                    <div class="lesson-reviews">
                        <h2>{{ $course->testimonials()->count() }} {{ trans("courses/general.reviews") }}</h2>
                        <div class='bottom-testimonials'>
                            @foreach($course->allTestimonials as $testimonial)
                                <!--<div>-->
                                {{ View::make('courses.testimonials.testimonial')->with( compact('testimonial') ) }}
                                <!--</div>-->
                            @endforeach
                        </div>

                        <!--<span class="read-all-reviews">Read all reviews</span>-->
                        <a href='#' id="load-more-ajax-button" class="load-more-comments load-more-ajax read-all-reviews"
                           data-url='{{ action('TestimonialsController@more') }}'
                           data-target='.bottom-testimonials' data-skip='5' data-id='{{ $course->id }}' data-post-field="course">
                            {{ trans('general.read-all-reviews') }}
                        </a>
                    </div>
                @endif

            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="sidebar">

                </div>
            </div>
        </div>
    </div>
</section>