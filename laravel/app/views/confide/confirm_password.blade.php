@extends('layouts.default')
@section('content')
    <div class="container-fluid new-dashboard top-section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <h1>{{trans('general.confirm-password-to-continue')}}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard dashboardTabs-header">
        <div class="container">
        <div class="row">
        <div class="login-page">
            <div class="user-data-modal clearfix">
                <div class="user-data-modal-body">
                        <div class="form-container clearfix">
                            @if(Session::has('error'))
                                <p class='alert alert-danger'> {{Session::get('error')}}</p>
                            @endif
                        <form  role="form" method="POST" action="{{{ action('UsersController@doConfirmPassword') }}}" accept-charset="UTF-8">
                        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                            <fieldset>
                                <div class="form-group email-field">
                                    <input class="form-control" tabindex="1" placeholder="{{ trans('site/register.email-placeholder') }}" 
                                        data-placement="right"
                                        type="text" name="email" id="email" value="{{ Auth::user()->email }}">
                                </div>
                                <div class="form-group password-field">
                                    <input class="form-control" tabindex="2" pplaceholder="{{ trans('site/register.password-placeholder') }}" 
                                        type="password" name="password" id="password">
                                    <a href="{{{ action('UsersController@forgotPassword') }}}" 
                                    class="left forgot">{{ trans('site/login.forgot') }}</a>
                                </div>
                                @if (Session::get('notice'))
                                    <div class="alert">{{{ Session::get('notice') }}}</div>
                                @endif
                                <div class="form-group no-margin">
                                    <button tabindex="3" type="submit" class="blue-button large-button">
                                        {{ trans('general.confirm') }}
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
                
            </div>
        </div>
    </div>
@stop

@section('extra_js')
    <script src="{{url('plugins/uploader/js/jquery.fileupload.js')}}"></script>
    <script src="{{url('js/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            $('#btn-update-profile').on('click', function(){
                var $btn = $(this);
                $btn.button('loading');
                var $data = $('#form-profile').serialize();



                $('#errors-profile ul').html('');
                $.post('/profile/update-profile',$data, function ($response){
                    if ($response.success == 0){
                        for (var $errorKey in $response.errors){
                            $('#errors-profile ul').append('<li><i class="fa fa-exclamation"></i> '+ $response.errors[$errorKey] +'</li>');
                        }

                        $('#errors-profile').removeClass('hidden');
                    }
                    $btn.button('reset');
                },'json');
            });

            $('#btn-change-password').on('click', function(){
                var $data = $('#form-change-password').serialize();
                var $btn = $(this);
                $btn.button('loading');
                $('#errors-change-password ul').html('');
                $.post('/profile/change-password',$data, function ($response){
                    if ($response.success == 0){
                        for (var $errorKey in $response.errors){
                            $('#errors-change-password ul').append('<li><i class="fa fa-exclamation"></i> '+ $response.errors[$errorKey] +'</li>');
                        }

                        $('#errors-change-password').removeClass('hidden');

                    }
                    $btn.button('reset');
                },'json');
            });

            $('#btn-update-bank').on('click', function(){
                var $data = $('#form-update-bank').serialize();
                var $btn = $(this);
                $btn.button('loading');
                $('#errors-update-bank ul').html('');
                $.post('/profile/update-bank-details',$data, function ($response){
                    if ($response.success == 0){
                        for (var $errorKey in $response.errors){
                            $('#errors-update-bank ul').append('<li><i class="fa fa-exclamation"></i> '+ $response.errors[$errorKey] +'</li>');
                        }

                        $('#errors-update-bank').removeClass('hidden');

                    }

                    $btn.button('reset');
                },'json');
            });

            $('#btn-update-info').on('click', function(){
                var $data = $('#form-update-info').serialize();
                var $btn = $(this);
                $btn.button('loading');
                $('#errors-update-info ul').html('');
                $.post('/profile/update-other-info',$data, function ($response){
                    if ($response.success == 0){
                        for (var $errorKey in $response.errors){
                            $('#errors-update-info ul').append('<li><i class="fa fa-exclamation"></i> '+ $response.errors[$errorKey] +'</li>');
                        }

                        $('#errors-update-info').removeClass('hidden');

                    }

                    $btn.button('reset');
                },'json');
            });

            $('#upload-new-photo').fileupload()
                    .bind('fileuploadprogress', function ($e, $data){
                        var $progress = parseInt($data.loaded / $data.total * 100, 10);
                        console.log($progress);
                    })
                    .bind('fileuploaddone',function ($e,$data){
                        if ($data.result.success == 1){
                            $('#img-profile-picture').attr('src',$data.result.photo_url);
                        }
            });

            $('input[name=zip]').mask('999-9999');

        });
    </script>
@stop
