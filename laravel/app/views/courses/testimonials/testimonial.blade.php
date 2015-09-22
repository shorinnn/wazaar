<!--@if( $testimonial->thumbs() > 0)
    @if($testimonial->thumbs_up > $testimonial->thumbs_down)
    <h4 class="testimonial-{{$testimonial->id}} text-center">
        <i class="fa fa-thumbs-o-up"></i> <span class='thumbs-up-label'>{{$testimonial->thumbs_up}}</span>
        of <span class='thumbs-total-label'>{{$testimonial->thumbs()}}</span> {{trans('courses/general.found-this-review-very-helpful')}}
    </h4>
    @else
        <h4 class="testimonial-{{$testimonial->id}} text-center">
            <i class="fa fa-thumbs-o-down"></i> 
            <span class='thumbs-down-label'>{{$testimonial->thumbs_down}}</span>
            of  <span class='thumbs-total-label'>{{$testimonial->thumbs()}}</span> {{trans('courses/general.found-this-review-not-helpful')}}
        </h4>
    @endif
@else
    <h4 class="testimonial-{{$testimonial->id}}-placeholder text-center"><i class="fa fa-question-circle"></i> {{trans('courses/general.be-the-first-to-rate-this-review')}}</h4>
    <h4 class="testimonial-{{$testimonial->id}} text-center hidden">
        <i class="fa fa-thumbs-o-down"></i> <span class='thumbs-down-label'>{{$testimonial->thumbs_down}}</span>
        <i class="fa fa-thumbs-o-up"></i> <span class='thumbs-up-label'>{{$testimonial->thumbs_up}}</span>
        {{trans('courses/general.of')}}  <span class='thumbs-total-label'>{{$testimonial->thumbs()}}</span> 
        {{trans('courses/general.found-this-review')}}
        <span class='not-very'>{{trans('courses/general.very')}}</span> 
        {{trans('courses/general.helpful')}}
    </h4>
@endif-->
  <div class="reviews clearfix">
  	<div class="row no-margin">
          <div class="user-thumb col-xs-3 col-sm-2 col-md-2 col-lg-2">
                @if( $testimonial->student->profile != null)
                    <img src='{{ $testimonial->student->profile->photo }}' class="img-responsive" />
                @elseif($testimonial->student->photo != '')
                    <img src='{{ $testimonial->student->photo }}' class="img-responsive" />
                @else
                    <img src="{{cloudfrontUrl("//s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg")}}" class="img-responsive" />
                @endif
              <span>
              {{ $testimonial->student->first_name }}
              {{ $testimonial->student->last_name }}
              
              </span>
              <em class="recommendation recommends">Recommends</em>
          </div>
          <div class="user-review col-xs-9 col-sm-10 col-md-10 col-lg-10">
              <p class="regular-paragraph expandable-content">
                {{{ $testimonial->content }}}    株式会社GLOBAL POWER EXPERT代表取締役社長 / 通販エキスパートコーチ 経歴： 株式会社アクディア　代表取締役社長 / 株式会社ピーズ　代表取締役社長 / グローバルメディカル研究所株式会社　代表取締役社長 / RIZAP株式会社　取締役 / 株式会社GLOBAL POWER EXPERT 代表取締役社長 / 1974年千葉県生まれ。中学でアメリカンフットボールと出逢い、以降高校・大学・社会人実業団トップのXリーグに至るまで17年間プレイ。その間2チームにて主将を経験。組織プレイスポーツのトップリーダーとして活躍した。24歳の時に9億円もの借金を抱え父が他界。「金持ち父さん、貧乏父さん」（ロバートキヨサキ）の影響を受け 株式投資・自己投資に多額の資金を投入し、後にインターネットビジネスと出会う。情報販売、アフィリエイト等で月100万程度稼ぐも情熱が感じられずインフォプレナーを引退。その時に唯一残った「35歳でハワイに住む」という夢を追いかけ 自身が作成した目標達成法で3年早く達成。その後9億円の借金を独自の戦略と交渉術で13年間で解消。 夢を更に大きくするために当時社長が28歳で上場させた企業に一般社員として入社後 1ヶ月でグループ会社の幹部、そして3ヶ月後に社長に就任。他2社のグループ会社代表を経験。同時に化粧品ブランドのブランドオーナーを2期経験し通販のみで年間売上72億の事業にする。  メディアマーケティング、ダイレクトレスンポンスマーケティング、インバウンドマーケティング等インターネットだけに留まらず、あらゆる広告媒体を軸としたクロスメディアマーケティングを熟知。2014年4月に独立し同時に株式会社GLOBAL POWER EXPERT代表取締役に就任。 / 現在は、通販コンサル、コーチング、セミナー業、塾の運営、コンテンツ事業、通信販売業他様々な事業を手がけている。  自身の最大の強みは「事業会社での経験」と「人と違った行動」。BtoCビジネスを長く経験しており、インターネットだけでなくTV・紙媒体・ラジオ・交通広告等を使いモノやサービスを売るという経験が豊富。商品開発・マーケティング・クリエイティブ制作・広告購買・販売・CRM施策・ 顧客サービス・物流関連等、通販におけるあらゆる分野を経験しており、表面的な代理業等ではなく事業会社として生きた数字を取り扱ってきた。  また、企業文化の創造・育成・理念経営を行い部下の育成とともに会社を成長させることに従事。 社内外でもセミナー・コーチングをしており、 あらゆる視点から人とコミュニケーションをすることを得意とする。
       
              </p>
              <div class="fadeout-text"></div>
              <span class="view-more-reviews expandable-button show-more" data-less-text='Less' data-more-text='More'>{{ trans("courses/general.more") }} 
              </span>
              <form>
                  <div class="helpful-button-wrap clearfix">
                      <label for="helpful-button" class="">
                      	  <i class="fa fa-thumbs-up"></i>
                          Helpful
                      </label>
                      <input type="radio" id="helpful-button" class="hide" name="helpful-button">
                  </div>
              </form>
          </div>
      </div>
  </div>

