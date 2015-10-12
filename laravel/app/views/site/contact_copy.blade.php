@extends('layouts.default')
@section('content')
<section class="container-fluid contact-us header">
	<div class="container">
    	<h2>お問い合わせ</h2>
    </div>
</section>

<section class="container-fluid contact-us main">
	<div class="container">
		<div class="row input-row">
		    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <span class="required-tip right">*必須項目</span>
            </div>
		</div>
		<div class="row input-row">
		    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <span class="right">どのようなタイプの質問ですか？ <sup>*</sup></span>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-6 col-lg-6">
                <div class="radio-buttons clearfix">
                    <div class="radio-item">
                      <div class="radio-checkbox radio-checked">
                        <input name="radio-button" id="radio-1" autocomplete="off" checked="checked" type="radio">
                        <label for="radio-1" class="small-radio"></label>
                      </div>
                      <span class="radio-button-label">受講生</span>
                    </div><!-- end radio item -->
                    <div class="radio-item">
                      <div class="radio-checkbox">
                        <input id="radio-2" autocomplete="off" name="radio-button" type="radio">
                        <label for="radio-2" class="small-radio"></label>
                      </div>
                      <span class="radio-button-label">講師</span>
                    </div><!-- end radio item -->
                    <div class="radio-item">
                      <div class="radio-checkbox radio-checked">
                        <input name="radio-button" id="radio-3" autocomplete="off" type="radio">
                        <label for="radio-3" class="small-radio"></label>
                      </div>
                      <span class="radio-button-label">アフィリエイター</span>
                    </div><!-- end radio item -->
                    <div class="radio-item">
                      <div class="radio-checkbox">
                        <input id="radio-4" autocomplete="off" name="radio-button" type="radio">
                        <label for="radio-4" class="small-radio"></label>
                      </div>
                      <span class="radio-button-label">その他</span>
                    </div><!-- end radio item -->
                </div>
            </div>
		</div>
		<div class="row input-row">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            	<label>どのようなご質問ですか？ <sup> *</sup></label>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-5 col-lg-5">
            	<select>
                	<option>ご質問内容をお選びください。</option>
                	<option>Wazaarの使い方</option>
                	<option>会員登録</option>
                	<option>講座受講</option>
                	<option>動画配信</option>
                	<option>取材のご依頼</option>
                	<option>その他</option>
                	<option>Wazaarへのリクエストなど</option>
                </select>
            </div>
        </div>
		<div class="row input-row">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            	<label>お名前 <sup> *</sup></label>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-5 col-lg-5">
            	<input type="text" placeholder="姓">
            </div>
        </div>
		<div class="row input-row">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            	<label>メールアドレス <sup> *</sup></label>

            </div>
            <div class="col-xs-12 col-sm-7 col-md-5 col-lg-5">
            	<input type="text" placeholder="Email">

            </div>
        </div>
		<div class="row input-row">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            	<label>件名</label>

            </div>
            <div class="col-xs-12 col-sm-7 col-md-5 col-lg-5">
            	<input type="text" placeholder="上記でその他を選択した方は、ご用件を入力してください。">

            </div>
        </div>
		<div class="row input-row">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            	<label>内容</label>

            </div>
            <div class="col-xs-12 col-sm-7 col-md-5 col-lg-5">
            	<textarea placeholder="詳しいご質問事項をいただけますと、ご回答もスムーズです。"></textarea>
            </div>
        </div>
		<div class="row input-row">
        	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

            </div>
            <div class="col-xs-12 col-sm-7 col-md-5 col-lg-5">
            	<button class="large-button blue-button clear">書き直す</button>
            	<button class="large-button blue-button confirmation">確認する</button>
            </div>
        </div>
    </div>
</section>

@stop