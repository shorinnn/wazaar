@extends('layouts.default')
@section('content')	
	<style>
		.footer-search{
			display: none;
		}
		.logged-out-header-search{
			display: none;
		}
		html, body{
			background: #e8eced;
		}
		h1{
			margin: 0 0 25px;
			font-weight: 600;
			font-size: 40px;
			text-transform: uppercase;
		}
		h2{
			line-height: 26px;
			font-size: 20px;
			color: #303941;
		}
		p{
			font-size: 15px;
			color: #8191a1;
			margin: 0 0 13px;
			line-height: 22px;
		}
		.error-page{
			margin-top: 140px;
			margin-bottom: 100px;
		}
		.link-to-index{
			color: #0099ff;
			margin-top: 20px;
			display: block;
		}
		.link-to-index:hover{
			color: #0099ff;
		}
	</style>
    <div class="container error-page">
    	<div class="row">
        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
            	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/error-page-icon.png" class="img-responsive right">
            </div>
            <div class="col-xs-8 col-sm-8 col-md-6 col-lg-6">
            	<!--<h1>Request error</h1>-->
                <h2 class="no-margin">何かお探しですか？
					<span class="block">入力したURLが当サイトのページと一致しません。</span></h2>
				<a href="{{ action('SiteController@index') }}" class="link-to-index">Wazaar.jp トップページ</a>
            </div>
        </div>
    </div>
@stop