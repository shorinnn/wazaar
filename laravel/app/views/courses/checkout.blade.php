<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('page_title') Wazaar</title>    
    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{url('css/style.css')}}">
    <link rel="stylesheet" href="{{url('css/generic.css')}}">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <html class="ie8">
    <![endif]-->
    
    
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
    	<header class="container-fluid checkout-header">
            <div class="row">
                <div class="top-menu clearfix col-md-12">
                    <a href="{{ action('SiteController@index') }}" class="main-logo">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" 
                       class="img-responsive" alt=""></a>
                    <h1>Checkout</h1>
            	</div>
        	</div>
        </header>
        <section class="container-fluid checkout-page">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-1 col-lg-1 hidden-xs hidden-sm"></div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 customer-info">
                    	<h1>
                        	<span class="step-number">1</span>
                            Your Billing Info
                        </h1>
                        <form>
                            <div class="row margin-top-20">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                	<label>first name</label>
                                    <input type="text" name="first_name" class="margin-bottom-10">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                	<label>last name</label>
                                    <input type="text" name="last_name">                                
                                </div>
                            </div>
                            <div class="row margin-top-30">
                            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                	<label>Address</label>
                                    <input type="text" name="address_1" placeholder="Address line 1" class="margin-bottom-10">
                                    <input type="text" name="address_2" placeholder="Address line 2">
                                </div>
                            </div>
                            <div class="row margin-top-30">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                	<label>postal code</label>
                                    <input type="text" name="postal_code" class="margin-bottom-10">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                	<label>country</label>
                                    <select>
                                    	<option>Select country</option>
                                    </select>                                
                                </div>
                            </div>
                            <h1>
                            	<span class="step-number">2</span>
                                Credit Card Info
                            </h1>
                            <div class="row margin-top-20">
                            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                	<label>Credit Card number</label>
                                    <input type="text" name="credit_card_number" placeholder="0000 0000 0000 0000">
                                </div>
                            </div>
                            <div class="row margin-top-30">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                	<label>CVV Code</label>
                                    <input type="text" name="cvv_code" class="margin-bottom-10">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                	<label>Expiry date</label>
									<input type="text" name="expiry_date" placeholder="MM / YY">                                
                                </div>
                            </div>
                            <div class="row margin-top-30">
                            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                	<label>Name on the card</label>
                                    <input type="text" name="name_on_card">
                                </div>
                            </div>
                            <div class="row">
                            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                	<a href="#" class="blue-button large-button place-your-order hidden-xs hidden-sm">Place your order</a>
                                </div>
                            </div>
                        </form>
                    </div>
                	<div class="col-md-1 col-lg-1 hidden-xs hidden-sm"></div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 product-info">
                        <h1>
                            You are buying:
                        </h1>              
                        <div class="row">
                        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 course-name">
                            	<div class="row">
                                	<div class="col-xs-5 col-sm-3 col-md-5 col-lg-5">
                                        <figure class="course-thumb">
                                        
                                        </figure>
                                    </div>
                                	<div class="col-xs-7 col-sm-9 col-md-7 col-lg-7 no-padding">
                                        <div>
                                            <p class="regular-paragraph">Welcome to Markting in a Digital World</p>
                                            <span class="regular-paragraph">13 lessons</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row product-price">
                        	<span class="regular-paragraph">Price:</span>
                            <p>¥ 7,200</p>
                            <a href="#" class="blue-button extra-large-button place-your-order">Place your order</a>
                            <small class="regular-paragraph">By clicking the "Place your order" button, you agree to these 
                            	<a href="#">Terms of Service.</a>
                            </small>
                            <em class="regular-paragraph"><i class="fa fa-lock"></i>Secure Connection</em>
                        </div>      
                    </div>
                </div>
            </div>
        </section>
	</div>
    <script src="{{url("js/jquery.min.js")}}"></script>
    <script src="{{url("js/bootstrap.min.js")}}"></script>
    <script src="{{url("js/jquery.bootstrap-growl.min.js")}}"></script>
    <script src="{{url("js/lang/parsley/".Config::get('app.locale').".js")}}" /></script>
    <script src="{{url("js/parsley.min.js")}}"></script>
    <script src="{{url("js/forms.js")}}"></script>
    <script src="{{url("js/validations.js")}}"></script>
    <script src="{{url("js/courses.js")}}"></script>
    <script src="{{url("js/cocoriumTracker.js")}}"></script>
    <script src="{{url("js/Sortable.min.js")}}"></script>
    <script src="{{url("js/pluralize.js")}}"></script>
    <script src="{{url("js/main.js")}}"></script>
    <script src="{{url("js/messages.js")}}"></script>
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    <script src="http://www.localeplanet.com/api/translate.js" /></script>
    <script src="{{url("js/lang/".Config::get('app.locale').".js")}}" /></script>
    <script src="{{url("js/jquery.tinycarousel.js")}}"></script>
    
    <script src="{{url("plugins/zero-clipboard/ZeroClipboard.min.js")}}"></script>
    <script type="text/javascript" src="{{url('js/bootbox.js')}}"></script>

</body>
</html>