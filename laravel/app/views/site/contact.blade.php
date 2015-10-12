@extends('layouts.default')
@section('content')
<section class="container-fluid contact-us header">
	<div class="container">
    	<h2>{{ trans('site/contact.contact-us')}}</h2>
    </div>
</section>

<section class="container-fluid contact-us main">
    <form method='post' data-parsley-validate action='{{ url('contact-confirmation') }}'>
	<div class="container">
                <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <label class="required-tip right">*必須項目</label>
                    </div>
                </div>
                <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <label class="no-margin-top">{{ trans('site/contact.type-of-question')}}<sup>*</sup> </label>
                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-6 col-lg-6">
                        <div class="radio-buttons clearfix relative">
                            <div class="radio-item">
                                <div class="radio-checkbox radio-checked">
                                    <input type='radio' name='user' value='{{ trans('site/contact.student')}}' id='user-1' required />
                                    <label for="user-1" class="small-radio"></label>
                                </div>
                                <span class="radio-button-label">{{ trans('site/contact.student')}}</span>
                            </div>
                            <div class="radio-item">
                                <div class="radio-checkbox radio-checked">
                                    <input type='radio' name='user' value='{{ trans('site/contact.instructor')}}' id='user-2' />
                                    <label for="user-2" class="small-radio"></label>
                                </div>
                                <span class="radio-button-label">{{ trans('site/contact.instructor')}}</span>
                            </div>
                            <div class="radio-item">
                                <div class="radio-checkbox radio-checked">
                                    <input type='radio' name='user' value='{{ trans('site/contact.affiliate')}}' id='user-3' />
                                    <label for="user-3" class="small-radio"></label>
                                </div>
                                <span class="radio-button-label">{{ trans('site/contact.affiliate')}}</span>
                            </div>
                            <div class="radio-item">
                                <div class="radio-checkbox radio-checked">
                                    <input type='radio' name='user' value='{{ trans('site/contact.other')}}' id='user-4' />
                                    <label for="user-4" class="small-radio"></label>
                                </div>
                                <span class="radio-button-label">{{ trans('site/contact.other')}}</span>
                            </div>



                        </div>
                    </div>
                </div>
                <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <label>{{ trans('site/contact.type-of-issue')}} <sup> *</sup></label>
                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-5 col-lg-5">
                        <select name='question_type' required data-parsley-error-message="この値は必須です。" data-parsley-minlength="1">
                                <option value="">ご質問内容をお選びください。</option>
                                <option value="Wazaarの使い方">Wazaarの使い方</option>
                                <option value="会員登録">会員登録</option>
                                <option value="講座受講">講座受講</option>
                                <option value="動画配信">動画配信</option>
                                <option value="取材のご依頼">取材のご依頼</option>
                                <option value="その他">その他</option>
                                <option value="Wazaarへのリクエストなど">Wazaarへのリクエストなど</option>
                        </select>
                    </div>
                </div>
                <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <label>{{ trans('site/contact.your-name')}} <sup> *</sup></label>
                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-5 col-lg-5">
                        <input type="text" name='name' placeholder="{{ trans('site/contact.enter-name') }}" required />
                    </div>
                </div>
                <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <label>{{ trans('site/contact.email')}} <sup> *</sup></label>

                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-5 col-lg-5">
                        <input type="email" name='email' placeholder="Email" required data-parsley-trigger="change" />

                     </div>
                </div>
                <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <label>{{ trans('site/contact.subject')}}</label>

                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-5 col-lg-5">
                        <input type="text" name='subject' placeholder="{{ trans('site/contact.enter-subject') }}" required />

                    </div>
                </div>
                <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <label>{{ trans('site/contact.message')}}</label>

                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-5 col-lg-5">
                        <textarea name='message' placeholder="{{ trans('site/contact.enter-message') }}" required></textarea>
                    </div>
                </div>
                <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-5 col-lg-5">
                        <button type='submit' class="large-button blue-button send">{{ trans('site/contact.submit')}}</button>
                    </div>
                </div>
        </div>
    </form>
</section>
@stop