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
		}
	</style>
    <div class="alert-message container error-page">
    	<div class="row">
        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
            	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/error-page-icon.png" class="img-responsive right">
            </div>
            <div class="col-xs-8 col-sm-8 col-md-6 col-lg-6">
            	<h1>Request error</h1>
                <h2>We are sorry, but there was a problem serving your requested page. </h2>
                <p>This may be temporary, so please try to refresh a page, the problem may be temporary.</p>
                <p>If it doesn’t help, please come back in few minutes.</p>
                <p>We will do our best to selve this as soon as possible. </p>	
            </div>
        </div>
    </div>
    @stop