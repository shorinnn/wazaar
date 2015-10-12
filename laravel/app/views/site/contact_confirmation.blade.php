@extends('layouts.default')
@section('content')

<!-- Confirmation page -->
<section class="container-fluid contact-us header">
	<div class="container">
    	<h2>お問い合わせ</h2>
    </div>
</section>

<section class="container-fluid privacy-policy main contact-confirmation">
    <div class="container extra-policy">
    	<div class="row no-margin no-border">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 left-column">
        	    <p>どのようなタイプの質問ですか？</p>
            </div>
        	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 right-column">
        	    <p>{{ Input::get('user') }}</p>
            </div>
        </div>
    	<div class="row no-margin">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 left-column">
        	    <p>どのようなご質問ですか？</p>
            </div>
        	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 right-column">
        	    <p>{{ Input::get('question_type') }}</p>
            </div>
        </div>
<!--    	<div class="row no-margin">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 left-column">
        	    <p></p>
            </div>
        	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 right-column">
        	    <p>お支払いについて</p>
            </div>
        </div>-->
    	<div class="row no-margin">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 left-column">
        	    <p>お名前</p>
            </div>
        	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 right-column">
        	    <p>{{ Input::get('name') }}</p>
            </div>
        </div>
    	<div class="row no-margin">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 left-column">
        	    <p>メールアドレス</p>
            </div>
        	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 right-column">
        	    <p>{{ Input::get('email') }}</p>
            </div>
        </div>
    	<div class="row no-margin">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 left-column">
        	    <p>件名</p>
            </div>
        	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 right-column">
        	    <p>{{ Input::get('subject') }}</p>
            </div>
        </div>
    	<div class="row no-margin">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 left-column">
        	    <p>内容</p>
            </div>
        	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 right-column">
        	    <p>{{ Input::get('message') }}</p>
            </div>
        </div>
    </div>
    <div class="container no-padding margin-bottom-30">
		<div class="row input-row">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

            </div>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-center">
                <form method='post' action='contact'>
                    <button class="large-button blue-button clear" onclick="window.history.back()">書き直す</button>
                    <input type='hidden' name='user' value='{{Input::get('user')}}' />
                    <input type='hidden' name='question_type' value='{{Input::get('question_type')}}' />
                    <input type='hidden' name='name' value='{{Input::get('name')}}' />
                    <input type='hidden' name='email' value='{{Input::get('email')}}' />
                    <input type='hidden' name='subject' value='{{Input::get('subject')}}' />
                    <input type='hidden' name='message' value='{{Input::get('message')}}' />
                    <button type='submit' class="large-button blue-button confirmation">確認する</button>
                </form>
            </div>
        </div>
    </div>
</section>

@stop