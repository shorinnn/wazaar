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
                        <label>{{ trans('site/contact.type-of-question')}}</label>
                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                        <div>
                            <input type='radio' name='user' value='{{ trans('site/contact.student')}}' id='user-1' required /> {{ trans('site/contact.student')}}
                            <input type='radio' name='user' value='{{ trans('site/contact.instructor')}}' id='user-2' /> {{ trans('site/contact.instructor')}}
                            <input type='radio' name='user' value='{{ trans('site/contact.affiliate')}}' id='user-3' /> {{ trans('site/contact.affiliate')}}
                            <input type='radio' name='user' value='{{ trans('site/contact.other')}}' id='user-4' /> {{ trans('site/contact.other')}}
                        </div>
                    </div>
                </div>
                <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <label>{{ trans('site/contact.type-of-issue')}}</label>
                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                        <select name='question_type' required data-parsley-error-message="この値は必須です。" data-parsley-minlength="1">
                                <option value="ご質問内容をお選びください。">ご質問内容をお選びください。</option>
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
                    <label>{{ trans('site/contact.your-name')}}</label>
                </div>
                <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                    <input type="text" name='name' placeholder="{{ trans('site/contact.enter-name') }}" required />
                </div>
            </div>
                    <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <label>{{ trans('site/contact.email')}}</label>

                </div>
                <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                    <input type="email" name='email' placeholder="Email" required data-parsley-trigger="change" />

                </div>
            </div>
                    <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <label>{{ trans('site/contact.subject')}}</label>

                </div>
                <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                    <input type="text" name='subject' placeholder="{{ trans('site/contact.enter-subject') }}" required />

                </div>
            </div>
                    <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <label>{{ trans('site/contact.message')}}</label>

                </div>
                <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                    <textarea name='message' placeholder="{{ trans('site/contact.enter-message') }}" required></textarea>
                </div>
            </div>
                    <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

                </div>
                <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                    <button type='submit' class="large-button blue-button send">{{ trans('site/contact.submit')}}</button>
                </div>
            </div>
        </div>
    </form>
</section>
@stop