<!-- <p>
     {{{ $testimonial->content }}}
 </p>
 <span class="name">
     {{ $testimonial->student->first_name }}
     {{ $testimonial->student->last_name }}
 </span>
 @if( Auth::check() )
        <h4 class="text-center">{{trans('courses/general.was-this-review-helpful')}}?</h4>
        <div class="text-center">
            <form method='post' class='inline-block ajax-form' action='{{action('TestimonialsController@rate')}}'
                  data-callback='ratedTestimonial' data-thumb='up' data-total='{{$testimonial->thumbs()}}' 
                data-up="{{$testimonial->thumbs_up}}" data-down="{{$testimonial->thumbs_down}}" data-testimonial-id='{{$testimonial->id}}'
                        @if( $testimonial->ratedBy( Auth::user() ) )
                            data-rated='{{$testimonial->current_user_rating->rating}}'
                        @endif
                        >
                        
                <button type='submit' name="rate-yes" class="btn btn-success"  data-testimonial-id='{{$testimonial->id}}'>
                    <i class="fa fa-thumbs-o-up"></i> {{trans('courses/general.yes')}}
                    @if( $testimonial->ratedBy( Auth::user() ) && $testimonial->current_user_rating->rating == 'positive' )
                        <i class="fa fa-check-circle-o"></i>
                    @endif
                </button>
                <input type="hidden" name="rating" value="positive" />
                <input type="hidden" name="testimonial_id" value="{{$testimonial->id}}" />
                <input type='hidden' name='_token' value='{{ csrf_token() }}' />
            </form>

            <form method='post' class='inline-block ajax-form' action='{{action('TestimonialsController@rate')}}'
                  data-callback='ratedTestimonial' data-thumb='down' data-total='{{$testimonial->thumbs()}}' 
                data-up="{{$testimonial->thumbs_up}}" data-down="{{$testimonial->thumbs_down}}" data-testimonial-id='{{$testimonial->id}}'
                        @if( $testimonial->ratedBy( Auth::user() ) )
                            data-rated='{{ $testimonial->current_user_rating->rating }}'
                        @endif
                        >
                <button type='submit'  name="rate-no" class="btn btn-danger"  data-testimonial-id='{{$testimonial->id}}'>
                    <i class="fa fa-thumbs-o-down"></i> {{trans('courses/general.no')}}
                    @if( $testimonial->ratedBy( Auth::user() ) && $testimonial->current_user_rating->rating == 'negative' )
                        <i class="fa fa-check-circle-o"></i>
                    @endif
                </button>
                <input type="hidden" name="rating" value="negative" />
                <input type="hidden" name="testimonial_id" value="{{$testimonial->id}}" />
                <input type='hidden' name='_token' value='{{ csrf_token() }}' />
            </form>
        </div>
 @endif
 <hr />
 
 -->